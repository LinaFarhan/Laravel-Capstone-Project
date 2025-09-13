<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AidRequest;
use App\Models\VolunteerProfile;
use App\Models\Distribution;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   // database/seeders/DatabaseSeeder.php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    // إنشاء مسؤول
    $admin = User::factory()->admin()->create();

    // إنشاء 3 متطوعين (كل منهم له volunteerProfile)
    $volunteers = User::factory()->count(3)
        ->has(VolunteerProfile::factory())
        ->create();

    // إنشاء 10 طلب مساعدة
    $aidRequests = AidRequest::factory()->count(10)->create();

    // إنشاء 5 عمليات توزيع
    $distributions = Distribution::factory()->count(5)->create();

    // ربط عمليات التوزيع بطلبات مساعدة عشوائية
    foreach ($distributions as $distribution) {
        // نربط كل توزيع ب 2-4 طلبات عشوائية
        $randomAidRequests = $aidRequests->random(rand(2, 4));
        $distribution->aidRequests()->attach($randomAidRequests);
    }
}
}
