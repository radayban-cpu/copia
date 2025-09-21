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

    /** ✅ NUEVO: castear fechas para usarlas como Carbon */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    // Relación: una experiencia pertenece a una persona
    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class, 'dato_personal_id');
    }

    // Relación: una experiencia pertenece a un tipo (laboral, profesional, educativo, cultural)
    public function tipo()
    {
        return $this->belongsTo(TipoExperiencia::class, 'tipo_experiencia_id');
    }

    /** ✅ NUEVO (opcional): orden por fecha fin o inicio descendente */
    public function scopeRecientes($q)
    {
        return $q->orderByRaw('COALESCE(fecha_fin, fecha_inicio) DESC');
    }

    /** ✅ NUEVO (opcional): accesor para mostrar el período ya formateado */
    public function getPeriodoAttribute(): string
    {
        $ini = $this->fecha_inicio ? $this->fecha_inicio->format('M Y') : null;
        $fin = $this->fecha_fin ? $this->fecha_fin->format('M Y') : 'Actual';
        return $ini ? ($ini . ' - ' . $fin) : ($fin ?? '');
    }
}
