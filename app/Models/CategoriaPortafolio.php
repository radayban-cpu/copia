<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaPortafolio extends Model
{
    protected $table = 'categorias_portafolio';
    public $timestamps = false;

    public function proyectos()
    {
        return $this->hasMany(Portafolio::class, 'categoria_id');
    }
}