<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password - Bizgrow</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Sign in.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="form-container">
            <h2>Password Baru</h2>
            <p>Buatlah password baru untuk akun anda.</p>
            <form id="forgotPasswordForm">
                @csrf
                <input type="hidden" id="token" value="{{ request()->query('token') }}">
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Isi Password Baru" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="passwordConfirm" name="password" class="form-control"
                        placeholder="Isi Konfirmasi Password Baru" required>
                    <div id="passwordError" class="text-danger mt-1" style="display: none;"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Perbarui Password</button>
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

    <!-- Modal untuk Login Berhasil -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Login Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="successMessage">
                    <!-- Pesan sukses -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Login Gagal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Login Gagal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorMessage">
                    <!-- Pesan error -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Coba Lagi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/reset_password.js') }}"></script>

</body>

</html>
