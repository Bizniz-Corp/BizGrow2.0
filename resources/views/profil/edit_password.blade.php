@extends('layout')

@section('title', 'Profil')

@section('header', 'Edit Password')

@section('cssCustom')
    {{ asset('css/edit_pass.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/edit_pass.js') }}
@endsection

@section('content')
    <div class="m-3">
        <form method="POST" action="" id="editPasswordForm">
            @csrf

            <!--Password Lama-->
            <div class="inputFieldLama mb-3">
                <label for="password" class="form-label">Masukkan Password Lama</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passLama" placeholder="Masukkan password lama">
                    <button type="button" class="btn btn-primary" id="togglePassLama">
                        <i id="iconPassLama" class="bi bi-eye"></i>
                    </button>
                </div>
                {{-- <input type="password" class="form-control" id="passLama" placeholder="Masukkan password lama"> --}}
                <a class="noteInput text-danger d-none" id="notePassLama"> Password salah! coba masukkan lagi </a>
            </div>

            <!--Berikutnya Button-->
            <button class="btn btn-primary" id="berikutnyaBtn"type="button">
                Berikutnya
            </button>

            <!--Password Baru-->
            <div class="inputFieldBaru mb-3 d-none">
                <label for="password" class="form-label">Masukkan Password Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passBaru" placeholder="Masukkan password baru">
                    <button type="button" class="btn btn-primary" id="togglePassBaru">
                        <i id="iconPassBaru" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!--Konfirmasi Password Baru-->
            <div class="inputFieldBaruConfirm mb-3 d-none">
                <label for="password" class="form-label">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passBaruConfirm"
                        placeholder="Masukkan konfirmasi password baru">
                    <button type="button" class="btn btn-primary" id="togglePassBaruConfirm">
                        <i id="iconPassBaruConfirm" class="bi bi-eye"></i>
                    </button>
                </div>
                <a class="noteInput text-danger d-none" id="notePassBaruConfirm"> Password tidak sesuai dengan
                    password baru! </a>
                <a class="noteInput text-danger d-none" id="notePassBaruUpConfirm"> Password tidak memiliki upper
                    case! </a>
                <a class="noteInput text-danger d-none" id="notePassBaruLowConfirm"> Password tidak memiliki lower
                    case! </a>
                <a class="noteInput text-danger d-none" id="notePassBaruCharConfirm"> Password tidak memiliki
                    karakter spesial </a>
                <a class="noteInput text-danger d-none" id="notePassBaruRangeConfirm"> Password tidak tidak
                    terdiri dari 8-25 karakter </a>
                <a class="noteInput text-danger d-none" id="notePassBaruAngkaConfirm"> Password tidak tidak
                    memiliki angka! </a>
            </div>

            <!--Simpan Button-->
            <button class="btn btn-primary d-none" id="simpanBtn" type="button">
                Simpan
            </button>
        </form>
    </div>

    <!-- Modal Konfirmasi Berhasil -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Password berhasil diubah!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmButton">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda Yakin untuk mengganti password?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="gantiButton">Ganti</button>
                    <button type="button" class="btn btn-danger" id="batalButton">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection
