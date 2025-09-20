<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // <-- Añadimos esto
use Illuminate\Support\Facades\Mail;
use App\Mail\MensajeContacto;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        // Escribimos en el log que el método se inició
        Log::info('Se ha intentado enviar un correo desde el formulario de contacto.');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::to('tucorreo@dominio.com')->send(new MensajeContacto($request->all()));
            
            // Si el correo se envía, lo escribimos en el log
            Log::info('¡Correo enviado a Mailtrap exitosamente!');

        } catch (\Exception $e) {
            // Si hay un error, lo capturamos y lo escribimos en el log
            Log::error('Error al enviar el correo: ' . $e->getMessage());

            // Opcional: Redirigir con un mensaje de error
            return back()->with('error', 'No se pudo enviar tu mensaje. Intenta de nuevo más tarde.');
        }

        return back()->with('success', '¡Tu mensaje fue enviado, gracias!');
    }
}