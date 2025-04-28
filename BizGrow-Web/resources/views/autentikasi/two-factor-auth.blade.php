<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2 Factor Authentication - BizGrow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>

<body>
    <div class="signup-container">
        <div class="form-container">
            <h2>Two-Factor Authentication</h2>
            <p class="text-center">Masukkan kode dari aplikasi autentikasi</p>
            <form id="authform" method="GET" action="{{ route('home') }}">
                <div class="mb-3">
                    <input type="text" name="authcode" id="authcode" class="form-control" placeholder="Kode Autentikasi" required>
                </div>
                <button type="submit" class="btn btn-primary">Verifikasi</button>
            </form>
            {{-- back to logging in page --}}
            <p class="mt-3">Kembali ke <a href="{{ route('login') }}">Sign In</a></p>
        </div>
        
        <div class="image-container">
            <img src="{{ asset('images/Sign in.png') }}" alt="bizgrowlogo">
            <div class="overlay-logo">
                <img src="{{ asset('images/logo1.png') }}" alt="BizGrow Logo">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../assets/js/input_file.js"></script>
</body>

</html>
