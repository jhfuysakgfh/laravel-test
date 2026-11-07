<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Get the original request body
        $payload = $request->getContent();

        // 2. Get Razorpay's signature
        $signature = $request->header('X-Razorpay-Signature');

        if (!$signature) {
            return response()->json([
                'success' => false,
                'message' => 'Webhook signature is missing.',
            ], 400);
        }

        // 3. Generate our own signature
        $expectedSignature = hash_hmac(
            'sha256',
            $payload,
            config('services.razorpay.webhook_secret')
        );

        // 4. Verify Razorpay's signature
        if (!hash_equals($expectedSignature, $signature)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook signature.',
            ], 400);
        }

        // 5. Decode the verified JSON payload
        $data = json_decode($payload, true);

        if (!is_array($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook payload.',
            ], 400);
        }

        // 6. Process payment captured event
        if ($data['event'] === 'payment.captured') {

            $entity = $data['payload']['payment']['entity'] ?? null;

            if (!$entity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment details missing.',
                ], 400);
            }

            // 7. Find our payment using Razorpay order ID
            $payment = Payment::where(
                'razorpay_order_id',
                $entity['order_id'] ?? ''
            )->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment order not found.',
                ], 404);
            }

            // 8. Verify amount and currency
            $expectedAmount = (int) round($payment->amount * 100);

            if (
                (int) ($entity['amount'] ?? 0) !== $expectedAmount ||
                ($entity['currency'] ?? '') !== config('services.razorpay.currency') ||
                ($entity['status'] ?? '') !== 'captured'
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment details do not match.',
                ], 400);
            }

            // 9. Update database safely
            DB::transaction(function () use ($payment, $entity) {

                $lockedPayment = Payment::whereKey($payment->id)
                    ->lockForUpdate()
                    ->first();

                // Avoid processing an already completed payment again
                if ($lockedPayment->status === 'paid') {
                    return;
                }

                $lockedPayment->update([
                    'razorpay_payment_id' => $entity['id'],
                    'method' => $entity['method'] ?? null,
                    'status' => 'paid',
                ]);
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Webhook processed successfully.',
        ]);
    }
}