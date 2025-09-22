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
use App\Models\Habilidad;
use App\Models\Comentario;
use App\Models\Servicio; // <-- NUEVO: Importar el modelo Servicio

class PagesController extends Controller
{
    /** Página de inicio */
    public function inicio()
    {
        $datoPersonal = DatoPersonal::first();
        $imagenPerfil = $this->getImagenUrlPorTipoId(1);
        $imagenMuro   = $this->getImagenUrlPorTipo('muro');

        return view('inicio', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
            'imagenPerfil' => $imagenPerfil,
            'imagenMuro'   => $imagenMuro,
        ]);
    }

public function acerca()
{
    // Dato personal (como ya lo tenías)
    $datoPersonal = DatoPersonal::with(['habilidades.tipo'])->first();

    // Foto (tal cual te funciona hoy)
    $avatar = Imagen::where('tipo_imagen_id', 1)->latest()->first();
    $fotoUrl = null;
    if ($avatar && $avatar->ruta) {
        $ruta = ltrim($avatar->ruta, '/');
        $ruta = preg_replace('~^(storage/|public/)~', '', $ruta);
        if (Storage::disk('public')->exists($ruta)) {
            $fotoUrl = Storage::url($ruta);
        }
    }
    if (!$fotoUrl) {
        $fotoUrl = asset('images/avatar.png');
    }

    // === HABILIDADES ===
    // Si tu modelo usa campo "porcentaje" en vez de "nivel", el Blade actual lo convierto aquí:
    $habilidades = ($datoPersonal?->habilidades ?? collect())->map(function ($h) {
        $nivel = $h->nivel ?? $h->porcentaje ?? 0;
        $h->nivel = (int) $nivel;
        return $h;
    });

// === TESTIMONIOS con avatar ===
$testimonios = Comentario::with('cliente')
    ->latest()
    ->take(6)
    ->get()
    ->map(function ($c) {
        // Intentamos obtener algún campo de la tabla clientes que apunte al archivo:
        //   - 'ruta' (ej: 'imagenes/archivo.png')
        //   - 'foto' o 'avatar' (por si lo guardaste así)
        $rawPath = $c->cliente->ruta
            ?? $c->cliente->foto
            ?? $c->cliente->avatar
            ?? null;

        $avatarUrl = null;
        if ($rawPath) {
            // normalizar y verificar en el disco 'public'
            $p = ltrim($rawPath, '/');
            $p = preg_replace('~^(storage/|public/)~', '', $p);
            if (Storage::disk('public')->exists($p)) {
                $avatarUrl = Storage::url($p); // /storage/...
            }
        }

        // placeholder si no hay imagen válida
        if (!$avatarUrl) {
            $avatarUrl = asset('images/user-placeholder.png'); // poné un PNG en public/images/
        }

        return (object)[
            'mensaje'    => $c->contenido ?? $c->mensaje ?? '',
            'autor'      => $c->cliente->nombre ?? 'Anónimo',
            'cargo'      => $c->cliente->cargo ?? null,
            'avatar_url' => $avatarUrl,
        ];
    });

    return view('acerca-de', compact('datoPersonal', 'fotoUrl', 'habilidades', 'testimonios'));
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
        
        // --- ¡AQUÍ ESTÁ LA ACTUALIZACIÓN! ---
        $servicios = Servicio::where('dato_personal_id', optional($datoPersonal)->id)->latest()->get();

        return view('servicios', [
            'datoPersonal' => $datoPersonal,
            'datos'        => $datoPersonal,
            'servicios'    => $servicios, // Pasamos los servicios a la vista
        ]);
    }

    /* ============================
     * Helpers privados
     * ============================
     */

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

        return $this->getUltimaImagenValidaUrl();
    }

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

    private function toPublicUrl(?string $ruta): ?string
    {
        if (!$ruta) return null;

        $ruta = trim($ruta);
        $ruta = ltrim($ruta, '/');

        if (Str::startsWith($ruta, ['http://','https://','data:'])) {
            return $ruta;
        }

        if (Str::startsWith($ruta, ['images/','assets/','img/'])) {
            return file_exists(public_path($ruta)) ? asset($ruta) : null;
        }

        if (Str::startsWith('/'.$ruta, '/storage/')) {
            $rel = ltrim(substr('/'.$ruta, 9), '/');
            return Storage::disk('public')->exists($rel) ? asset('storage/'.$rel) : null;
        }

        if (Str::startsWith($ruta, 'public/')) {
            $rel = substr($ruta, 7);
            return Storage::disk('public')->exists($rel) ? asset('storage/'.$rel) : null;
        }

        return Storage::disk('public')->exists($ruta) ? asset('storage/'.$ruta) : null;
    }
}