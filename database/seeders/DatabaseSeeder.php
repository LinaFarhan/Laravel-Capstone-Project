<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Donation;
use App\Models\AidRequest;
use App\Models\Distribution;
use App\Models\Notification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء أدمن واحد
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        // إنشاء متطوعين
        $volunteers = User::factory(5)->create([
            'role' => 'volunteer',
        ]);

        // إنشاء مستفيدين
        $beneficiaries = User::factory(10)->create([
            'role' => 'beneficiary',
        ]);

        // إنشاء تبرعات
        $donations = Donation::factory(20)->create();


        // إنشاء طلبات مساعدة مرتبطة بالمستفيدين
        foreach ($beneficiaries as $beneficiary) {
            AidRequest::factory(rand(1, 3))->create([
                'beneficiary_id' => $beneficiary->id,
            ]);
        }

        // إنشاء توزيعات مرتبطة بالمتطوعين + المستفيدين + التبرعات
        foreach ($donations as $donation) {
            Distribution::factory()->create([
                'volunteer_id' => $volunteers->random()->id,
                'beneficiary_id' => $beneficiaries->random()->id,
                'donation_id' => $donation->id,
            ]);
        }

        // إشعارات للمستفيدين والمتطوعين
        foreach ($beneficiaries->merge($volunteers) as $user) {
            Notification::factory(rand(1, 2))->create([
                'user_id' => $user->id,
            ]);
        }




    $this->command->info('✅تم إنشاء البيانات التجريبية بنجاح!');
    $this->command->info('😎 المسؤول: admin@aid.com / password');
    $this->command->info('📊 الإحصائيات:');
    $this->command->info('   - ' . User::count() . ' مستخدم');
    $this->command->info('   - ' . Donation::count() . ' تبرع');
    $this->command->info('   - ' . AidRequest::count() . ' طلب مساعدة');
    $this->command->info('   - ' . Distribution::count() . ' عملية توزيع');
    }
 }


