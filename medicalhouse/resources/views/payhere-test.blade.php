<!DOCTYPE html>
<html>
<head>
    <title>PayHere Test</title>
</head>
<body>
    <form method="POST" action="https://sandbox.payhere.lk/pay/checkout" id="payhere-form">
        <input type="hidden" name="merchant_id" value="1229940">
        <input type="hidden" name="return_url" value="http://dev.local/thank-you">
        <input type="hidden" name="cancel_url" value="http://dev.local/payment-cancelled">
        <input type="hidden" name="notify_url" value="http://dev.local/payhere/notify">

        <input type="hidden" name="order_id" value="ORDER123TEST">
        <input type="hidden" name="items" value="Test Item">
        <input type="hidden" name="currency" value="LKR">
        <input type="hidden" name="amount" value="1000">

        <input type="hidden" name="first_name" value="Dewmini">
        <input type="hidden" name="last_name" value="C">
        <input type="hidden" name="email" value="dewmini@example.com">
        <input type="hidden" name="phone" value="0771234567">
        <input type="hidden" name="address" value="Somewhere">
        <input type="hidden" name="city" value="Colombo">
        <input type="hidden" name="country" value="Sri Lanka">

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
