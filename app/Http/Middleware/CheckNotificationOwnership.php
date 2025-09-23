<?php
 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Symfony\Component\HttpFoundation\Response;

class CheckNotificationOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $notificationId = $request->route('id');
        
        if ($notificationId) {
            $notification = DatabaseNotification::find($notificationId);
            
            if (!$notification || $notification->notifiable_id !== $request->user()->id) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'غير مصرح بالوصول إلى هذا الإشعار'], 403);
                }
                
                abort(403, 'غير مصرح بالوصول إلى هذا الإشعار');
            }
        }
        
        return $next($request);
    }
}