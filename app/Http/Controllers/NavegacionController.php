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

        // Imagen de perfil por nombre de tipo ("Perfil")
        $profileImage = $dato
            ? Imagen::where('dato_personal_id', $dato->id)
                ->whereHas('tipo', fn($q) => $q->where('tipo_imagen', 'Perfil'))
                ->first()
            : null;

        // Habilidades
        $habilidades = $dato
            ? Habilidad::where('dato_personal_id', $dato->id)->get()
            : collect();

        // Comentarios + cliente
        $comentarios = $dato
            ? Comentario::with('cliente')->where('dato_personal_id', $dato->id)->get()
            : collect();

        // Contactos → mapear a email/telefono/website
        $contactos = $dato
            ? Contacto::with('tipo')->where('dato_personal_id', $dato->id)->get()
            : collect();

        $contactMap = $contactos->mapWithKeys(function ($c) {
            $clave = Str::slug(optional($c->tipo)->nombre ?? 'otro'); // email, whatsapp, linkedin, ...
            return [$clave => $c->valor];
        });

        // Perfil
        $perfil = $dato
            ? Perfil::where('dato_personal_id', $dato->id)->first()
            : null;

        // Atributos virtuales que el Blade usa
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

        // Portada por nombre ("Portada") para evitar depender del ID 2
        $heroImage = Imagen::whereHas('tipo', fn($q) => $q->where('tipo_imagen', 'Portada'))->first();

        return view('inicio', compact('dato', 'heroImage'));
    }

    /**
     * Página de resumen
     */
    public function resumen()
    {
        $dato = DatoPersonal::first();

        // Traer experiencias
        $experiencias = $dato
            ? Experiencia::where('dato_personal_id', $dato->id)->orderBy('fecha_inicio', 'desc')->get()
            : collect();

        // --------- FIX 1: completar datos del $dato que la vista usa ---------
        if ($dato) {
            $contactos = Contacto::with('tipo')->where('dato_personal_id', $dato->id)->get();
            $contactMap = $contactos->mapWithKeys(function ($c) {
                $clave = Str::slug(optional($c->tipo)->nombre ?? 'otro'); // email, whatsapp, linkedin
                return [$clave => $c->valor];
            });

            $dato->setAttribute('email', $contactMap['email'] ?? null);
            $dato->setAttribute('telefono', $contactMap['whatsapp'] ?? null);
        }

        // --------- FIX 2: normalizar tipo_experiencia_id para que coincida con el Blade ---------
        // El Blade asume: 1 = Profesional, 2 = Educación.
        // En tu DB hay: 'laboral', 'profesional', 'educativo', 'cultural'.
        $tipos = DB::table('tipos_experiencias')->pluck('nombre', 'id'); // [id => nombre]
        $experiencias->each(function ($e) use ($tipos, $dato) {
            $nombreTipo = strtolower($tipos[$e->tipo_experiencia_id] ?? '');

            if (in_array($nombreTipo, ['profesional', 'laboral'])) {
                $e->tipo_experiencia_id = 1; // Profesional
            } elseif (in_array($nombreTipo, ['educativo', 'educacion', 'educación'])) {
                $e->tipo_experiencia_id = 2; // Educación
            }

            // --------- FIX 3: fallback para 'lugar' (no existe en la tabla) ---------
            if (!isset($e->lugar) || $e->lugar === null) {
                // Usamos ciudad de domicilio como ubicación por defecto
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

        return view('servicio', compact('servicios'));
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

        // Completar email/telefono que el Blade muestra
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
