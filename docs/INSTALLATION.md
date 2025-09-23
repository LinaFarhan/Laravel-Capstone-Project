docs/USAGE.mddocs/USAGE.md
انشاء المشروع
 composer create-project laravel/laravel  humanitarian-aid-managemen-platform
تثبيت حزم المصادقة
composer require laravel/breeze --dev
php artisan breeze:install blade

تثبيت الحزم الاضافية
composer require laravel/sanctum
composer require intervention/image
php artisan sanctum:install
تثبيت حزم نود
npm install
npm install vue@next @ vitejs/plugin-vue
npm install pinia
npm install vue-toatification@next
npm install axios
تاكد من تثبت المتطلبات
PHP --version
composer --version
node --version
npm --version
mysql --version



انشاء قاعدة البيانات

mysql -u root -p
CREATE DATABASE humanitarian-aid-managemen-platform;
use humanitarian-aid-managemen-platform;


اوامر مسح الذاكرة الموقتة مشاكل في الذاكرة
php artisan optimize:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
اعادة بناء التطبيق assets
npm run build
or
npm run dev
composer dump-autoload

توليد مفتاح
php artisan key:generate
مشاكل 
الاعتمادات
copmoser install
npm install
مشاكل قاعدة البيانات
php artisan migrate:fresh

php artisan db:seed
php artisan migrate:fresh --seed
مشاكل في التخزين (انشاء رابط التخزين)
php artisan storage:link
مشاكل البريد
mailpit
تثبيت 
mailpit
scoop install mailpit
mailpit
mailpit --smtp 1025 --http 8025
Test
php artisan test
php artisan --filter=AdminDashboardTest

*run
 php artisan serve
 php artisan serve --port=8000