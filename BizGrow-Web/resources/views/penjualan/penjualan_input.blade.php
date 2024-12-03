<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/input.css">
</head>

<body>
     <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex flex-column mt-3">
                <button class="toggle-btn" type="button">
                    <img src="../img/Boom Es.jpeg" alt="profile_pict">
                </button>
                <div class="sidebar-nama text-center">
                    <a href="#">Nama UMKM</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="indexhome.html" class="sidebar-link">
                        <img src="../img/keyboard.svg" alt="moneyicon">
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse"
                        data-bs-target="#penjualan" aria-expanded="true" aria-controls="penjualan">
                        <img src="../img/money-send.svg" class="money-icon">
                        <span>Penjualan</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="penjualan" data-bs-parent="#penjualan">
                        <li class="sidebar-item">
                            <a href="../pages/penjualan_input.html" class="sidebar-link">Input Data</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../pages/penjualan_history.html" class="sidebar-link">Riwayat Penjualan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="penjualan/penjualan_prediksi_demand.html" class="sidebar-link">Prediksi Permintaan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Prediksi Profit</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#stok"
                        aria-expanded="true" aria-controls="stok">
                        <img src="../img/box.svg" alt="iconbox">
                        <span>Stok</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse" id="stok" data-bs-parent="#stok">
                        <li class="sidebar-item">
                            <a href="../pages/stok_input.html" class="sidebar-link">Input Data</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../pages/stok_history.html" class="sidebar-link">Riwayat Stok</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Prediksi Stok</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="../pages/profile.html" class="sidebar-link">
                        <img src="../img/profile.svg" alt="iconprofile">
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../index.html" class="sidebar-link">
                    <img src="../img/logout.svg" alt="iconprofile">
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <div class="main">
            <header class="p-3 d-flex justify-content-between align-items-center sticky-top">
                <h3 class="h3 fw-bold">
                    Input Data Penjualan
                </h3>
                <img src="../img/logo.png" alt="bizgrowlogo">
            </header>
            <div class="button-container">
                <button class="btn-custom" onclick="showAlertAndNavigate('manual')">
                    <img src="../img/input_manual.png" alt="Input Manual">
                    Input Data Manual
                </button>
                <button class="btn-custom" onclick="showAlertAndNavigate    ('file')">
                    <img src="../img/input_file.png" alt="Input File">
                    Input Data File
                </button>
            </div>
        </div>
     </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/penjualan_input.js"></script>
</body>

</html>
