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
        
        .guest-container {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" opacity="0.1"><circle cx="50" cy="50" r="40" fill="%232563eb"/></svg>');
            background-size: 300px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen guest-container">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-2xl">🤝</span>
                        <h1 class="text-xl font-bold text-gray-800 mr-2">منصة المساعدات الإنسانية</h1>
                    </div>
                    <nav class="hidden md:flex space-x-6 space-x-reverse">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">إنشاء حساب</a>
                        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900">الرئيسية</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center text-gray-600">
                    <p>© 2024 منصة المساعدات الإنسانية. جميع الحقوق محفوظة.</p>
                    <p class="text-sm mt-2">منصة العطاء والإنسانية</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>