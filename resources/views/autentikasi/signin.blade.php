@extends('hnf')

@section('title', 'Sign In - BizGrow')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/Sign in.css') }}">
@endpush

@section('content')
<div class="main-signin-wrapper">
    <div class="login-container signup-container">
        <div class="form-container">
            <h2>Sign In</h2>
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Isi Email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Isi Password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
            <div>
                <p class="mt-3">Belum Punya Akun? <a href="{{ route('register') }}">Klik Disini</a></p>
                <a href="{{ url('/forgot-password') }}" class="text-decoration-none align-self-center">Lupa Password?</a>
            </div>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/Sign in.png') }}" alt="bizgrowlogo">
            <div class="overlay-logo">
                <img src="{{ asset('images/logo1.png') }}" alt="Bizgrow Logo">
            </div>
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
@endsection

@push('scripts')
<script src="{{ asset('js/Signin.js') }}"></script>
@endpush