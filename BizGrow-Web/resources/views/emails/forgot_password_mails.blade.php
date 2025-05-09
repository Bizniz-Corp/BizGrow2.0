@extends('emails.email_layout')

@section('content')
    <div style="font-size: 22px; font-weight: bold; color: #4457ff; margin-bottom: 10px;">
        Reset Password
    </div>

    <p>Hai</p>

    <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.</p>

    <a href="{{ url('/reset-password?token=' . $token) }}"
        style="background-color: #4457ff; color: white !important; padding: 10px 20px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 20px;">
        Atur Ulang Password
    </a>
@endsection
