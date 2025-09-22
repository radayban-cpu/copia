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

    public function datoPersonal()
    {
        return $this->belongsTo(\App\Models\DatoPersonal::class, 'dato_personal_id');
    }

    // 👇 ESTA relación debe existir con ESTE nombre
    public function tipoContacto()
    {
        return $this->belongsTo(\App\Models\TipoContacto::class, 'tipo_contacto_id');
    }

    // (Opcional) alias por compatibilidad si en algún lado quedó "tipo"
    public function tipo()
    {
        return $this->tipoContacto();
    }
}
