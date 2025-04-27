@extends('admin/layout')

@section('title', 'Verifikasi UMKM')

@section('header')
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.data_umkm') }}">
            <h3 class="h3 fw-bold mb-0 text-dark">Verifikasi UMKM</h3>
        </a>
    </div>
@endsection

@section('cssCustom')
    {{ asset('css/admin.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/admin_verifikasi.js') }}
@endsection

@section('content')
    <br/>
    <p class="text-center fs-3 fw-bold">Data Permintaan Verifikasi UMKM</p>

    <div class="filter-container m-5 d-flex align-items-center">
        <input type="text" id="umkmNameInput" class="form-control me-3" style="width: 300px;" placeholder="Cari Nama Toko">
        <button class="btn btn-primary" id="resetButton">
            <img src="{{ asset('images/refresh.svg') }}" alt="reset-icon"> Reset
        </button>
    </div>

    <div class="mx-5 mb-5">
        <table class="table  table-striped text-center align-middle table-borderless">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Status</th>
                    <th scope="col">NPWP</th>
                    <th scope="col">Surat Izin</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center align-items-center mt-4"></div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmationMessage">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmActionButton">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
