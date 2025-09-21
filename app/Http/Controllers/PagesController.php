<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

use App\Models\Portafolio;
use App\Models\CategoriaPortafolio;
use App\Models\DatoPersonal;
use App\Models\Experiencia;
use App\Models\TipoExperiencia;
use App\Models\Imagen;

class PagesController extends Controller
{
    /** Página de inicio */
    public function inicio()
    {
        $datoPersonal = DatoPersonal::first();

        // URLs normalizadas desde BD por tipo ('perfil' y 'muro')
        $imagenPerfil = $this->getImagenUrlPorTipo('perfil');
        $imagenMuro   = $this->getImagenUrlPorTipo('muro');

        return view('inicio', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,   // alias usado en la vista
            'imagenPerfil' => $imagenPerfil,
            'imagenMuro'   => $imagenMuro,
        ]);
    }

    /** Página "Acerca de" */
    public function acerca()
    {
        $datoPersonal = DatoPersonal::first();

        $imagenPerfil = $this->getImagenUrlPorTipo('perfil');
        $imagenMuro   = $this->getImagenUrlPorTipo('muro');

        return view('acerca-de', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
            'imagenPerfil' => $imagenPerfil,
            'imagenMuro'   => $imagenMuro,
        ]);
    }

    /** Página de contactos */
    public function contactos()
    {
        $datoPersonal = DatoPersonal::first();

        return view('contactos', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
        ]);
    }

    /**
     * Página pública de Portafolio.
     * - Pasa $categorias y $portafolios (con relación 'categoria')
     * - Soporta filtro por ?categoria={slug}
     */
    public function portafolio(Request $request)
    {
        $categorias = CategoriaPortafolio::orderBy('nombre')->get();

        $slug = $request->query('categoria');
        $categoriaSeleccionada = null;
        $categoriaId = null;

        if ($slug) {
            $categoriaSeleccionada = $categorias->first(function ($c) use ($slug) {
                return Str::slug($c->nombre) === $slug;
            });
            if ($categoriaSeleccionada) {
                $categoriaId = $categoriaSeleccionada->id;
            }
        }

        $portafolios = Portafolio::with('categoria')
            ->when($categoriaId, fn ($q) => $q->where('categoria_id', $categoriaId))
            ->latest()
            ->get();

        $datoPersonal = DatoPersonal::first();

        return view('portafolio', [
            'categorias'            => $categorias,
            'portafolios'           => $portafolios,
            'datoPersonal'          => $datoPersonal,
            'categoriaSeleccionada' => $categoriaSeleccionada,
            'datos'                 => $datoPersonal,
        ]);
    }

    /**
     * Detalle de un proyecto del portafolio.
     * Recomendado: usar slug en la ruta: /portafolio/{slug}
     */
    public function portafolioDetalle(string $slug = null)
    {
        $query = Portafolio::with('categoria');

        $item = $slug
            ? $query->where('slug', $slug)->first()
            : $query->latest()->first();

        abort_unless($item, 404);

        $datoPersonal = DatoPersonal::first();

        return view('portafolio-detalle', [
            'item'         => $item,
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
        ]);
    }

    /** Página de resumen/CV — lee experiencias desde BD */
    public function resumen()
    {
        $datoPersonal = DatoPersonal::first();

        // Experiencias (con tipo), ordenadas por fin o inicio más reciente
        $experiencias = Experiencia::with('tipo')
            ->orderByRaw('COALESCE(fecha_fin, fecha_inicio) DESC')
            ->get();

        // Si la vista muestra tabs/filtros por tipo
        $tipos = TipoExperiencia::orderBy('nombre')->get();

        return view('resumen', [
            'datoPersonal' => $datoPersonal,
            'experiencias' => $experiencias,
            'tipos'        => $tipos,
            'datos'        => $datoPersonal,
        ]);
    }

    /** Página de servicios */
    public function servicios()
    {
        $datoPersonal = DatoPersonal::first();

        return view('servicios', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
        ]);
    }

    /* ============================
     * Helpers privados
     * ============================
     */

    /**
     * Devuelve el nombre de la columna de texto en tipos_imagenes
     * (por ejemplo: nombre, tipo, name, titulo, slug). Si no encuentra, retorna null.
     */
    private function tipoImagenNombreCol(): ?string
    {
        foreach (['nombre', 'tipo', 'name', 'titulo', 'slug'] as $col) {
            if (Schema::hasColumn('tipos_imagenes', $col)) {
                return $col;
            }
        }
        return null;
    }

    /**
     * Busca la última imagen por tipo ("perfil" | "muro") y devuelve la URL pública.
     * Evita ambigüedad en ORDER BY calificando la columna.
     */
    private function getImagenUrlPorTipo(string $nombreTipo): ?string
    {
        $col = $this->tipoImagenNombreCol();

        $query = Imagen::query()
            ->select('imagenes.ruta')
            ->join('tipos_imagenes', 'tipos_imagenes.id', '=', 'imagenes.tipo_imagen_id');

        if ($col) {
            $query->whereRaw("LOWER(tipos_imagenes.$col) = ?", [Str::lower($nombreTipo)]);
        }

        // Evitar "ambiguous column name: created_at" al usar JOIN
        if (Schema::hasColumn('imagenes', 'created_at')) {
            $query->orderByDesc('imagenes.created_at');
        } else {
            $query->orderByDesc('imagenes.id');
        }

        $img = $query->first();

        if (!$img || empty($img->ruta)) {
            return null;
        }

        $ruta = (string) $img->ruta;

        // Si ya es URL absoluta o ruta absoluta, devolver tal cual.
        if (Str::startsWith($ruta, ['http://', 'https://', '/'])) {
            return $ruta;
        }

        // Si es una ruta relativa (storage público)
        return asset('storage/' . ltrim($ruta, '/'));
    }
}
