<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Payment Method</title>
    <style>
        .ps-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .ps-form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .ps-form-container h2 {
            margin-bottom: 1rem;
        }

        .ps-form-container button {
            display: block;
            width: 100%;
            padding: 1rem;
            margin: 0.5rem 0;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .ps-btn-pay-now {
            background-color: #28a745;
            color: white;
        }

        .ps-btn-pay-counter {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="ps-container">
        <div class="ps-form-container">
            <h2>Select Payment Method</h2>
            <form id="payment-form" method="POST" action="{{ route('appointments.process-payment') }}">
                @csrf
                <input type="hidden" name="payment_method" id="payment-method">
                <input type="hidden" name="appointment_status" value="Online">

                <button type="button" class="ps-btn-pay-now" onclick="setPaymentMethod('Done')">Pay Now</button>
                <button type="submit" class="ps-btn-pay-counter" onclick="setPaymentMethod('Pending')">Pay at Counter</button>
            </form>
        </div>
    </div>

    <script>
        function setPaymentMethod(status) {
            document.getElementById('payment-method').value = status;
            document.getElementById('payment-form').submit(); // ✅ Submit Form
        }
    </script>
</body>
</html>
