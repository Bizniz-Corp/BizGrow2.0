@extends('layout')

@section('title', 'Input Stok Manual')

@section('jsCustom')
    {{ asset('js/input_file.js') }}
@endsection

@section('header', 'Input Data Stok')

@section('content')
     <div class="wrapper">
        <div class="main">
            <div class="content overflow-y-auto">
                <div class="m-5 align-items-center">
                    <div class="form-container position-absolute top-50 start-50 translate-middle">
                        <h1 class="text-center">Input Data Manual</h1>
                        <form id="inputForm">
                            <div class="m-3">
                                <label for="tanggal" class="form-label">Tanggal:</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="m-3">
                                <label for="namaProduk" class="form-label">Nama Produk:</label>
                                <input type="text" class="form-control" id="namaProduk" name="namaProduk" required>
                            </div>
                            <div class="m-3">
                                <label for="kuantitas" class="form-label">Kuantitas Perubahan:</label>
                                <input type="number" class="form-control" id="kuantitas" name="kuantitas" required>
                            </div>
                            <div class="m-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Kirim Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
     </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
@endsection