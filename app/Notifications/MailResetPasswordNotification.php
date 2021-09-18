<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\ResetPassword;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    protected $pageUrl;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {

        $this->token = $token;

        $this->pageUrl = 'http://localhost:3000/password/reset';
        // we can set whatever we want here, or use .env to set environmental variables
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        return (new MailMessage)
            ->subject(Lang::get('Reset Password'))
            ->line(Lang::get('Need to reset your password?No problem! just click the button below and you will be on your way '))
            ->action(Lang::get('Reset Password'), $this->pageUrl . "/" . $this->token . "/" . $notifiable->getEmailForPasswordReset())
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]));

    }
}
