<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'منصة المساعدات الإنسانية')</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bundy.net/css?family=tajawal:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .bg-humanitarian {
            background: linear-gradient(135deg, #2563eb 0%, #10b981 100%);
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        @yield('content')
    </div>
</body>
</html>