<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class MyResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Reimposta la tua Password!')
            ->greeting('Ricevi questa mail dalla applicazione per la gestione delle Guardie Volontarie della Provincia di Rimini')
            ->line('È stata avviata la richiesta per reimpostare la password dell\'utente con username "'.$this->username.'"')
            ->line('Per completare la procedura clicca il link sotto')
            ->action('Reimposta Password', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Se non sei stato tu a richiederlo, semplicemente ignora questa email.')
            ->salutation('Cordiali saluti.');
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
            //
        ];
    }
}
