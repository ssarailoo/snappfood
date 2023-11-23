<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class OrderStatusSMS extends KavenegarBaseNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct( public $status)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */


    /**
     * Get the mail representation of the notification.
     */


    public function toKavenegar($notifiable)
    {
        return (new KavenegarMessage("Your order status has changed to {$this->status}." . "\n" . "لغو۱۱"))
            ->from('1000000500555');

//            ->content('Factor'. url(route('factor',$this->cart->hashed_id)));
// "'\n" . "Factor=>" . " " . url(route('factor', $this->cart->hashed_id) .
    }


}


