<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="@yield('cssCustom')" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Side Bar -->
        <aside id="sidebar">
            <div class="d-flex flex-column mt-3">
                <button class="toggle-btn" type="button">
                    <img src="{{ asset('images/profil/default_avatar.jpg') }}" alt="profile-pict">
                </button>
                <div class="sidebar-nama text-center">
                    {{-- <a href="#" id="userName"></a> --}}
                    <span style="color: white">Admin</span>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('admin.data_umkm') }}" class="sidebar-link">
                        <img src="{{ asset('images/admin/data_umkm.svg') }}" alt="data-icon">
                        <span>Data UMKM</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('admin.verifikasi') }}" class="sidebar-link">
                        <img src="{{ asset('images/admin/verify.svg') }}" alt="verif-icon">
                        <span>Verifikasi UMKM</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.feedback') }}" class="sidebar-link">
                        <img src="{{ asset('images/feedback.svg') }}" alt="settings-icon">
                        <span>Feedback</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <a href="#" id="logoutButton" class="sidebar-link">
                    <img src="{{ asset('images/logout.svg') }}" alt="logout-icon">
                    <span>Keluar</span>
                </a>
            </div>
        </aside>
        <div class="main" id="main">
            <header class="p-3 d-flex justify-content-between align-items-center fixed-top">
                <h3 class="h3 fw-bold">
                    @yield('header')
                </h3>
                <img src="{{ asset('images/logo.png') }}" alt="bizgrowlogo">
            </header>
            <div class="content overflow-y-auto m-3">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin keluar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="batalButton"
                        data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmLogoutButton">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk meminta login jika token tidak ditemukan -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Belum Login</h5>
                </div>
                <div class="modal-body">
                    <p>Untuk mengakses halaman ini, Anda harus login terlebih dahulu.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="redirectToLoginButton">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Auto Logout -->
    <div class="modal fade" id="autoLogoutModal" tabindex="-1" role="dialog" aria-labelledby="autoLogoutModalLabel"Add commentMore actions
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="autoLogoutModalLabel">Keluar Otomatis</h5>
                </div>
                <div class="modal-body">
                    Anda telah logout otomatis karena tidak ada aktivitas selama 1 menit.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="redirectToLoginButtonAutoLog">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="@yield('jsCustom')"></script>
</body>

</html>
