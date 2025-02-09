<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- Axios -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- ✅ FIX: Add CSRF Token -->
    <style>
        .vf-body-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .vf-form-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .vf-form-container h1 {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .vf-form-container label {
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
        }

        .vf-form-container input,
        .vf-form-container button {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .vf-form-container button {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .vf-form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="vf-body-container">
        <div class="vf-form-container">
            <h1>Verify OTP</h1>
            <form id="otp-form">
                @csrf
                <label for="otp">Enter OTP:</label>
                <input type="text" name="otp" id="otp" maxlength="6" required>

                <button type="button" id="verify-otp">Verify</button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('verify-otp').addEventListener('click', function (event) {
        event.preventDefault(); // ✅ Prevent default form submission

        const otp = document.getElementById('otp').value;
        const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');

        if (!csrfTokenElement) {
            console.error('CSRF token meta tag is missing.');
            alert('Security error: CSRF token is missing. Please refresh and try again.');
            return;
        }

        const csrfToken = csrfTokenElement.getAttribute('content');

        axios.post('/verifythe-otp', { otp: otp }, {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (response.data.verified) {
                alert(response.data.message);
                window.location.href = response.data.redirect || '/select-payment'; // ✅ Redirect properly
            } else {
                alert(response.data.message); // Show error message
            }
        })
        .catch(error => {
            console.error('Error verifying OTP:', error.response ? error.response.data : error.message);
            alert('Failed to verify OTP. Please try again.');
        });
    });
</script>
</body>
</html>
