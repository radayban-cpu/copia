<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoImagen extends Model
{
    // Nombre de la tabla
    protected $table = 'tipos_imagenes';

    protected $fillable = [
        'tipo_imagen',
    ];

 
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'tipo_imagen_id');
    }
}
