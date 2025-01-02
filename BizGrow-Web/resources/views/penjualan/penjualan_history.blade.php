@extends('layout')

@section('title', 'Riwayat Penjualan')

@section('header', 'Riwayat Penjualan')

@section('cssCustom')
    {{ asset('css/riwayat.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/penjualan_history.js') }}
@endsection


@section('content')
    <div class="filter-container m-5 d-flex align-items-center">
        <button class="btn btn-primary me-2" id="filterButton" data-bs-toggle="modal" data-bs-target="#filterModal">
            <img src="{{ asset('images/filter.svg') }}" alt="filter-icon"> Filter
        </button>
        <button class="btn btn-primary me-2" id="resetButton">
            <img src="{{ asset('images/refresh.svg') }}" alt="reset-icon"> Reset
        </button>

        <div class="me-3">
            <label for="startDate" class="me-2">Tanggal Awal:</label>
            <input type="date" id="startDate" class="form-control d-inline">
        </div>

        <div>
            <label for="endDate" class="me-2">Tanggal Akhir:</label>
            <input type="date" id="endDate" class="form-control d-inline">
        </div>
    </div>

    <div class="mx-5 mb-5">
        <table class="table table-primary table-striped text-center align-middle table-borderless">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Kuantitas</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center align-items-center mt-4"></div>
    </div>

    <!-- Filter Dialog Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h5" id="filterModalLabel">Filter Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="productFilter" class="form-label">Pilih Produk</label>
                    <select class="form-select" id="productFilter">

                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="applyFilter">Terapkan Filter</button>
                </div>
            </div>
        </div>
    </div>
@endsection
