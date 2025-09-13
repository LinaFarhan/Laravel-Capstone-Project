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
public function run(): void
{
    // إنشاء مسؤول
    $admin = User::factory()->admin()->create();

    // إنشاء 3 متطوعين (كل منهم له volunteerProfile)
    $volunteers = User::factory()->count(3)
        ->has(VolunteerProfile::factory()) // أنشئ profile لكل متطوع
        ->create();

    // إنشاء 10 طلب مساعدة (لكل طلب beneficiary جديد)
    AidRequest::factory()->count(10)->create();

    // (اختياري) إنشاء عمليات توزيع وتعيينها لطلبات
    Distribution::factory()->count(5)
        ->hasAttached( // ربطها بطلبات عشوائية
            AidRequest::factory()->count(2),
            ['created_at' => now(), 'updated_at' => now()]
        )->create();
}
}
