<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BizGrow Email' }}</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; padding: 30px; color: #343a40;">
    <div
        style="background-color: #ffffff; padding: 25px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);">
        @yield('content')

        <div style="font-size: 12px; margin-top: 30px; color: #868e96; text-align: center;">
            Email ini dikirim secara otomatis oleh sistem BizGrow.<br>
            Jika kamu tidak merasa melakukan aktivitas ini, silakan abaikan email ini.
        </div>
    </div>
</body>

</html>
