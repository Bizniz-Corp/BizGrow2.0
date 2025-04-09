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
    <br>

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
@endsection