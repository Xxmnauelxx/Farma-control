<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    /**
     * Constructor
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Determina los canales de notificación.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Canal de notificación: correo electrónico
    }

    /**
     * Construye el mensaje de correo electrónico de restablecimiento de contraseña.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Generamos la URL con el token para restablecer la contraseña
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Construir y devolver el mensaje de correo
        return (new MailMessage)
            ->subject('Restablecimiento de Contraseña') // Asunto del correo
            ->view('admin.emails.notificacion', [
                'actionUrl' => $url, // URL para el restablecimiento
                'notifiable' => $notifiable, // Información del usuario
            ]);
    }
}

