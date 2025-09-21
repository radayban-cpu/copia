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
     * --- INICIO DE LA ACTUALIZACIÓN ---
     * Hacemos la relación explícita y usamos withDefault()
     * para evitar errores si una categoría no existe.
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaPortafolio::class, 'categoria_id')->withDefault([
            'nombre' => 'Sin Categoría'
        ]);
    }
    // --- FIN DE LA ACTUALIZACIÓN ---

    public function datoPersonal()
    {
        return $this->belongsTo(DatoPersonal::class);
    }
}