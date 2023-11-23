<?php

namespace App\Notifications\Discount;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class DiscountSMSNotification extends KavenegarBaseNotification implements  ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $discount)
    {
        //
    }

    public function toKavenegar($notifiable)
    {
        return (new KavenegarMessage("Use this code  \"{$this->discount->code}\"  for {$this->discount->percent} percent off!!" . "\n" . "لغو۱۱"))
            ->from('1000000500555');
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

}
