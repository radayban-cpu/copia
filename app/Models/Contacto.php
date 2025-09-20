<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'contactos';

    protected $fillable = [
        'valor',
        'dato_personal_id',
        'tipo_contacto_id',
    ];

    // Relación: un contacto pertenece a una persona
    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }

    // Relación: un contacto pertenece a un tipo (Email, WhatsApp, etc.)
    public function tipo()
    {
        return $this->belongsTo(TipoContacto::class, 'tipo_contacto_id');
    }
}
