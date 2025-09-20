<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabilidad extends Model
{
    // Nombre correcto de la tabla
    protected $table = 'tipos_habilidades';

    // Columnas que se pueden asignar en masa
    protected $fillable = [
        'nombre_habilidad',
    ];

    // Relación: un TipoHabilidad tiene muchas Habilidades
    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'tipo_habilidad_id');
    }
}
