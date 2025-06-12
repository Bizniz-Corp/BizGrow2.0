@extends('layout')

@section('title', 'Prediksi Buffer Stok')

@section('header', 'Prediksi Buffer Stok')

@section('cssCustom')
    {{ asset('css/prediksi_profit.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/prediksi_profit.js') }}
@endsection

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center" style="min-height:60vh;">
    <img src="{{ asset('images/coming-soon.svg') }}" alt="Coming Soon" style="max-width:220px;">
    <h2 class="mt-4 mb-2">Fitur Segera Hadir!</h2>
    <p class="text-muted mb-4">Halaman atau fitur ini sedang dalam pengembangan.<br>Silakan kembali lagi nanti.</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
</div>
@endsection