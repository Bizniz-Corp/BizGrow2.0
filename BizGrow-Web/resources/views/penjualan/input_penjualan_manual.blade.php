@extends('layout')

@section('title', 'Input Penjualan Manual')

@section('header', 'Input Data Penjualan')

@section('cssCustom')
    {{ asset('css/input.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/penjualan_input_manual.js') }}
@endsection

@section('content')
    <div class="wrapper">
        <div class="main">
            <div class="content overflow-y-auto">
                <div class="m-5 align-items-center">
                    <div class="container bg-light p-4 shadow rounded-5">
                        <h1 class="text-center fw-bold">Input Data Manual</h1>
                        <form id="inputForm" method="POST">
                            @csrf
                            <div class="m-3">
                                <label for="tanggal" class="form-label fw-bold">Tanggal Terjual:</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="m-3">
                                <label for="namaProduk" class="form-label fw-bold">Produk:</label>

                                <div class="d-flex justify-content-between">
                                    <select class="form-select" id="namaProduk" name="namaProduk" required>

                                    </select>
                                    <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahProduk">Tambah Produk</button>
                                </div>
                                <p class="note">*Jika produk tidak ada, anda bisa menambahkan produk terlebih dahulu
                                    di tambah produk</p>

                            </div>
                            <div class="m-3">
                                <label for="harga" class="form-label fw-bold">Harga
                                    Satuan:</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="m-3">
                                <label for="kuantitas" class="form-label fw-bold">Kuantitas Terjual:</label>
                                <input type="number" class="form-control" id="kuantitas" name="kuantitas" required>
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
    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTambahProduk">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Tambah Produk Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="namaProdukBaru" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="namaProdukBaru" name="namaProdukBaru" required>
                        <label for="quantityProdukBaru" class="form-label">Total Produk Tersedia</label>
                        <input type="number" class="form-control" id="quantityProdukBaru" name="quantityProdukBaru"
                            required>
                        <label for="hargaProdukBaru" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="hargaProdukBaru" name="hargaProdukBaru" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="simpanProduk">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal untuk Berhasil nambah produk -->
    <div class="modal fade" id="successModalAddProduct" tabindex="-1" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Tambah Produk Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="successMessageAddProduct">
                    <!-- Pesan sukses -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk  Gagal tambah produk -->
    <div class="modal fade" id="errorModalAddProduct" tabindex="-1" aria-labelledby="errorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Gagak menambahkan produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="errorMessageAddProduct">
                    <!-- Pesan error -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Coba Lagi</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Berhasil nambah sales transaction -->
    <div class="modal fade" id="successModalAddSales" tabindex="-1" aria-labelledby="successModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="errorModalAddSales" tabindex="-1" aria-labelledby="errorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Gagak data penjualan</h5>
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
