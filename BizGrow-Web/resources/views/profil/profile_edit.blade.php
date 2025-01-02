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
            axios.get('{{ route('profile.data') }}', {
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

                    const emailInput = document.getElementById('umkmEmailInput');
                    emailInput.value = user.email;

                    const npwpInput = document.getElementById('umkmNPWP');
                    npwpInput.value = user.npwp;
                }
            })
            .catch(function (error) {
                console.error('Error fetching profile data:', error);
            });
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('profilePicture');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection

@section('content')
    <div class="wrapper">
        <div class="filter-container m-5 d-flex align-items-start">
            <!-- Foto Profil -->
            <div class="position-relative">
                <img
                    src=""
                    class="rounded-circle mb-3 profile-photo"
                    alt="Avatar"
                    id="profilePicture"
                />
                <span
                    class="position-absolute change-photo"
                    onclick="document.getElementById('fileInput').click()"
                >
                    <img
                        src="{{ asset('images/camera.svg') }}"
                        alt="Edit Photo"
                        style="width: 20px; height: 20px"
                    />
                </span>
                <input
                    type="file"
                    id="fileInput"
                    style="display: none;"
                    accept="image/*"
                    onchange="previewImage(event)"
                />
            </div>
            <div class="ms-5">
                <form id="profileForm" method="POST" action="{{ route('profil.edit') }}">
                    @csrf
                    @method('PUT')
                    <label for="umkmNameInput" class="form-label fw-bold">Nama UMKM</label>
                    <div class="input-group mb-3">
                        <input type="text" id="umkmNameInput" name="name" class="form-control" />
                        <span
                            class="input-group-text position-absolute right-icon"
                            id="basic-addon2"
                        >
                            <img src="{{ asset("images/profil/pencil.svg") }}" alt="Edit" style="width: 16px" />
                        </span>
                    </div>

                    <label for="umkmEmailInput" class="form-label fw-bold">Email</label>
                    <div class="input-group mb-3">
                        <input type="email" id="umkmEmailInput" name="email" class="form-control" />
                        <span
                            class="input-group-text position-absolute right-icon"
                            id="basic-addon2"
                        >
                            <img src="{{ asset("images/profil/pencil.svg") }}" alt="Email" style="width: 16px" />
                        </span>
                    </div>

                    <label for="umkmNPWP" class="form-label fw-bold">NPWP</label>
                    <div class="position-relative mb-3">
                        <input type="email" id="umkmNPWP" class="form-control" disabled />
                        <span
                            class="position-absolute right-icon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Kamu tidak bisa mengganti NPWP, hubungi admin apabila ada perubahan."
                        >
                            <img
                                src="{{ asset("images/profil/qm.svg") }}"
                                style="width: 16px"
                            />
                        </span>
                    </div>

                    <div class="d-flex m-5 gap-3">
                        <a href="{{ route('profil.editPassword') }}" class="btn btn-primary">Change Password</a>
                        <button type="submit" class="btn btn-success" id="simpan">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection