<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Pizgrow</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Sign in.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="form-container">
            <h2>Lupa Password</h2>
            <p>Masukkan email Anda untuk menerima link reset password.</p>
            <form id="forgotPasswordForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Isi Email"
                        required>
                    <div id="emailError" class="text-danger mt-1" style="display: none;"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
            </form>
            <div id="successMessage" class="alert alert-success mt-3" style="display: none;"></div>
            <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;"></div>
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
    <script>
        $(document).ready(function() {
            $('#forgotPasswordForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                // Reset pesan sebelumnya
                $('#emailError').hide().text('');
                $('#successMessage').hide().text('');
                $('#errorMessage').hide().text('');

                // Ambil data form
                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}'); // Tambahkan CSRF token

                // Kirim permintaan AJAX
                $.ajax({
                    url: '/api/forgot-password', // Endpoint API
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Tampilkan pesan sukses
                        $('#successMessage').text(response.message).show();
                        $('#forgotPasswordForm')[0].reset(); // Reset form
                    },
                    error: function(xhr) {
                        // Tangani error
                        let errorMessage = xhr.responseJSON?.message ||
                            'Terjadi kesalahan. Silakan coba lagi.';
                        if (xhr.responseJSON?.errors?.email) {
                            $('#emailError').text(xhr.responseJSON.errors.email[0]).show();
                        } else {
                            $('#errorMessage').text(errorMessage).show();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
