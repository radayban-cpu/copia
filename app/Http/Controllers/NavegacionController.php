<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPortafolio;
use App\Models\Comentario;
use App\Models\DatoPersonal;
use App\Models\Experiencia;
use App\Models\Habilidad;
use App\Models\Imagen;
use App\Models\Portafolio;
use App\Models\Servicio;
use App\Models\Perfil;
use App\Models\Contacto;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NavegacionController extends Controller
{
    /**
     * Página "Acerca de"
     */
    public function acercaDe()
    {
        $dato = DatoPersonal::first();

        $profileImage = $dato
            ? Imagen::where('dato_personal_id', $dato->id)
                ->whereHas('tipo', function ($query) {
                    $query->whereRaw('LOWER(tipo_imagen) = ?', ['perfil']);
                })
                ->first()
            : null;

        $habilidades = $dato
            ? Habilidad::where('dato_personal_id', $dato->id)->get()
            : collect();
        $comentarios = $dato
            ? Comentario::with('cliente')->where('dato_personal_id', $dato->id)->get()
            : collect();
        $contactos = $dato
            ? Contacto::with('tipo')->where('dato_personal_id', $dato->id)->get()
            : collect();

        $contactMap = $contactos->mapWithKeys(function ($c) {
            $clave = Str::slug(optional($c->tipo)->nombre ?? 'otro');
            return [$clave => $c->valor];
        });

        $perfil = $dato ? Perfil::where('dato_personal_id', $dato->id)->first() : null;

        if ($dato) {
            $edad = null;
            if (!empty($dato->fecha_nacimiento)) {
                try { $edad = Carbon::parse($dato->fecha_nacimiento)->age; } catch (\Throwable $e) {}
            }
            $dato->setAttribute('edad', $edad);
            $dato->setAttribute('email', $contactMap['email'] ?? null);
            $dato->setAttribute('telefono', $contactMap['whatsapp'] ?? null);
            $dato->setAttribute('website', $contactMap['linkedin'] ?? null);
            $dato->setAttribute('profesion', optional($perfil)->titulo);
            $dato->setAttribute('grado', optional($perfil)->subtitulo);
            $dato->setAttribute('descripcion_larga', optional($perfil)->descripcion ?: $dato->descripcion);
            $dato->setAttribute('freelance', $dato->freelance ?? 'Disponible');
        }

        return view('acerca-de', compact('dato', 'profileImage', 'habilidades', 'comentarios'));
    }

    /**
     * Página de inicio
     */
    public function inicio()
    {
        $dato = DatoPersonal::first();

        $imagenMuro = Imagen::whereHas('tipo', function ($query) {
             $query->whereRaw('LOWER(tipo_imagen) = ?', ['muro']);
        })->latest()->first();

        $imagenPerfil = Imagen::whereHas('tipo', function ($query) {
            $query->whereRaw('LOWER(tipo_imagen) = ?', ['perfil']);
        })->latest()->first();

        return view('inicio', compact('dato', 'imagenMuro', 'imagenPerfil'));
    }

    /**
     * Página de resumen
     */
    public function resumen()
    {
        $dato = DatoPersonal::first();
        $experiencias = $dato
            ? Experiencia::where('dato_personal_id', $dato->id)->orderBy('fecha_inicio', 'desc')->get()
            : collect();

        if ($dato) {
            $contactos = Contacto::with('tipo')->where('dato_personal_id', $dato->id)->get();
            $contactMap = $contactos->mapWithKeys(function ($c) {
                $clave = Str::slug(optional($c->tipo)->nombre ?? 'otro');
                return [$clave => $c->valor];
            });
            $dato->setAttribute('email', $contactMap['email'] ?? null);
            $dato->setAttribute('telefono', $contactMap['whatsapp'] ?? null);
        }

        $tipos = DB::table('tipos_experiencias')->pluck('nombre', 'id');
        $experiencias->each(function ($e) use ($tipos, $dato) {
            $nombreTipo = strtolower($tipos[$e->tipo_experiencia_id] ?? '');
            if (in_array($nombreTipo, ['profesional', 'laboral'])) {
                $e->tipo_experiencia_id = 1;
            } elseif (in_array($nombreTipo, ['educativo', 'educacion', 'educación'])) {
                $e->tipo_experiencia_id = 2;
            }
            if (!isset($e->lugar) || $e->lugar === null) {
                $e->setAttribute('lugar', $dato?->ciudad_domicilio ?? '');
            }
        });

        return view('resumen', compact('dato', 'experiencias'));
    }

    /**
     * Página de servicios
     */
    public function servicio()
    {
        $dato = DatoPersonal::first();
        $servicios = $dato
            ? Servicio::where('dato_personal_id', $dato->id)->get()
            : collect();

        // El nombre de la vista debe ser 'servicios', no 'servicio'
        return view('servicios', compact('servicios'));
    }

    /**
     * Página de portafolio
     */
    public function portafolio()
    {
        $dato = DatoPersonal::first();
        $proyectos = $dato
            ? Portafolio::where('dato_personal_id', $dato->id)->get()
            : collect();
        $categorias = CategoriaPortafolio::all();
        return view('portafolio', compact('proyectos', 'categorias'));
    }

    /**
     * Página de contacto
     */
    public function contacto()
    {
        $dato = DatoPersonal::first();
        if ($dato) {
            $contactos = Contacto::with('tipo')->where('dato_personal_id', $dato->id)->get();
            $contactMap = $contactos->mapWithKeys(function ($c) {
                $clave = Str::slug(optional($c->tipo)->nombre ?? 'otro');
                return [$clave => $c->valor];
            });
            $dato->setAttribute('email', $contactMap['email'] ?? null);
            $dato->setAttribute('telefono', $contactMap['whatsapp'] ?? null);
        }
        return view('contacto', compact('dato'));
    }
}

