<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoPersonal extends Model
{
    protected $table = 'datos_personales';

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class);
    }
}