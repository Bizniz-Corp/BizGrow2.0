@extends('hnf')

@section('title', 'Bizgrow - Sign Up')

@section('content')
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
                    <input type="text" name="npwp" id="npwp" class="form-control" maxlength="20"
                        placeholder="xx.xxx.xxx.x-xxx.xxx">
                </div>
                <div class="mb-3">
                    <label for="upload" class="form-label">Surat Izin Usaha</label>
                    <div class="btn-upload">
                        <input type="file" name="file_surat_izin" id="upload" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
            <div>
                <p class="mt-3">Sudah Punya Akun? <a href="{{ route('login') }}">Klik Disini</a></p>
            </div>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/Sign in.png') }}" alt="bizgrowlogo">
            <div class="overlay-logo">
                <img src="{{ asset('images/logo1.png') }}" alt="BizGrow Logo">
            </div>
        </div>
    </div>

    <!-- Modal untuk Registrasi Berhasil -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Registrasi Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="successMessage">
                    <!-- Pesan sukses -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='/login'">
                        Login Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Register Gagal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errorList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Link to External JavaScript File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/SignUp.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Simulasi redirect ke OTP -->
    {{-- <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form ke backend
            window.location.href = "{{ url('/otp') }}"; // Arahkan ke halaman OTP
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const npwpInput = document.getElementById('npwp');
            npwpInput.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '').substring(0,15); // max 15 digit angka
                let formatted = '';
                if(value.length > 0) formatted += value.substring(0,2);
                if(value.length > 2) formatted += '.' + value.substring(2,5);
                if(value.length > 5) formatted += '.' + value.substring(5,8);
                if(value.length > 8) formatted += '.' + value.substring(8,9);
                if(value.length > 9) formatted += '-' + value.substring(9,12);
                if(value.length > 12) formatted += '.' + value.substring(12,15);
                this.value = formatted;
            });
        });
    </script>
@endsection
