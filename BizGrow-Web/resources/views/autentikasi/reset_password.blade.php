<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Bizgrow</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Sign in.css') }}"> <!-- Reuse CSS dari signin jika cocok -->
</head>

<body>
    <div class="login-container">
        <div class="form-container">
            <h2>Reset Password</h2>
            <p>Masukkan password baru anda disini.</p>
            <form id="forgotPasswordForm">
                @csrf
                <div class="mb-3">
                    <label for="password" class="form-label">Password baru</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Isi Email"
                        required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
            </form>
            <p class="mt-3">Kembali ke <a href="{{ route('login') }}">Sign In</a></p>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/Sign in.png') }}" alt="bizgrowlogo">
            <div class="overlay-logo">
                <img src="{{ asset('images/logo1.png') }}" alt="Pizgrow Logo">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/Signin.js') }}"></script>
</body>

</html>
