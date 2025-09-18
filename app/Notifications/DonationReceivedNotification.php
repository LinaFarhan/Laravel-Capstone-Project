<?php
 
namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎁 تم استلام تبرع جديد')
            ->greeting('مرحباً ' . $notifiable->name . '!')
            ->line('يسعدنا إعلامك أنه تم استلام تبرع جديد على المنصة.')
            ->line('*اسم المتبرع:* ' . $this->donation->donor_name)
            ->line('*نوع التبرع:* ' . $this->getTypeArabic($this->donation->type))
            ->line('*الكمية:* ' . $this->donation->quantity)
            ->line('*الحالة:* ' . $this->getStatusArabic($this->donation->status))
            ->action('عرض تفاصيل التبرع', url('/admin/donations/' . $this->donation->id))
            ->line('يمكنك الآن توزيع هذا التبرع على المستفيدين المحتاجين.')
            ->line('شكراً لجهودك في إدارة التبرعات!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'تم استلام تبرع جديد من ' . $this->donation->donor_name,
            'type' => 'success',
            'donation_id' => $this->donation->id,
            'donor_name' => $this->donation->donor_name,
            'donation_type' => $this->donation->type,
            'quantity' => $this->donation->quantity,
            'action_url' => '/admin/donations/' . $this->donation->id,
            'icon' => '🎁'
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

    protected function getStatusArabic($status)
    {
        $statuses = [
            'pending' => 'قيد الانتظار',
            'received' => 'تم الاستلام',
            'distributed' => 'تم التوزيع',
            'expired' => 'منتهي الصلاحية'
        ];

        return $statuses[$status] ?? $status;
    }
}