<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContacto extends Model
{
    protected $table = 'tipos_contactos';

    /**
     * Relación: un tipo de contacto puede tener muchos contactos.
     */
    public function contactos()
    {
        return $this->hasMany(\App\Models\Contacto::class, 'tipo_contacto_id');
    }
}
