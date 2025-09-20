<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'ruta',
        'descripcion',
        'dato_personal_id',
        'tipo_imagen_id',
    ];

    // Relación: una imagen pertenece a una persona
    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }

    // Relación: una imagen pertenece a un tipo (perfil, portada, etc.)
    public function tipo()
    {
        return $this->belongsTo(TipoImagen::class, 'tipo_imagen_id');
    }
}
