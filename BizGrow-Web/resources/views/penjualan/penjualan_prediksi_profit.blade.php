@extends('layout')

@section('title', 'Prediksi Profit Penjualan')

@section('header', 'Prediksi Profit Penjualan Harian')

@section('cssCustom')
    {{ asset('css/prediksi_profit.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/prediksi_profit.js') }}
@endsection

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Data Profit Harian</h2>
            <button class="btn btn-success" id="predictButton">
                Prediksi Profit
            </button>
        </div>

        <div id="alert-container" class="mb-3"></div>

        <div class="filter-controls mb-4 p-3 border rounded bg-light" id="chartFilterControls" style="display: none;"> {{-- Awalnya disembunyikan --}}
            <h4 class="mb-3">Filter Grafik</h4>
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="filterStartYear" class="form-label">Tahun Mulai:</label>
                    <select class="form-select" id="filterStartYear"></select>
                </div>
                <div class="col-md-2">
                    <label for="filterStartMonth" class="form-label">Bulan Mulai:</label>
                    <select class="form-select" id="filterStartMonth">
                        {{-- Opsi bulan akan diisi oleh JS --}}
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filterEndYear" class="form-label">Tahun Akhir:</label>
                    <select class="form-select" id="filterEndYear"></select>
                </div>
                <div class="col-md-2">
                    <label for="filterEndMonth" class="form-label">Bulan Akhir:</label>
                    <select class="form-select" id="filterEndMonth">
                        {{-- Opsi bulan akan diisi oleh JS --}}
                    </select>
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-primary w-100" id="applyChartFilterButton">Terapkan Filter</button>
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-secondary w-100" id="resetChartFilterButton">Reset Filter</button>
                </div>
            </div>
        </div>

        <div class="mt-5" id="echartsContainerWrapper">
            <h3>Grafik Prediksi Profit</h3>
            <div id="profitChartContainer"></div>
        </div>

        <div class="table-responsive">
            <table class="table table-primary table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col" style="width: 25%;">Tanggal</th>
                        <th scope="col" style="width: 40%;">Total Profit Harian</th>
                        <th scope="col" style="width: 30%;">Status</th>
                    </tr>
                </thead>
                <tbody id="profitTableBody">
                    <tr>
                        <td colspan="4">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Loading Indicator --}}
        <div id="loadingOverlay" class="loading-overlay hidden">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span>Memproses prediksi, harap tunggu... <br>Ini mungkin memakan waktu beberapa saat.</span>
        </div>

        {{-- Area untuk Chart.js (nanti) --}}
        <div class="mt-5" id="chartContainer" style="display: none;">
            <h3>Grafik Prediksi Profit</h3>
            <canvas id="profitChart"></canvas>
        </div>
    </div>
@endsection