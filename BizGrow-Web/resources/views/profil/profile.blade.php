@extends('layout')

@section('title', 'Profil')

@section('header')
<div class="d-flex align-items-center">
  <a href="{{ route('profil.profil') }}"><h3 class="h3 fw-bold mb-0 text-dark">Profil</h3></a>
</div>
@endsection

@section('cssCustom')
    {{ asset('css/profile.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/profile.js') }}
@endsection

@section('content')
    <div class="wrapper">
        <div class="filter-container m-5 d-flex align-items-start">
            <img
                src=""
                class="rounded-circle mb-3 profile-photo"
                alt="User Avatar"
                id="profilePicture"
            />
            <div class="ms-5">
                <label for="umkmNameInput" class="form-label fw-bold">Nama UMKM</label>
                <input
                    type="text"
                    class="form-control text-muted mb-2"
                    id="umkmNameInput"
                    disabled
                ></input>

                <label for="umkmEmailInput" class="form-label fw-bold">Email</label>
                <input
                    type="email"
                    class="form-control text-muted mb-2"
                    id="umkmEmailInput"
                    disabled
                />

                <label for="umkmNPWP" class="form-label fw-bold">NPWP</label>
                <input
                    type="text"
                    class="form-control text-muted mb-2"
                    id="umkmNPWP"
                    disabled
                />

                <div class="m-5 d-flex gap-3">
                    <a href="{{ route('profil.edit') }}" class="btn btn-primary">Edit Profil</a>
                    <button type="button" class="btn btn-danger" id="deleteAccountButton">Hapus Akun</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun? Harap masukkan password Anda untuk konfirmasi.</p>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Password">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus Akun</button>
                </div>
            </div>
        </div>
    </div>
@endsection