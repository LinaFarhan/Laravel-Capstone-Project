<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>منصة المساعدات الإنسانية - @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bundy.net/css?family=tajawal:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
   
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <nav class="sidebar fixed top-0 right-0 h-full w-64 hidden md:block">
            <div class="p-6">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-white">🤝 منصة المساعدات</h1>
                    <p class="text-blue-200 text-sm">منصة العطاء والإنسانية</p>
                </div>

                <ul class="space-y-2">
                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            📊 لوحة التحكم
                        </a>
                    </li>
                    
                    @if(auth()->user()->isAdmin())
                    <!-- Admin Links -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            🏠 لوحة المسؤول
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            👥 إدارة المستخدمين
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.donations.index') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            🎁 إدارة التبرعات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.aid-requests.index') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            📋 طلبات المساعدة
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.distributions.index') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            🚚 إدارة التوزيعات
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isVolunteer())
                    <!-- Volunteer Links -->
                    <li>
                        <a href="{{ route('volunteer.dashboard') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            🏠 لوحة المتطوع
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.distributions.index') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            📦 المهام الموكلة
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isBeneficiary())
                    <!-- Beneficiary Links -->
                    <li>
                        <a href="{{ route('beneficiary.dashboard') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            🏠 لوحة المستفيد
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('beneficiary.aid-requests.index') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                            📨 طلباتي
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('beneficiary.aid-requests.create') }}" class="nav-link flex items-center p-3 text-white hover:bg-blue-800">
                           ➕ طلب جديد
                        </a>
                    </li>
                    @endif

                    <li class="border-t border-gray-700 pt-4 mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link flex items-center p-3 text-red-300 hover:bg-red-800 w-full text-right">
                                🚪 تسجيل الخروج
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="md:mr-64">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                            <p class="text-gray-600">@yield('subtitle')</p>
                        </div>
                        
                        <div class="flex items-center space-x-4 space-x-reverse">
                            @auth
                            <span class="text-sm text-gray-600">مرحباً، {{ auth()->user()->name }}</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                {{ auth()->user()->getRoleName() }}
                            </span>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Notifications -->
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        ✅ {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        ❌ {{ session('error') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>❌ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Dark mode toggle
        const toggleDarkMode = () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        };

        // Check saved preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>