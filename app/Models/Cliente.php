<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'empresa',
        'email',
        'telefono',
    ];

    // Relación: un cliente puede tener muchos comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'cliente_id');
    }
}
