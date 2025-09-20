<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    protected $table = 'habilidades';

    protected $fillable = [
        'nombre',
        'nivel',
        'dato_personal_id',
        'tipo_habilidad_id',
    ];

    // Relación: una habilidad pertenece a una persona
    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }

    // Relación: una habilidad pertenece a un tipo (técnica, blanda, gestión)
    public function tipo()
    {
        return $this->belongsTo(TipoHabilidad::class, 'tipo_habilidad_id');
    }
}
