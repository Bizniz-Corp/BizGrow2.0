<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link href="../../assets/css/style_reza.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="component-sidebar"></div>

        <div class="main">
            <header class="p-3 d-flex justify-content-between align-items-center sticky-top">
                <h3 class="h3 fw-bold">
                    Prediksi Permintaan
                </h3>
                <img src="../../img/logo.png" alt="bizgrowlogo">
            </header>

            <div class="d-flex justify-content-center my-3">
                <div class="search_select_box">
                    <select name="" id="productSelect" data-live-search="true" style="width: 500px;">
                        <option value="Ayam Bakar Nashvilled">Ayam Bakar Nashvilled</option>
                        <option value="Ayam Goreng Nashvilled">Ayam Goreng Nashvilled</option>
                        <option value="Ayam Rebus Nashvilled">Ayam Rebus Nashvilled</option>
                        <option value="Ayam Pepes Nashvilled">Ayam Pepes Nashvilled</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center my-3">
                <div class="d-flex justify-content-center">
                    <div class="dropdown justify-content-center">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="pilihWaktuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Waktu
                        </button>
                        <div class="dropdown-menu" aria-labelledby="pilihWaktuButton">
                            <a class="dropdown-item" href="#" id="optionBulan">Bulan</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" id="optionHari">Hari</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center my-3">
                <div style="width: 50%;">
                    <canvas id="bufferStockChart"></canvas>
                </div>
            </div>

            <div>
                <h5 class="h5 fw-bold d-flex justify-content-center">
                    Akurasi
                    </h3>
                    <div>
                        <div style="width: 20%; margin: 0 auto;">
                            <canvas id="percentageChart"></canvas>
                        </div>
                    </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../assets/js/script_reza.js"></script>
    <script src="../../assets/js/komponen_prediksi.js"></script>
</body>

</html>