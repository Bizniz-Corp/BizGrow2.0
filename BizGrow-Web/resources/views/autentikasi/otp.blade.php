<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukkan OTP - BizGrow</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>

<body>
    <div class="signup-container">
        <div class="form-container">
            <h2>Masukkan OTP</h2>
            <p>Kode OTP telah dikirim ke email Anda. Masukkan kode di bawah ini.</p>
            <form id="otpForm" method="GET" action="{{ route('home') }}">
                <div class="mb-3">
                    <label for="otp" class="form-label">Kode OTP</label>
                    <input type="text" name="otp" id="otp" class="form-control" placeholder="Masukkan OTP" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verifikasi OTP</button>
            </form>
            <p class="mt-3">Kembali ke <a href="{{ route('register') }}">Sign Up</a></p>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/Sign in.png') }}" alt="bizgrowlogo">
            <div class="overlay-logo">
                <img src="{{ asset('images/logo1.png') }}" alt="BizGrow Logo">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/SignUp.js') }}"></script>
</body>

</html>
