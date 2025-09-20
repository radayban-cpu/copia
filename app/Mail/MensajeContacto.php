<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MensajeContacto extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function build()
    {
        return $this->from($this->datos['email'], $this->datos['name'])
                    ->subject($this->datos['subject'])
                    ->view('emails.contacto'); // Usaremos una vista para el cuerpo del email
    }
}