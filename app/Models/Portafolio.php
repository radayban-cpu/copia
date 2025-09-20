<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portafolio extends Model
{
    protected $table = 'portafolios';
    public $timestamps = false; 

    public function categoria()
    {
        return $this->belongsTo(CategoriaPortafolio::class, 'categoria_id');
    }

    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }
}