<?php

namespace App\Notifications; // 📌 Ubicación de la clase dentro del proyecto (espacio de nombres)

use Illuminate\Notifications\Notification; // 📌 Importamos la clase base de notificaciones
use Illuminate\Notifications\Messages\MailMessage; // 📌 Importamos la clase que permite crear mensajes de correo

/**
 * 📩 Notificación personalizada para el restablecimiento de contraseña.
 * Esta clase se encarga de enviar un correo al usuario con el enlace para restablecer su contraseña.
 */
class CustomResetPasswordNotification extends Notification
{
    public $token; // 📌 Variable para almacenar el token de restablecimiento

    /**
     * 🔑 Constructor de la notificación.
     * Recibe el token generado por Laravel para la recuperación de la contraseña.
     *
     * @param string $token - Token de recuperación de contraseña
     */
    public function __construct($token)
    {
        $this->token = $token; // 📌 Asignamos el token a la variable de la clase
    }

    /**
     * 📬 Determina los canales por los cuales se enviará la notificación.
     * En este caso, solo se enviará por correo electrónico.
     *
     * @param  mixed  $notifiable - El usuario que recibirá la notificación
     * @return array - Lista de canales de notificación (solo 'mail')
     */
    public function via($notifiable)
    {
        return ['mail']; // 📌 Definimos que la notificación será enviada solo por correo
    }

    /**
     * ✉️ Construye el mensaje de correo electrónico de restablecimiento de contraseña.
     *
     * @param  mixed  $notifiable - El usuario que recibirá la notificación
     * @return \Illuminate\Notifications\Messages\MailMessage - Mensaje del correo
     */
    public function toMail($notifiable)
    {
        // 📌 Generamos la URL que permitirá al usuario restablecer su contraseña
        $url = url(route('password.reset', [
            'token' => $this->token, // 📌 Pasamos el token generado
            'email' => $notifiable->getEmailForPasswordReset(), // 📌 Pasamos el correo del usuario
        ], false));

        // 📌 Retornamos el mensaje de correo con la estructura personalizada
        return (new MailMessage)
            ->subject('Restablecimiento de Contraseña') // 📌 Asunto del correo
            ->view('admin.emails.notificacion', [ // 📌 Usamos una vista personalizada para el email
                'actionUrl' => $url, // 📌 Pasamos la URL de restablecimiento a la vista
                'notifiable' => $notifiable, // 📌 Pasamos la información del usuario a la vista
            ]);
    }
}
