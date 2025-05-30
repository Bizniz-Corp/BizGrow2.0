@extends('layout')

@section('title', 'Input Data Stok')

@section('header', 'Input Data Stok')

@section('cssCustom')
    {{ asset('css/input.css') }}
@endsection

@section('jsCustom')
    {{ asset('js/stok_input.js') }}
@endsection


@section('content')
        <div class="main">
            <div class="button-container">
                <button class="btn-custom" onclick="showAlertAndNavigate('manual')">
                    <img src="{{ asset('images/input_manual.png') }}" alt="Input Manual">
                    Input Data Manual
                </button>
                <button class="btn-custom" onclick="showAlertAndNavigate('file')">
                    <img src="{{ asset('images/input_file.png') }}" alt="Input File">
                    Input Data File
                </button>
            </div>
        </div>
@endsection
