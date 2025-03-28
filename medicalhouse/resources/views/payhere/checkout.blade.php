<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayHere...</title>
</head>
<body>
    <p>Redirecting to PayHere. Please wait...</p>

    <form method="POST" action="https://sandbox.payhere.lk/pay/checkout" id="payhere-form">
        <input type="hidden" name="merchant_id" value="{{ config('services.payhere.merchant_id') }}">

        <input type="hidden" name="notify_url" value="{{ url('/payhere/notify') }}">
        <input type="hidden" name="return_url" value="{{ route('thank.you') }}">
        <input type="hidden" name="cancel_url" value="{{ route('payment.cancelled') }}">

        <input type="hidden" name="order_id" value="{{ $order_id }}">
        <input type="hidden" name="items" value="Doctor Appointment">
        <input type="hidden" name="currency" value="LKR">
        <input type="hidden" name="amount" value="{{ $amount }}">

        <input type="hidden" name="first_name" value="{{ $patient_name }}">
        <input type="hidden" name="last_name" value="-">
        <input type="hidden" name="email" value="noemail@mh.lk">
        <input type="hidden" name="phone" value="{{ $contact_no }}">
        <input type="hidden" name="address" value="N/A">
        <input type="hidden" name="city" value="Colombo">
        <input type="hidden" name="country" value="LK">

    </form>

    <script>
        setTimeout(() => {
            const form = document.getElementById('payhere-form');
            if (form) {
                form.submit();
                console.log("Submitted to PayHere");
            } else {
                console.error("PayHere form not found!");
            }
        }, 100); // slight delay helps in some browsers
    </script>
</body>
</html>
