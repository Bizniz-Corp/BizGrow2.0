<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/edit_pass.css">
</head>
<body>
    <div class="wrapper">
        <!-- Side Bar -->
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
                    Profil
                </h3>
                <img src="../img/logo.png" alt="bizgrowlogo">
            </header>
            <div class="content overflow-y-auto m-5 align-items-center">
                <div class="inputFieldLama mb-3">
                    <label for="password" class="form-label">Masukkan Password Lama</label>
                    <input type="password" class="form-control" id="passLama" placeholder="Masukkan password lama">
                    <a class="noteInput text-danger d-none" id="notePassLama"> Password salah! coba masukkan lagi </a>
                </div>
                <button class="btn btn-primary" id="berikutnyaBtn"type="button">
                    Berikutnya
                </button>
                <div class="inputFieldBaru mb-3 d-none">
                    <label for="password" class="form-label">Masukkan Password Baru</label>
                    <input type="password" class="form-control" id="passBaru" placeholder="Masukkan password baru">
                </div>
                <div class="inputFieldBaruConfirm mb-3 d-none">
                    <label for="password" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="passBaruConfirm" placeholder="Masukkan konfirmasi password baru">
                    <a class="noteInput text-danger d-none" id="notePassBaruConfirm"> Password tidak sesuai dengan password baru! </a>
                    <a class="noteInput text-danger d-none" id="notePassBaruUpConfirm"> Password tidak memiliki upper case! </a>
                    <a class="noteInput text-danger d-none" id="notePassBaruLowConfirm"> Password tidak memiliki lower case! </a>
                    <a class="noteInput text-danger d-none" id="notePassBaruCharConfirm"> Password tidak memiliki karakter spesial </a>
                    <a class="noteInput text-danger d-none" id="notePassBaruRangeConfirm"> Password tidak tidak terdiri dari 8-25 karakter </a>
                    <a class="noteInput text-danger d-none" id="notePassBaruAngkaConfirm"> Password tidak tidak memiliki angka! </a>
                </div>
                <button class="btn btn-primary d-none" id="simpanBtn" type="button">
                    Simpan
                </button>
            </div>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/edit_pass.js"></script>
</body>
</html>