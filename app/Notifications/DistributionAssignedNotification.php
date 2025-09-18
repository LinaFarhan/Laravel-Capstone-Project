<?php
 
namespace App\Notifications;

use App\Models\Distribution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DistributionAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $distribution;

    public function __construct(Distribution $distribution)
    {
        $this->distribution = $distribution;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📦 تم تعيينك لتوزيع مساعدة جديدة')
            ->greeting('مرحباً ' . $notifiable->name . '!')
            ->line('تم تعيينك لتوزيع مساعدة إلى مستفيد.')
            ->line('*المستفيد:* ' . $this->distribution->beneficiary->name)
            ->line('*نوع المساعدة:* ' . $this->getTypeArabic($this->distribution->donation->type))
            ->line('*الكمية:* ' . $this->distribution->donation->quantity)
            ->line('*العنوان:* ' . $this->distribution->beneficiary->address)
            ->line('*هاتف المستفيد:* ' . $this->distribution->beneficiary->phone)
            ->action('عرض تفاصيل المهمة', url('/volunteer/distributions/' . $this->distribution->id))
            ->line('يرجى التواصل مع المستفيد لتنسيق وقت التسليم.')
            ->line('شكراً لمساهمتك في عمل الخير!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'تم تعيينك لتوزيع مساعدة إلى ' . $this->distribution->beneficiary->name,
            'type' => 'info',
            'distribution_id' => $this->distribution->id,
            'beneficiary_name' => $this->distribution->beneficiary->name,
            'donation_type' => $this->distribution->donation->type,
            'action_url' => '/volunteer/distributions/' . $this->distribution->id,
            'icon' => '📦'
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