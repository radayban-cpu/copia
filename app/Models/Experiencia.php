<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    protected $table = 'experiencias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'dato_personal_id',
        'tipo_experiencia_id',
    ];

    // Relación: una experiencia pertenece a una persona
    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }

    // Relación: una experiencia pertenece a un tipo (laboral, profesional, educativo, cultural)
    public function tipo()
    {
        return $this->belongsTo(TipoExperiencia::class, 'tipo_experiencia_id');
    }
}
