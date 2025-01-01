<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="{{ asset("css/style.css") }}" rel="stylesheet" />
    <link href="{{ asset("css/profile.css") }}" rel="stylesheet" />
  </head>

  <body>
    <div class="wrapper">
      <!-- Side Bar -->
      <aside id="sidebar">
        <div class="d-flex flex-column mt-3">
          <button class="toggle-btn" type="button">
            <img src="{{ asset("images/Boom Es.jpeg") }}" alt="profile_pict">
          </button>
          <div class="sidebar-nama text-center">
            <a href="#">Nama UMKM</a>
          </div>
        </div>
        <ul class="sidebar-nav">
          <li class="sidebar-item">
            <a href="indexhome.html" class="sidebar-link">
              <img src="{{ asset("images/keyboard.svg") }}" alt="moneyicon">
              <span>Beranda</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#penjualan"
              aria-expanded="true" aria-controls="penjualan">
              <img src="{{ asset("images/money-send.svg") }}" alt="money-send" class="money-icon">
              <span>Penjualan</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="penjualan" data-bs-parent="#penjualan">
              <li class="sidebar-item">
                <a href="{{ route("penjualan.input") }}" class="sidebar-link">Input Data</a>
              </li>
              <li class="sidebar-item">
                <a href="{{ route("penjualan.riwayat") }}" class="sidebar-link">Riwayat Penjualan</a>
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
              <img src="{{ asset("images/box.svg") }}" alt="iconbox">
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
              <img src="{{ asset("images/profil/profile.svg") }}" alt="iconprofile">
              <span>Profil</span>
            </a>
          </li>
        </ul>
        <div class="sidebar-footer">
          <a href="../index.html" class="sidebar-link">
            <img src="{{ asset("images/profil/logout.svg") }}" alt="iconprofile">
            <span>Keluar</span>
          </a>
        </div>
      </aside>

      <div class="main">
        <header
          class="p-3 d-flex justify-content-between align-items-center sticky-top"
        >
          <h3 class="h3 fw-bold">Profil</h3>
          <img src="{{ asset("images/logo.png") }}" alt="bizgrowlogo" />
        </header>

        <div class="filter-container m-5 d-flex align-items-start">
          <img
            src="../img/Boom Es.jpeg {{ asset("images/Boom Es.jpeg") }}"
            class="rounded-circle mb-3 profile-photo"
            alt="User Avatar"
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
              <a href="{{ route('profil.edit') }}" class="btn btn-primary"
                >Edit Profil</a
              >
              <button type="button" class="btn btn-danger" id="deleteAccountButton">Hapus Akun</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="{{ asset("js/script.js") }}"></script>
    <script src="{{ asset("js/profile.js") }}"></script>
  </body>
</html>
