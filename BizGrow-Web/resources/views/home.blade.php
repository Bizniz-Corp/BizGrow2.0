@extends('layout')

@section('title', 'Beranda')

@section('header', 'Beranda')

@section('cssCustom')
    {{ asset('css/Home.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/Home.js') }}
@endsection

@section('content')
    <div class="container">
        <div class="header" id="welcome"></div>

        <div class="profit-container">
            <div class="profit-box" id="profit-pembelian">
                Total Pembelian<br>Rp{{ number_format($totalPembelian, 0, ',', '.') }}
            </div>
            <div class="profit-box" id="profit-penjualan">
                Total Penjualan<br>Rp{{ number_format($totalPenjualan, 0, ',', '.') }}
            </div>
        </div>

        <div class="features-heading">Akses Fitur Cepat</div>

        <div class="features">
            <div class="feature">
                <a href="{{ route('penjualan.demand') }}">
                    <img src="{{ asset('images/demand.svg') }}" alt="logodemand">
                    <span>Demand</span>
                </a>
            </div>
            <div class="feature">
                <a href="{{ route('stok.bufferstok') }}">
                    <img src="{{ asset('images/Bufferstock.svg') }}" alt="logobufferstock">
                    <span>Bufferstock</span>
                </a>
            </div>
            <div class="feature">
                <a href="{{ route('penjualan.profit') }}">
                    <img src="{{ asset('images/Profit.svg') }}" alt="logoprofit">
                    <span>Profit</span>
                </a>
            </div>
            <div class="feature">
                <a href="{{ route('penjualan.riwayat') }}">
                    <img src="{{ asset('images/riwayatjualbeli.svg') }}" alt="logoriwayatjualbeli">
                    <span>Riwayat Penjualan</span>
                </a>
            </div>
            <div class="feature">
                <a href="{{ route('stok.riwayat') }}">
                    <img src="{{ asset('images/riwayatjualbeli.svg') }}" alt="logoriwayatjualbeli">
                    <span>Riwayat Stok</span>
                </a>
            </div>
            <div class="feature">
                <a href="{{ route('penjualan.input') }}">
                    <img src="{{ asset('images/document-upload.svg') }}" alt="logoinput">
                    <span>Input Data Penjualan</span>
                </a>
            </div>
        </div>

    </div>
@endsection
