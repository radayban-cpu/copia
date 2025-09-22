<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoPersonal extends Model
{
    use HasFactory;

    protected $table = 'datos_personales';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'descripcion',
        'fecha_nacimiento',
        'ciudad_domicilio',
        'carrera',
        'frase',
        'edad',
    ];

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class);
    }

    /**
     * NUEVA RELACIÓN: Un perfil personal tiene muchos servicios.
     */
    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }
}