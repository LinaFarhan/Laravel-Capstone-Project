<?php
 
namespace App\Notifications;

use App\Models\AidRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AidRequestDeniedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $aidRequest;
    public $reason;

    public function __construct(AidRequest $aidRequest, $reason = null)
    {
        $this->aidRequest = $aidRequest;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('❌ حالة طلب المساعدة الخاص بك')
            ->greeting('عزيزي/عزيزتي ' . $notifiable->name)
            ->line('نأسف لإعلامك أنه لم يمكن الموافقة على طلب المساعدة الذي قدمته.');

        if ($this->reason) {
            $mail->line('*السبب:* ' . $this->reason);
        }

        $mail->line('*نوع المساعدة:* ' . $this->getTypeArabic($this->aidRequest->type))
            ->line('*وصف الطلب:* ' . $this->aidRequest->description)
            ->action('عرض تفاصيل الطلب', url('/beneficiary/aid-requests/' . $this->aidRequest->id))
            ->line('يمكنك تعديل الطلب وإعادة إرساله أو التواصل معنا للمزيد من المعلومات.')
            ->line('نشكرك على تفهمك.');

        return $mail;
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'لم يتم الموافقة على طلب المساعدة الخاص بك' . ($this->reason ? ': ' . $this->reason : ''),
            'type' => 'error',
            'request_id' => $this->aidRequest->id,
            'request_type' => $this->aidRequest->type,
            'action_url' => '/beneficiary/aid-requests/' . $this->aidRequest->id,
            'icon' => '❌',
            'reason' => $this->reason
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