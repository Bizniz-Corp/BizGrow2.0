@extends('layout')

@section('title', 'Input Penjualan File')

@section('cssCustom')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/riwayat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/input.css') }}"> --}}
@endsection

@section('jsCustom')
    {{ asset('js/input_file_penjualan.js') }}
@endsection

@section('header', 'Input Data Penjualan')

@section('content')
     <div class="wrapper">
        <div class="main">
            <div class="content overflow-y-auto">
                <div class="align-items-center">
                    <div class="form-container position-absolute top-50 start-50 translate-middle">
                        <div class="m-3">
                            <h1 class="text-center">Input Data File</h1>
                        </div>
                        <div class="m-3">
                            <input type="file" id="fileInputPenjualan" class="form-control mb-3" accept=".xls,.xlsx">
                        </div>
                        <div class="m-3">
                            <p id="infoMessagePenjualan" class="text-muted">File belum dipilih</p>
                        </div>
                        <div class="m-3 d-flex justify-content-center">
                            <button id="submitButtonPenjualan" class="btn btn-primary" disabled>Kirim File</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/input_file.js"></script>
@endsection