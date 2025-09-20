<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',
        'dato_personal_id',
    ];

    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }
}