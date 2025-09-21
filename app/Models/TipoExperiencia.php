<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoExperiencia extends Model
{
    protected $table = 'tipos_experiencias';

    protected $fillable = ['nombre'];

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class, 'tipo_experiencia_id');
    }
}
