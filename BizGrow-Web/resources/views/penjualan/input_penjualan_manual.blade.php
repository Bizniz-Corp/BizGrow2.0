<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penjualan Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/riwayat.css') }}">
</head>

<body>
     <div class="wrapper">
        <!-- Side Bar -->
        <aside id="sidebar">
            <div class="d-flex flex-column mt-3">
                <button class="toggle-btn" type="button">
                    <img src="{{ asset('img/Boom Es.jpeg') }}" alt="profile_pict">
                </button>
                <div class="sidebar-nama text-center">
                    <a href="#">Nama UMKM</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ url('indexhome') }}" class="sidebar-link">
                        <img src="{{ asset('img/keyboard.svg') }}" alt="moneyicon">
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#penjualan" aria-expanded="true" aria-controls="penjualan">
                        <img src="{{ asset('img/money-send.svg') }}" class="money-icon">
                        <span>Penjualan</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="penjualan" data-bs-parent="#penjualan">
                        <li class="sidebar-item">
                            <a href="{{ url('penjualan/input') }}" class="sidebar-link">Input Data</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('penjualan/history') }}" class="sidebar-link">Riwayat Penjualan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('penjualan/prediksi_demand') }}" class="sidebar-link">Prediksi Permintaan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Prediksi Profit</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#stok"
                        aria-expanded="true" aria-controls="stok">
                        <img src="{{ asset('img/box.svg') }}" alt="iconbox">
                        <span>Stok</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="stok" data-bs-parent="#stok">
                        <li class="sidebar-item">
                            <a href="{{ url('stok/input') }}" class="sidebar-link">Input Data</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('stok/history') }}" class="sidebar-link">Riwayat Stok</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Prediksi Stok</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('profile') }}" class="sidebar-link">
                        <img src="{{ asset('img/profile.svg') }}" alt="iconprofile">
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="{{ url('/') }}" class="sidebar-link">
                    <img src="{{ asset('img/logout.svg') }}" alt="iconlogout">
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <div class="main">
            <header class="p-3 d-flex justify-content-between align-items-center sticky-top">
                <h3 class="h3 fw-bold">
                    Input Data Penjualan
                </h3>
                <img src="{{ asset('img/logo.png') }}" alt="bizgrowlogo">
            </header>
            <div class="content overflow-y-auto">
                <div class="m-5 align-items-center">
                    <div class="form-container position-absolute top-50 start-50 translate-middle">
                        <h1 class="text-center">Input Data Manual</h1>
                        <form id="inputForm" method="POST">
                            @csrf <!-- Token CSRF agar form aman -->
                            <div class="m-3">
                                <label for="tanggal" class="form-label">Tanggal:</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="m-3">
                                <label for="namaProduk" class="form-label">Nama Produk:</label>
                                <input type="text" class="form-control" id="namaProduk" name="namaProduk" required>
                            </div>
                            <div class="m-3">
                                <label for="harga" class="form-label">Harga:</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="m-3">
                                <label for="kuantitas" class="form-label">Kuantitas:</label>
                                <input type="number" class="form-control" id="kuantitas" name="kuantitas" required>
                            </div>
                            <div class="m-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Kirim Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
     </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
