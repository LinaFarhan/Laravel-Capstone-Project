<?php
 
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء مسؤولين
        User::factory()->admin()->count(3)->create([
            'password' => Hash::make('admin123'),
        ]);

        // إنشاء متطوعين
        User::factory()->volunteer()->count(10)->create([
            'password' => Hash::make('volunteer123'),
        ]);

        // إنشاء مستفيدين
        User::factory()->beneficiary()->count(50)->create([
            'password' => Hash::make('beneficiary123'),
        ]);

        // إنشاء مستخدم افتراضي للاختبار
        User::factory()->admin()->create([
            'name' => 'المسؤول الرئيسي',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->volunteer()->create([
            'name' => 'متطوع نموذجي',
            'email' => 'volunteer@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->beneficiary()->create([
            'name' => 'مستفيد نموذجي',
            'email' => 'beneficiary@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}