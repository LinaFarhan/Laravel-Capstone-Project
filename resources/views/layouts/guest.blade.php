<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/OIP.webp') }}">
    <title>@yield('title', 'منصة المساعدات الإنسانية')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>
<body class="bg-blue-200">
    <div class="min-h-screen  items-center justify-center shadow">
        @yield('content')
    </div>
</body>
</html>
