<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portafolio extends Model
{
    use HasFactory;

    protected $table = 'portafolios';

    protected $fillable = [
        'titulo',
        'descripcion',
        'url_imagen',
        'categoria_id',
        'dato_personal_id',
    ];

    /**
     * Define la relación con CategoriaPortafolio.
     * Usamos withDefault() para que nunca falle si una categoría es eliminada.
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaPortafolio::class, 'categoria_id')->withDefault([
            'nombre' => 'Sin Categoría'
        ]);
    }

    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }
}