<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portafolio extends Model
{
    use HasFactory;

    protected $table = 'portafolios';
    public $timestamps = false; 

    protected $fillable = [
        'titulo',
        'descripcion',
        'cliente',
        'url_proyecto',
        'url_imagen',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaPortafolio::class, 'categoria_id');
    }

    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }
}