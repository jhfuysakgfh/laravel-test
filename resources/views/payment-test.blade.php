<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment Test</title>
</head>
<body>

    <h2>Razorpay Test Payment</h2>

    <p>Amount: ₹{{ $payment->amount }}</p>

    <button id="pay-button">Pay Now</button>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        const options = {
            key: @json(config('services.razorpay.key')),

            amount: {{ (int) round($payment->amount * 100) }},

            currency: @json(config('services.razorpay.currency')),

            name: "Laravel Test Project",

            description: "Payment Gateway Testing",

            order_id: @json($payment->razorpay_order_id),

            handler: function (response) {
                console.log(response);

                alert("Payment completed! Check the browser console.");
            },

            theme: {
                color: "#3399cc"
            }
        };

        const razorpay = new Razorpay(options);

        document.getElementById('pay-button').onclick = function () {
            razorpay.open();
        };
    </script>

</body>
</html>