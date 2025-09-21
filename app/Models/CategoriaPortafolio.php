<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPortafolio extends Model
{
    use HasFactory;

    protected $table = 'categorias_portafolio';

    protected $fillable = ['nombre'];

    /**
     * Define la relación inversa: una categoría tiene muchos portafolios.
     */
    public function portafolios()
    {
        return $this->hasMany(Portafolio::class, 'categoria_id');
    }
}