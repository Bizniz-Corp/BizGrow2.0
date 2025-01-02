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
                    <img src="{{ asset('images/Boom Es.jpeg') }}" alt="profile-pict">
                </button>
                <div class="sidebar-nama text-center">
                    <a href="#">Nama UMKM</a>
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
                    <a href="{{ route('profil') }}" class="sidebar-link">
                        <img src="{{ asset('images/profile.svg') }}" alt="profile-icon">
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="{{ route('signout') }}" class="sidebar-link">
                    <img src="{{ asset('images/logout.svg') }}" alt="logout-icon">
                    <span>Keluar</span>
                </a>
            </div>
        </aside>
        <div class="main">
            <header class="p-3 d-flex justify-content-between align-items-center sticky-top">
                <h3 class="h3 fw-bold">
                    @yield('header')
                </h3>
                <img src="{{ asset('images/logo.png') }}" alt="bizgrowlogo">
            </header>
            <div class="content overflow-y-auto m-5">
                @yield('content')
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
