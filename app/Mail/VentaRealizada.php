<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Venta;

class VentaRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;

    /**
     * Create a new message instance.
     */
    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nueva Venta Registrada')
                    ->view('admin.emails.venta_realizada')
                    ->with([
                        'venta' => $this->venta
                    ]);
    }
}
