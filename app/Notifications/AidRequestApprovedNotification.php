<?php
 
namespace App\Notifications;

use App\Models\AidRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AidRequestApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $aidRequest;

    public function __construct(AidRequest $aidRequest)
    {
        $this->aidRequest = $aidRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('✅ تمت الموافقة على طلب المساعدة الخاص بك')
            ->greeting('مرحباً ' . $notifiable->name . '!')
            ->line('يسعدنا إعلامك أنه تمت الموافقة على طلب المساعدة الذي قدمته.')
            ->line('*نوع المساعدة:* ' . $this->getTypeArabic($this->aidRequest->type))
            ->line('*وصف الطلب:* ' . $this->aidRequest->description)
            ->action('عرض تفاصيل الطلب', url('/beneficiary/aid-requests/' . $this->aidRequest->id))
            ->line('سيتم التواصل معك قريباً لتنسيق عملية التوزيع.')
            ->line('شكراً لثقتك بمنصتنا!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'تمت الموافقة على طلب المساعدة الخاص بك',
            'type' => 'success',
            'request_id' => $this->aidRequest->id,
            'request_type' => $this->aidRequest->type,
            'action_url' => '/beneficiary/aid-requests/' . $this->aidRequest->id,
            'icon' => '✅'
        ];
    }

    protected function getTypeArabic($type)
    {
        $types = [
            'food' => 'طعام',
            'clothing' => 'ملابس',
            'medical' => 'مساعدات طبية',
            'financial' => 'مساعدات مالية',
            'other' => 'أخرى'
        ];

        return $types[$type] ?? $type;
    }
}