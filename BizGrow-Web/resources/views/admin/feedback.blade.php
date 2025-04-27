@extends('admin/layout')

@section('title', 'Feedback UMKM')

@section('header')
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.feedback') }}">
            <h3 class="h3 fw-bold mb-0 text-dark">Feedback UMKM</h3>
        </a>
    </div>
@endsection

@section('cssCustom')
    {{ asset('css/admin.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/admin_feedback.js') }}
@endsection

@section('content')

    <div class="filter-container m-5 d-flex align-items-center">
        <input type="text" id="umkmNameInput" class="form-control me-3" style="width: 300px;" placeholder="Cari Nama Toko">
        <button class="btn btn-primary" id="resetButton">
            <img src="{{ asset('images/refresh.svg') }}" alt="reset-icon"> Reset
        </button>
    </div>

    <div class="mx-5 mb-5">
        <table class="table  table-striped align-middle table-borderless">
            <thead class="table-dark">
                <tr>
                    <th scope="col">UMKM</th>
                    <th scope="col">Feedback</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="pagination" class="d-flex justify-content-center align-items-center mt-4"></div>
    </div>
@endsection