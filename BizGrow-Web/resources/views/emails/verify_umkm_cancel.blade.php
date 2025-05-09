@extends('emails.email_layout')

@section('content')
    <div style="font-size: 22px; font-weight: bold; color: #c93d06; margin-bottom: 10px;">
        Verifikasi UMKM Anda Gagal!
    </div>

    <p style="font-weight: bold">Hai {{ $name ?? 'Pengguna' }},</p>

    <p>Maaf UMKM anda ditolak verifikasinya. Alasan penolakan:</p>

    <p style="font-weight: bold; color: #000000;">{{ $messageCancel ?? 'Tidak ada pesan penolakan' }}</p>

    <p>Silahkan perbaiki data UMKM Anda dan lakukan pengajuan ulang.</p>

    <a href="{{ url('/register') }}"
        style="background-color: #4457ff; color: white !important; padding: 10px 20px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 20px;">
        Register UMKM
    </a>
@endsection
