<?php
 
namespace App\Notifications;

use App\Models\AidRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAidRequestNotification extends Notification implements ShouldQueue
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
            ->subject('🆕 طلب مساعدة جديد يحتاج المراجعة')
            ->greeting('مرحباً ' . $notifiable->name . '!')
            ->line('هناك طلب مساعدة جديد على المنصة يحتاج إلى مراجعتك.')
            ->line('*المستفيد:* ' . $this->aidRequest->beneficiary->name)
            ->line('*نوع المساعدة:* ' . $this->getTypeArabic($this->aidRequest->type))
            ->line('*وقت الطلب:* ' . $this->aidRequest->created_at->format('Y-m-d H:i'))
            ->action('مراجعة الطلب', url('/admin/aid-requests/' . $this->aidRequest->id))
            ->line('يرجى مراجعة الطلب والرد عليه في أقرب وقت ممكن.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'طلب مساعدة جديد من ' . $this->aidRequest->beneficiary->name,
            'type' => 'info',
            'request_id' => $this->aidRequest->id,
            'beneficiary_name' => $this->aidRequest->beneficiary->name,
            'request_type' => $this->aidRequest->type,
            'action_url' => '/admin/aid-requests/' . $this->aidRequest->id,
            'icon' => '🆕'
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