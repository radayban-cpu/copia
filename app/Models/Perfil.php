<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
        'dato_personal_id',
    ];

    // Relación: un perfil pertenece a una persona
    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }
}
