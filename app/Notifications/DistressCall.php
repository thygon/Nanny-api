<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DistressCall extends Notification
{
    use Queueable;

    private $call;
    private $user;
    private $location;
    private $firm;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($call,$user, $location,$firm)
    {
        $this->call = $call;
        $this->user = $user;
        $this->location = $location;
        $this->firm = $firm;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user'=>$this->user,
            'call'=>$this->call,
            'location'=>$this->location,
            'firm'=>$this->firm
        ];
    }
}
