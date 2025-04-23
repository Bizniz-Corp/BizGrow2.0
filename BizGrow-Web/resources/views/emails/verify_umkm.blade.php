@extends('emails.email_layout')

@section('content')
    <div style="font-size: 22px; font-weight: bold; color: #4457ff; margin-bottom: 10px;">
        UMKM Anda Telah Diverifikasi!
    </div>

    <p>Hai {{ $name ?? 'Pengguna' }},</p>

    <p>Selamat! UMKM Anda telah berhasil diverifikasi oleh tim BizGrow.</p>

    <p>Anda sekarang bisa menggunakan seluruh fitur yang tersedia untuk mengembangkan usaha Anda.</p>

    <a href="{{ url('/login') }}"
        style="background-color: #4457ff; color: white !important; padding: 10px 20px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 20px;">
        Login ke Dashboard
    </a>
@endsection
