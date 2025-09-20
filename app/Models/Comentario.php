<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $fillable = [
        'contenido',
        'cliente_id',
    ];

    // Relación: un comentario pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
