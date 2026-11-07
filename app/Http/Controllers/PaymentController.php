<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        // 1. Validate payment amount
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
        ]);

        // 2. Get Razorpay credentials
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        // 3. Convert INR to paise
        // Razorpay expects amount in the smallest currency unit.
        $amountInPaise = (int) round($validated['amount'] * 100);

        // 4. Create order on Razorpay
        $order = $api->order->create([
            'receipt' => 'receipt_' . uniqid(),
            'amount' => $amountInPaise,
            'currency' => config('services.razorpay.currency', 'INR'),
        ]);

        // 5. Save order in our database
        $payment = Payment::create([
            'user_id' => $request->user()->id,
            'razorpay_order_id' => $order['id'],
            'amount' => $validated['amount'],
            'status' => 'created',
        ]);

        // 6. Return order details
        return response()->json([
            'success' => true,
            'message' => 'Payment order created successfully.',
            'data' => [
                'payment_id' => $payment->id,
                'razorpay_order_id' => $order['id'],
                'amount' => $validated['amount'],
                'amount_in_paise' => $amountInPaise,
                'currency' => $order['currency'],
                'razorpay_key' => config('services.razorpay.key'),
            ],
        ], 201);
    }

    public function verifyPayment(Request $request)
    {
        // 1. Validate Razorpay response
        $validated = $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        // 2. Find payment belonging to logged-in user
        $payment = Payment::where('razorpay_order_id', $validated['razorpay_order_id'])
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment order not found.',
            ], 404);
        }

        // 3. Generate expected signature
        $generatedSignature = hash_hmac(
            'sha256',
            $validated['razorpay_order_id'] . '|' . $validated['razorpay_payment_id'],
            config('services.razorpay.secret')
        );

        // 4. Verify signature
        if (!hash_equals($generatedSignature, $validated['razorpay_signature'])) {
            return response()->json([
                'success' => false,
                'message' => 'Payment signature verification failed.',
            ], 400);
        }

        // 5. Fetch actual payment details from Razorpay
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $razorpayPayment = $api->payment->fetch(
            $validated['razorpay_payment_id']
        );

        // 6. Verify order ID
        if ($razorpayPayment['order_id'] !== $payment->razorpay_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Payment order mismatch.',
            ], 400);
        }

        // 7. Verify amount
        $expectedAmount = (int) round($payment->amount * 100);

        if ((int) $razorpayPayment['amount'] !== $expectedAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Payment amount mismatch.',
            ], 400);
        }

        // 8. Verify currency
        if ($razorpayPayment['currency'] !== config('services.razorpay.currency')) {
            return response()->json([
                'success' => false,
                'message' => 'Payment currency mismatch.',
            ], 400);
        }

        // 9. Save actual payment details
        $payment->update([
            'razorpay_payment_id' => $validated['razorpay_payment_id'],
            'method' => $razorpayPayment['method'],
            'status' => $razorpayPayment['status'] === 'captured'
                ? 'paid'
                : $razorpayPayment['status'],
        ]);

        // 10. Return response
        return response()->json([
            'success' => true,
            'message' => 'Payment details fetched and verified.',
            'data' => $payment->fresh(),
        ]);
        
    }
}
