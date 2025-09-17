<?php
 
namespace Database\Seeders;

use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // إنشاء إشعارات غير مقروءة
            DatabaseNotification::factory()
                ->count(3)
                ->unread()
                ->create([
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $user->id,
                ]);

            // إنشاء إشعارات مقروءة
            DatabaseNotification::factory()
                ->count(5)
                ->read()
                ->create([
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $user->id,
                ]);
        }

        // إشعارات خاصة للمسؤولين
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DatabaseNotification::factory()
                ->count(5)
                ->create([
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $admin->id,
                    'type' => 'App\Notifications\NewAidRequestNotification',
                    'data' => json_encode([
                        'message' => 'طلب مساعدة جديد يحتاج المراجعة',
                        'action_url' => '/admin/aid-requests',
                        'type' => 'info'
                    ])
                ]);
        }
    }
}