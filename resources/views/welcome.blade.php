<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة المساعدات الإنسانية</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-100 font-sans antialiased">
    {{-- الخلفية صورة --}}
    <div class="min-h-screen flex flex-col items-center justify-center text-center p-6" 
         style="background-image: url('https://images.unsplash.com/photo-1601597113551-1197ff7c27bb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80'); 
                background-size: cover; 
                background-position: center;">
        
        {{-- غطاء شبه شفاف --}}
        <div class="bg-white/80 p-100% rounded-3xl shadow-xl max-w-lg flex flex-col items-center">
            
            {{-- الشعار أصغر --}}
            <img src="https://tse4.mm.bing.net/th/id/OIP.SbxL2ir4kMfaSxgvlSk5RgAAAA?rs=1&pid=ImgDetMain&o=7&rm=3"
                 alt="شعار إنساني"
                 class=" mb-4 drop-shadow-lg">

            {{-- العنوان والنص متوسط --}}
            <h1 class="text-3xl font-extrabold text-red-700 mb-2">مرحبًا بك</h1>
            <h2 class="text-lg text-orange-600 mb-4">في منصة المساعدات الإنسانية</h2>

            <p class="text-gray-700 mb-6 leading-relaxed">
                نسعى لربط <span class="font-semibold text-red-600">المتطوعين</span> 
                مع <span class="font-semibold text-orange-500">المستفيدين</span> 
                لتقديم المساعدات بسهولة وسرعة.
            </p>

            {{-- الأزرار بالأسفل --}}
            <div class="flex justify-center gap-4 mt-4 w-full">
                <a href="{{ route('login') }}" 
                   class="flex-1 px-6 py-3 bg-red-600 text-white font-semibold rounded-xl shadow-lg hover:bg-red-700 hover:shadow-xl transition duration-300 text-center">
                    تسجيل الدخول
               <a href="{{ route('register.choose') }}" 
                    class="flex-1 px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl shadow-lg hover:bg-orange-600 hover:shadow-xl transition duration-300 text-center">
                       إنشاء حساب
                </a>

            </div>

        </div>
    </div>
</body>
</html>
