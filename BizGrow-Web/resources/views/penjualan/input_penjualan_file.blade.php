@extends('layout')

@section('title', 'Input Penjualan Manual')

@section('header', 'Input Data Penjualan')

@section('cssCustom')
    {{ asset('css/input.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/penjualan_input_file.js') }}
@endsection

@section('content')
    <div class="wrapper">
        <div class="main">
            <div class="content overflow-y-auto">
                <div class="m-5 align-items-center">
                    <div class="container bg-light p-4 shadow rounded-5">
                        <h1 class="text-center fw-bold mb-4">Input Data Penjualan via File Excel</h1>
                        <div class="mb-3">
                            <label class="fw-bold">Petunjuk Pengisian:</label>
                            <p>
                                File yang diupload <b>WAJIB</b> memiliki kolom <b> header </b> berikut (bebas urutan, tapi
                                nama harus
                                persis):
                            </p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm w-auto">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Kolom (Header)</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>produk</code></td>
                                            <td>Nama produk (harus sesuai dengan produk yang sudah ada, atau akan otomatis
                                                dibuat)</td>
                                        </tr>
                                        <tr>
                                            <td><code>jumlah_barang</code></td>
                                            <td>Jumlah produk yang terjual</td>
                                        </tr>
                                        <tr>
                                            <td><code>harga_satuan</code></td>
                                            <td>Harga satuan produk</td>
                                        </tr>
                                        <tr>
                                            <td><code>total_harga</code></td>
                                            <td>Total harga penjualan</td>
                                        </tr>
                                        <tr>
                                            <td><code>tanggal_penjualan</code></td>
                                            <td>Tanggal penjualan (format: YYYY-MM-DD)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-2">
                                <a href="{{ asset('storage/templates/template_file_data_penjualan.xlsx') }}"
                                    class="btn btn-success btn-sm" download>
                                    <i class="bi bi-download"></i> Download Template Excel
                                </a>
                            </div>
                            <p class="text-muted mb-0">
                                <small>
                                    Silakan gunakan template di atas agar format file Anda sesuai. Jika tidak ingin,
                                    silahkan sesuaikan dengan header yang ditentukan.
                                </small>
                            </p>
                        </div>
                        <form id="inputForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="m-3">
                                <label for="inputFileSale" class="form-label fw-bold">File Data Penjualan</label>
                                <input type="file" class="form-control" id="inputFileSale" name="inputFileSale"
                                    accept=".xlsx,.xls,.csv" required>
                                <p class="note">*Masukkan file Excel berisi data penjualan sesuai format di atas</p>
                            </div>
                            <div class="m-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary w-100">Kirim Data</button>
                            </div>
                        </form>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Berhasil nambah sales transaction -->
    <div class="modal fade" id="successModalAddSales" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Tambah Produk Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="successMessageAddSales">
                    <!-- Pesan sukses -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk  Gagal tambah sales stransaction -->
    <div class="modal fade" id="errorModalAddSales" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Gagal Input Data Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorMessageAddSales">
                    <!-- Pesan error -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Coba Lagi</button>
                </div>
            </div>
        </div>
    </div>
@endsection
