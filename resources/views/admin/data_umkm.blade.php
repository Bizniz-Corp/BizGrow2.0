@extends('admin/layout')

@section('title', 'Data UMKM')

@section('header')
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.data_umkm') }}">
            <h3 class="h3 fw-bold mb-0 text-dark">Data UMKM</h3>
        </a>
    </div>
@endsection

@section('cssCustom')
    {{ asset('css/admin.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/admin_data.js') }}
@endsection

@section('content')
    <div class="m-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">UMKM Aktif</h5>
                        <p id="activeUmkmCount" class="card-text fs-3 fw-bold">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">UMKM Tidak Aktif</h5>
                        <p id="inactiveUmkmCount" class="card-text fs-3 fw-bold">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="filter-container m-5 d-flex align-items-center">
        <input type="text" id="umkmNameInput" class="form-control me-3" style="width: 300px;" placeholder="Cari Nama Toko">
        <button class="btn btn-primary" id="resetButton">
            <img src="{{ asset('images/refresh.svg') }}" alt="reset-icon"> Reset
        </button>
    </div>

    <div class="mx-5 mb-5">
        <table class="table table-striped text-center align-middle table-borderless">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Durasi(Menit)</th>
                    <th scope="col">Forecasting Demand</th>
                    <th scope="col">Buffer Stock</th>
                    <th scope="col">Akurasi Demand</th>
                    <th scope="col">Akurasi Stok</th>
                    <th scope="col">Status</th>
                    <th scope="col">Hapus Data</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center align-items-center mt-4"></div>
    </div>
@endsection
