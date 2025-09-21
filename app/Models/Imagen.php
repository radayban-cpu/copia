<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes';

    protected $fillable = [
        'ruta',
        'descripcion',
        'dato_personal_id',
        'tipo_imagen_id',
    ];

    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }

    /**
     * --- INICIO DE LA ACTUALIZACIÓN ---
     * Hacemos la relación explícita y usamos withDefault()
     * para evitar errores si un tipo de imagen no existe.
     */
    public function tipo()
    {
        return $this->belongsTo(TipoImagen::class, 'tipo_imagen_id')->withDefault([
            'tipo_imagen' => 'Desconocido'
        ]);
    }
    // --- FIN DE LA ACTUALIZACIÓN ---
}