<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoPersonal extends Model
{
    use HasFactory;

    protected $table = 'datos_personales';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
        'ciudad',
        'edad',
        'carrera',
        'frase',
    ];

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class);
    }
}