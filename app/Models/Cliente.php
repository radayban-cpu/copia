<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'empresa',
        'email',
        'telefono',
    ];

    /**
     * Define la relación "uno a muchos" con los comentarios.
     * Un cliente puede tener muchos comentarios (testimonios).
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}