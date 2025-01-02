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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('{{ route('profil.profil') }}', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(function (response) {
                if (response.data.success) {
                    const user = response.data.data;

                    const profilePicture = document.getElementById('profilePicture');
                    profilePicture.src = user.profile_picture;

                    const nameInput = document.getElementById('umkmNameInput');
                    nameInput.value = user.name;
                    nameInput.removeAttribute('disabled');

                    const emailInput = document.getElementById('umkmEmailInput');
                    emailInput.value = user.email;
                    emailInput.removeAttribute('disabled');

                    const npwpInput = document.getElementById('umkmNPWP');
                    npwpInput.value = user.npwp;
                    npwpInput.removeAttribute('disabled');
                }
            })
            .catch(function (error) {
                console.error('Error fetching profile data:', error);
            });
        });
    </script>
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
                />

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
@endsection