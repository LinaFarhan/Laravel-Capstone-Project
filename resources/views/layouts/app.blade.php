<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/OIP.webp') }}">
    <title>منصة المساعدات الإنسانية - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="bg-blue-100 font-[Tajawal]">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <nav class="sidebar fixed top-0 right-0 h-full w-64 hidden md:block bg-gradient-to-b  bg-gray-100   shadow-lg">
            <div class="p-6">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-red-500">🤝 منصة المساعدات</h1>
                    <p class="text-blue-500 text-sm">منصة العطاء والإنسانية</p>
                </div>

                <ul class="space-y-2">
                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold hover:bg-blue-600 transition">
                            📊 لوحة التحكم
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            🏠 لوحة المسؤول
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            👥 إدارة المستخدمين
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.donations.index') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            🎁 إدارة التبرعات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.aid-requests.index') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            📋 طلبات المساعدة
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.distributions.index') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            🚚 إدارة التوزيعات
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isVolunteer())
                    <li>
                        <a href="{{ route('volunteer.dashboard') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            🏠 لوحة المتطوع
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.distributions.index') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            📦 المهام الموكلة
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->isBeneficiary())
                    <li>
                        <a href="{{ route('beneficiary.dashboard') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                            🏠 لوحة المستفيد
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('beneficiary.aid-requests.index') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold hover:bg-blue-600 transition">
                            📨 طلباتي
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('beneficiary.aid-requests.create') }}"
                           class="flex items-center p-3 rounded-lg text-black font-bold  hover:bg-blue-600 transition">
                           ➕ طلب جديد
                        </a>
                    </li>
                    @endif

                    <li class="border-t border-blue-500 pt-4 mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center p-3 rounded-lg   font-bold text-red-300 hover:bg-red-700 hover:text-white transition w-full text-right">
                                🚪 تسجيل الخروج
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="md:mr-64 flex-1">
            <!-- Header -->
            <header class="bg-white shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                            <p class="text-gray-500">@yield('subtitle')</p>
                        </div>

                        <div class="flex items-center space-x-4 space-x-reverse">
                            @auth
                            <span class=" font-bold text-red-600">مرحباً: {{ auth()->user()->name }}</span>
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
                    @yield('content')
                </div>
            </div>
        </main>
    </div>



    <!-- Scripts -->
    <script>
 console.log('Vue app loaded:', typeof app !== 'undefined');
console.log('Current user role:', '{{ auth()->user()->role ?? "none" }}');
console.log('Routes test:', {
    beneficiary_create: '{{ route("beneficiary.aid-requests.create") }}',
    volunteer_distributions: '{{ route("volunteer.distributions.index") }}',
    admin_users: '{{ route("admin.users.index") }}'
});

// اختبر إذا كانت الروابط تعمل
document.addEventListener('click', function(e) {
    if (e.target.closest('a')) {
        const link = e.target.closest('a');
        console.log('Link clicked:', link.href, link.getAttribute('href'));
    }
});

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
