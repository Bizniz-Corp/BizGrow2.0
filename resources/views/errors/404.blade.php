@extends('hnf')

@section('title', '404 - Page Not Found')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="container text-center py-5">
        <h1 class="display-1 fw-bold text-danger">404</h1>
        <h2 class="mb-3">Halaman Tidak Ditemukan</h2>
        <p class="lead mb-4">
            Maaf, halaman yang Anda cari tidak ditemukan atau sudah dipindahkan.
        </p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">
            <i class="bi bi-house-door me-2"></i>
            Kembali
        </a>
    </div>
</div>
@endsection
