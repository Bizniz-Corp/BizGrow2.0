@extends('layout')

@section('title', 'Input Perubahan Stok Manual')

@section('header', 'Input Data Perubahan Stok')

@section('cssCustom')
    {{ asset('css/input.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/stok_input_file.js') }}
@endsection

@section('content')
    <div class="wrapper">
        <div class="main">
            <div class="content overflow-y-auto">
                <div class="m-5 align-items-center">
                    <div class="container bg-light p-4 shadow rounded-5">
                        <h1 class="text-center fw-bold mb-4">Input Data Perubahan Stok via File Excel</h1>
                        <div class="mb-3">
                            <label class="fw-bold">Petunjuk Pengisian:</label>
                            <p>
                                File yang diupload <b>WAJIB</b> memiliki kolom header berikut (bebas urutan, tapi nama harus
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
                                            <td><code>jumlah_perubahan</code></td>
                                            <td>Jumlah perubahan stok (<b>positif</b> untuk penambahan, <b>negatif</b> untuk
                                                pengurangan)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><code>tanggal_perubahan</code></td>
                                            <td>Tanggal perubahan stok (format: YYYY-MM-DD)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-2">
                                <a href="{{ asset('storage/templates/template_file_data_stok.xlsx') }}"
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
                        <form id="inputStockForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="m-3">
                                <label for="inputFileStock" class="form-label fw-bold">File Data Perubahan Stok</label>
                                <input type="file" class="form-control" id="inputFileStock" name="inputFileStock"
                                    accept=".xlsx,.xls,.csv" required>
                                <p class="note">*Masukkan file Excel berisi data perubahan stok sesuai format di atas</p>
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
    <!-- Modal untuk Berhasil nambah stok -->
    <div class="modal fade" id="successModalAddStock" tabindex="-1" aria-labelledby="successModalStockLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalStockLabel">Tambah Perubahan Stok Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="successMessageAddStock">
                    <!-- Pesan sukses -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Gagal tambah stok -->
    <div class="modal fade" id="errorModalAddStock" tabindex="-1" aria-labelledby="errorModalStockLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalStockLabel">Gagal Input Data Perubahan Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorMessageAddStock">
                    <!-- Pesan error -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Coba Lagi</button>
                </div>
            </div>
        </div>
    </div>
@endsection
