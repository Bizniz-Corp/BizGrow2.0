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
                    <img src="" alt="profile-pict" id="profilePicture">
                </button>
                <div class="sidebar-nama text-center">
                    <a href="#" id="userName"></a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('home') }}" class="sidebar-link">
                        <img src="{{ asset('images/keyboard.svg') }}" alt="home-icon">
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#penjualan" aria-expanded="true" aria-controls="penjualan">
                        <img src="{{ asset('images/money-send.svg') }}" class="money-icon">
                        <span>Penjualan</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="penjualan" data-bs-parent="#penjualan">
                        <li class="sidebar-item">
                            <a href="{{ route('penjualan.input') }}" class="sidebar-link">Input Data</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('penjualan.riwayat') }}" class="sidebar-link">Riwayat Penjualan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('penjualan.demand') }}" class="sidebar-link">Prediksi
                                Permintaan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('penjualan.profit') }}" class="sidebar-link">Prediksi Profit</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#stok" aria-expanded="true" aria-controls="stok">
                        <img src="{{ asset('images/box.svg') }}" alt="box-icon">
                        <span>Stok</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="stok" data-bs-parent="#stok">
                        <li class="sidebar-item">
                            <a href="{{ route('stok.input') }}" class="sidebar-link">Input Data</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('stok.riwayat') }}" class="sidebar-link">Riwayat Stok</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('stok.bufferstok') }}" class="sidebar-link">Prediksi Stok</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('profil.profil') }}" class="sidebar-link">
                        <img src="{{ asset('images/profile.svg') }}" alt="profile-icon">
                        <span>Profil</span>
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

    <!-- Floating Button -->
<div class="floating-button">
    <button class="btn btn-primary rounded-circle" id="feedbackButton">
        <i class="bi bi-chat-dots"></i>
    </button>
</div>

<!-- Modal Feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="feedbackForm">
                    <div class="mb-3">
                        <label for="feedbackInput" class="form-label">Masukkan Feedback Anda</label>
                        <textarea class="form-control" id="feedbackInput" rows="4" placeholder="Tulis feedback Anda di sini..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitFeedbackButton">Kirim</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/feedback.js') }}"></script>
    <br>
    <script src="@yield('jsCustom')"></script>

    <!-- Modal untuk Pesan -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="messageModalBody">
                <!-- Pesan akan ditampilkan di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>
