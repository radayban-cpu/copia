<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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

        // Perfil: por ID de tipo (1)
        $imagenPerfil = $this->getImagenUrlPorTipoId(1); // tipo_imagen_id = 1
        // Muro: por nombre de tipo ('muro')
        $imagenMuro   = $this->getImagenUrlPorTipo('muro');

        return view('inicio', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
            'imagenPerfil' => $imagenPerfil,
            'imagenMuro'   => $imagenMuro,
        ]);
    }

    /** Página "Acerca de" */
    public function acerca()
    {
        $datoPersonal = DatoPersonal::first();

        // PERFIL por ID de tipo (1) con fallback a última imagen válida; si no, fallback del tema
        $imagenPerfil = $this->getImagenUrlPorTipoId(1, true) ?? asset('assets/img/profile-img.jpg');
        // MURO por nombre
        $imagenMuro   = $this->getImagenUrlPorTipo('muro');

        // Vista: resources/views/acerca.blade.php
        return view('acerca-de', compact('datoPersonal', 'imagenPerfil', 'imagenMuro'));
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

    /** Página pública de Portafolio */
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

    /** Detalle de un proyecto del portafolio */
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

    /** Página de resumen/CV */
    public function resumen()
    {
        $datoPersonal = DatoPersonal::first();
        $experiencias = Experiencia::with('tipo')
            ->orderByRaw('COALESCE(fecha_fin, fecha_inicio) DESC')
            ->get();
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

    /** Devuelve el nombre de la columna de texto en tipos_imagenes */
    private function tipoImagenNombreCol(): ?string
    {
        if (Schema::hasColumn('tipos_imagenes', 'tipo_imagen')) {
            return 'tipo_imagen';
        }
        foreach (['nombre', 'tipo', 'name', 'titulo', 'slug'] as $col) {
            if (Schema::hasColumn('tipos_imagenes', $col)) return $col;
        }
        return null;
    }

    /**
     * Busca la última imagen por **ID** de tipo y devuelve la URL pública.
     * Si $fallbackLatest = true y no encuentra del tipo, intenta la última imagen válida en storage.
     */
    private function getImagenUrlPorTipoId(int $tipoId, bool $fallbackLatest = false): ?string
    {
        $img = Imagen::query()
            ->where('tipo_imagen_id', $tipoId)
            ->when(Schema::hasColumn('imagenes', 'created_at'),
                fn ($q) => $q->orderByDesc('created_at'),
                fn ($q) => $q->orderByDesc('id')
            )
            ->first();

        $url = $this->toPublicUrl($img->ruta ?? null);
        if ($url || !$fallbackLatest) {
            return $url;
        }

        // Fallback: última imagen que exista realmente en el disco 'public'
        return $this->getUltimaImagenValidaUrl();
    }

    /**
     * Busca la última imagen por **NOMBRE** de tipo ('muro', etc.) y devuelve la URL pública.
     * Usa TRIM + LOWER para tolerar espacios/caso en la BD.
     */
    private function getImagenUrlPorTipo(string $nombreTipo): ?string
    {
        $col = $this->tipoImagenNombreCol();
        if (!$col) return null;

        $buscado = Str::lower(trim($nombreTipo));

        $img = Imagen::query()
            ->select('imagenes.ruta')
            ->join('tipos_imagenes', 'tipos_imagenes.id', '=', 'imagenes.tipo_imagen_id')
            ->whereRaw("LOWER(TRIM(tipos_imagenes.$col)) = ?", [$buscado])
            ->when(Schema::hasColumn('imagenes', 'created_at'),
                fn ($q) => $q->orderByDesc('imagenes.created_at'),
                fn ($q) => $q->orderByDesc('imagenes.id')
            )
            ->first();

        return $this->toPublicUrl($img->ruta ?? null);
    }

    /** Devuelve la URL pública de la última imagen que exista realmente en storage/public */
    private function getUltimaImagenValidaUrl(): ?string
    {
        $ultima = Imagen::orderByDesc(Schema::hasColumn('imagenes','created_at') ? 'created_at' : 'id')
            ->get()
            ->first(function ($i) {
                if (!$i->ruta) return false;
                $r = ltrim($i->ruta, '/');
                if (Str::startsWith($r, 'public/')) $r = substr($r, 7);
                if (Str::startsWith('/'.$r, '/storage/')) $r = ltrim(substr('/'.$r, 9), '/');
                return Storage::disk('public')->exists($r);
            });

        return $ultima ? $this->toPublicUrl($ultima->ruta) : null;
    }

    /**
     * Normaliza 'ruta' y devuelve una URL pública correcta SOLO si el archivo existe.
     * Admite:
     * - public/imagenes/archivo.jpg  → /storage/imagenes/archivo.jpg
     * - storage/imagenes/archivo.jpg → /storage/imagenes/archivo.jpg
     * - /storage/imagenes/archivo.jpg → /storage/imagenes/archivo.jpg
     * - images/... | assets/... | img/... (carpeta pública del theme)
     */
    private function toPublicUrl(?string $ruta): ?string
    {
        if (!$ruta) return null;

        $ruta = trim($ruta);
        $ruta = ltrim($ruta, '/');

        // 1) URLs absolutas o data URI
        if (Str::startsWith($ruta, ['http://','https://','data:'])) {
            return $ruta;
        }

        // 2) Paths del theme en /public
        if (Str::startsWith($ruta, ['images/','assets/','img/'])) {
            return file_exists(public_path($ruta)) ? asset($ruta) : null;
        }

        // 3) /storage/... (o storage/...)
        if (Str::startsWith('/'.$ruta, '/storage/')) {
            $rel = ltrim(substr('/'.$ruta, 9), '/'); // después de /storage/
            return Storage::disk('public')->exists($rel) ? asset('storage/'.$rel) : null;
        }

        // 4) public/imagenes/...
        if (Str::startsWith($ruta, 'public/')) {
            $rel = substr($ruta, 7); // quitar 'public/'
            return Storage::disk('public')->exists($rel) ? asset('storage/'.$rel) : null;
        }

        // 5) Ruta cruda típica: imagenes/archivo.jpg en el disco 'public'
        return Storage::disk('public')->exists($ruta) ? asset('storage/'.$ruta) : null;
    }
}
