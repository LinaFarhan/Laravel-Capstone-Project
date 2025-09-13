<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AidRequest;
use App\Models\VolunteerProfile;
use App\Models\Distribution;
use Faker\Factory as FakerFactory;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   // database/seeders/DatabaseSeeder.php
// database/seeders/DatabaseSeeder.php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    // تهيئة Faker بالعربية
    $faker = FakerFactory::create('ar_SA');

    // إنشاء مسؤول
    $admin = User::factory()->admin()->create();

    // إنشاء 5 متطوعين
    $volunteers = User::factory()->count(5)
        ->has(VolunteerProfile::factory())
        ->create();

    // إنشاء 15 طلب مساعدة
    $aidRequests = AidRequest::factory()->count(15)->create();

    // إنشاء 7 عمليات توزيع
    $distributions = Distribution::factory()->count(7)->create();

    // ربط عمليات التوزيع بطلبات مساعدة عشوائية
    foreach ($distributions as $distribution) {
        $randomAidRequests = $aidRequests->random(rand(2, 4));
        $distribution->aidRequests()->attach($randomAidRequests);
    }

    // رسالة تأكيد
    $this->command->info('تم إنشاء بيانات تجريبية عربية بنجاح!');
}  }


