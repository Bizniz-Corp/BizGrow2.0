<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BizGrow</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>

<body>
    <div class="signup-container">
        <div class="form-container">
            <h2>Sign Up</h2>
            <form id="registerForm" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Isi Nama"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Isi Email"
                        required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Isi Password" required>
                </div>
                <div class="mb-3">
                    <label for="npwp" class="form-label">Nomor Pokok Wajib Pajak</label>
                    <input type="text" name="npwp" id="npwp" class="form-control" placeholder="Isi NPWP">
                </div>
                <div class="mb-3">
                    <label for="upload" class="form-label">Surat Izin Usaha</label>
                    <div class="btn-upload">
                        <input type="file" name="file_surat_izin" id="upload" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-10 0">Sign Up</button>
            </form>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/Sign in.png') }}" alt="bizgrowlogo">
            <div class="overlay-logo">
                <img src="{{ asset('images/logo1.png') }}" alt="BizGrow Logo">
            </div>
        </div>
    </div>

    <!-- Link to External JavaScript File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/SignUp.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
