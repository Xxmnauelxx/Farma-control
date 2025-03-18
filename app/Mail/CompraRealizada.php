<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Compra;

class CompraRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $compra;

    /**
     * Create a new message instance.
     */
    public function __construct(Compra $compra)
    {
        $this->compra = $compra;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Compra Realizada')
                    ->view('admin.emails.compra_realizada') // Asegúrate de que la vista exista
                    ->with([
                        'compra' => $this->compra
                    ]);
    }
}
