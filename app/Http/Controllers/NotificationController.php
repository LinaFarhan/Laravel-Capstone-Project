<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * عرض جميع الإشعارات
     */
    public function index(Request $request)
    {
        try {
            $notifications = $request->user()
                ->notifications()
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('notifications.index', compact('notifications'));
        } catch (\Exception $e) {
            Log::error('Error fetching notifications: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'فشل في تحميل الإشعارات'], 500);
            }
            
            return redirect()->back()->with('error', 'فشل في تحميل الإشعارات');
        }
    }

    /**
     * عرض الإشعارات غير المقروءة فقط
     */
    public function unread(Request $request)
    {
        try {
            $notifications = $request->user()
                ->unreadNotifications()
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('notifications.index', compact('notifications'));
        } catch (\Exception $e) {
            Log::error('Error fetching unread notifications: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'فشل في تحميل الإشعارات غير المقروءة'], 500);
            }
            
            return redirect()->back()->with('error', 'فشل في تحميل الإشعارات غير المقروءة');
        }
    }

    /**
     * عرض إشعار معين
     */
    public function show(Request $request, $id)
    {
        try {
            $notification = $request->user()
                ->notifications()
                ->findOrFail($id);

            //标记 الإشعار كمقروء عند العرض
            if (is_null($notification->read_at)) {
                $notification->markAsRead();
            }

            return view('notifications.show', compact('notification'));
        } catch (\Exception $e) {
            Log::error('Error showing notification: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'الإشعار غير موجود'], 404);
            }
            
            return redirect()->route('notifications.index')
                ->with('error', 'الإشعار غير موجود');
        }
    }

    /**
     *标记 إشعار كمقروء
     */
    public function markAsRead(Request $request, $id)
    {
        try {
            $notification = $request->user()
                ->notifications()
                ->findOrFail($id);

            $notification->markAsRead();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم  الإشعار كمقروء'
                ]);
            }

            return redirect()->back()
                ->with('success', 'تم الإشعار كمقروء');
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'فشل في标记 الإشعار'], 500);
            }
            
            return redirect()->back()->with('error', 'فشل في标记 الإشعار');
        }
    }

    /**
     *标记 جميع الإشعارات كمقروءة
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $request->user()->unreadNotifications->markAsRead();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم标记 جميع الإشعارات كمقروءة'
                ]);
            }

            return redirect()->back()
                ->with('success', 'تم标记 جميع الإشعارات كمقروءة');
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'فشل في标记 جميع الإشعارات'], 500);
            }
            
            return redirect()->back()->with('error', 'فشل في标记 جميع الإشعارات');
        }
    }

    /**
     * حذف إشعار
     */
    public function destroy(Request $request, $id)
    {
        try {
            $notification = $request->user()
                ->notifications()
                ->findOrFail($id);

            $notification->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم حذف الإشعار'
                ]);
            }

            return redirect()->back()
                ->with('success', 'تم حذف الإشعار');
        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'فشل في حذف الإشعار'], 500);
            }
            
            return redirect()->back()->with('error', 'فشل في حذف الإشعار');
        }
    }

    /**
     * حذف جميع الإشعارات
     */
    public function destroyAll(Request $request)
    {
        try {
            $request->user()->notifications()->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم حذف جميع الإشعارات'
                ]);
            }

            return redirect()->route('notifications.index')
                ->with('success', 'تم حذف جميع الإشعارات');
        } catch (\Exception $e) {
            Log::error('Error deleting all notifications: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'فشل في حذف جميع الإشعارات'], 500);
            }
            
            return redirect()->back()->with('error', 'فشل في حذف جميع الإشعارات');
        }
    }

    /**
     * الحصول على عدد الإشعارات غير المقروءة (لـ API)
     */
    public function unreadCount(Request $request)
    {
        try {
            $count = $request->user()->unreadNotifications()->count();

            return response()->json([
                'unread_count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting unread notifications count: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'فشل في الحصول على عدد الإشعارات غير المقروءة'
            ], 500);
        }
    }

    /**
     * الحصول على الإشعارات الحديثة (لـ API)
     */
    public function recent(Request $request)
    {
        try {
            $notifications = $request->user()
                ->notifications()
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'data' => $notification->data,
                        'read_at' => $notification->read_at,
                        'created_at' => $notification->created_at->diffForHumans(),
                        'icon' => $this->getNotificationIcon($notification->type),
                        'color' => $this->getNotificationColor($notification->type)
                    ];
                });

            return response()->json($notifications);
        } catch (\Exception $e) {
            Log::error('Error getting recent notifications: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'فشل في الحصول على الإشعارات الحديثة'
            ], 500);
        }
    }

    /**
     * الحصول على إشعارات محددة حسب النوع (لـ API)
     */
    public function byType(Request $request, $type)
    {
        try {
            $validTypes = [
                'aid-request',
                'distribution',
                'donation',
                'system'
            ];

            if (!in_array($type, $validTypes)) {
                return response()->json([
                    'error' => 'نوع الإشعار غير صحيح'
                ], 400);
            }

            $notifications = $request->user()
                ->notifications()
                ->where('type', 'like', '%' . ucfirst($type) . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json($notifications);
        } catch (\Exception $e) {
            Log::error('Error getting notifications by type: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'فشل في الحصول على الإشعارات'
            ], 500);
        }
    }

    /**
     * الحصول على أيقونة الإشعار بناءً على النوع
     */
    protected function getNotificationIcon($type)
    {
        $icons = [
            'App\Notifications\AidRequestApprovedNotification' => '✅',
            'App\Notifications\AidRequestDeniedNotification' => '❌',
            'App\Notifications\DistributionAssignedNotification' => '📦',
            'App\Notifications\DonationReceivedNotification' => '🎁',
            'App\Notifications\NewAidRequestNotification' => '🆕',
            'App\Notifications\SystemMaintenanceNotification' => '🔧',
            'App\Notifications\WelcomeNotification' => '👋',
        ];

        return $icons[$type] ?? '📢';
    }

    /**
     * الحصول على لون الإشعار بناءً على النوع
     */
    protected function getNotificationColor($type)
    {
        $colors = [
            'App\Notifications\AidRequestApprovedNotification' => 'success',
            'App\Notifications\AidRequestDeniedNotification' => 'danger',
            'App\Notifications\DistributionAssignedNotification' => 'info',
            'App\Notifications\DonationReceivedNotification' => 'success',
            'App\Notifications\NewAidRequestNotification' => 'warning',
            'App\Notifications\SystemMaintenanceNotification' => 'secondary',
            'App\Notifications\WelcomeNotification' => 'primary',
        ];

        return $colors[$type] ?? 'secondary';
    }

    /**
     * تصدير الإشعارات (لـ API)
     */
    public function export(Request $request)
    {
        try {
            $user = $request->user();
            $format = $request->get('format', 'json');
            
            $notifications = $user->notifications()
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($format === 'csv') {
                $csvData = $this->formatNotificationsAsCsv($notifications);
                
                return response()->streamDownload(function () use ($csvData) {
                    echo $csvData;
                }, 'notifications.csv', [
                    'Content-Type' => 'text/csv',
                ]);
            }
            
            // Default to JSON
            return response()->json($notifications);
        } catch (\Exception $e) {
            Log::error('Error exporting notifications: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'فشل في تصدير الإشعارات'
            ], 500);
        }
    }
    
    /**
     * تنسيق الإشعارات كـ CSV
     */
    protected function formatNotificationsAsCsv($notifications)
    {
        $output = fopen('php://temp', 'w');
        
        // Add CSV headers
        fputcsv($output, [
            'ID',
            'النوع',
            'الرسالة',
            'الحالة',
            'تاريخ الإنشاء',
            'تاريخ القراءة'
        ]);
        
        // Add data rows
        foreach ($notifications as $notification) {
            fputcsv($output, [
                $notification->id,
                $this->getNotificationTypeName($notification->type),
                $notification->data['message'] ?? '',
                $notification->read_at ? 'مقروء' : 'غير مقروء',
                $notification->created_at->format('Y-m-d H:i:s'),
                $notification->read_at ? $notification->read_at->format('Y-m-d H:i:s') : ''
            ]);
        }
        
        rewind($output);
        $csvData = stream_get_contents($output);
        fclose($output);
        
        return $csvData;
    }
    
    /**
     * الحصول على اسم نوع الإشعار بشكل مقروء
     */
    protected function getNotificationTypeName($type)
    {
        $names = [
            'App\Notifications\AidRequestApprovedNotification' => 'موافقة على طلب مساعدة',
            'App\Notifications\AidRequestDeniedNotification' => 'رفض طلب مساعدة',
            'App\Notifications\DistributionAssignedNotification' => 'تعيين توزيع',
            'App\Notifications\DonationReceivedNotification' => 'استلام تبرع',
            'App\Notifications\NewAidRequestNotification' => 'طلب مساعدة جديد',
            'App\Notifications\SystemMaintenanceNotification' => 'صيانة النظام',
            'App\Notifications\WelcomeNotification' => 'ترحيب',
        ];
        
        return $names[$type] ?? $type;
    }
}