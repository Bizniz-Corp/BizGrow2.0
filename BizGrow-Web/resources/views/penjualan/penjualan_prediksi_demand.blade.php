@extends('layout')

@section('title', 'Prediksi Permintaan Produk')

@section('header', 'Prediksi Permintaan Produk Harian')

@section('cssCustom')
    {{ asset('css/prediksi_profit.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/prediksi_demand.js') }}
@endsection

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Permintaan Produk Harian</h2>
            <button class="btn btn-success" id="predictButton">
                Prediksi Permintaan Produk
            </button>
        </div>

        <div id="alert-container" class="mb-3"></div>

        <div class="filter-controls mb-4 p-3 border rounded bg-light" id="chartFilterControls" style="display: none;">
            <h4 class="mb-3">Filter Grafik</h4>
            <div class="row mb-3"> {{-- Baris untuk dropdown produk --}}
                <div class="col-md-4"> {{-- Sesuaikan lebar kolom untuk dropdown produk --}}
                    <label for="productSelectDropdown" class="form-label">Pilih Produk:</label>
                    <select class="form-select" id="productSelectDropdown">
                        <option value="">Memuat produk...</option>
                        {{-- Opsi akan diisi oleh JavaScript --}}
                    </select>
                </div>
            </div>
            <div class="row g-3 align-items-end"> {{-- Baris untuk filter tanggal --}}
                <div class="col-md-2 col-6">
                    <label for="filterStartYear" class="form-label">Tahun Mulai:</label>
                    <select class="form-select" id="filterStartYear"></select>
                </div>
                <div class="col-md-2 col-6">
                    <label for="filterStartMonth" class="form-label">Bulan Mulai:</label>
                    <select class="form-select" id="filterStartMonth"></select>
                </div>
                <div class="col-md-2 col-6 mt-3 mt-md-0">
                    <label for="filterEndYear" class="form-label">Tahun Akhir:</label>
                    <select class="form-select" id="filterEndYear"></select>
                </div>
                <div class="col-md-2 col-6 mt-3 mt-md-0">
                    <label for="filterEndMonth" class="form-label">Bulan Akhir:</label>
                    <select class="form-select" id="filterEndMonth"></select>
                </div>
                <div class="col-md-auto col-6 mt-3 mt-md-0">
                    <button class="btn btn-primary w-100" id="applyChartFilterButton">Terapkan</button>
                </div>
                <div class="col-md-auto col-6 mt-3 mt-md-0">
                    <button class="btn btn-secondary w-100" id="resetChartFilterButton">Reset</button>
                </div>
            </div>
        </div>


        <div class="mt-3" id="echartsContainerWrapper">
            <h3 id="chartTitle">Grafik Prediksi Permintaan Produk</h3>
            <div id="demandChartContainer"></div>
        </div>

        {{-- Loading Indicator --}}
        <div id="loadingOverlay" class="loading-overlay hidden">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span>Memproses prediksi, harap tunggu... <br>Ini mungkin memakan waktu beberapa saat.</span>
        </div>
    </div>
@endsection