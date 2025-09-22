<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function index(Cliente $cliente)
    {
        $comentarios = $cliente->comentarios()->latest()->get();
        return view('admin.comentarios.index', compact('cliente', 'comentarios'));
    }

    public function create(Cliente $cliente)
    {
        return view('admin.comentarios.create', compact('cliente'));
    }

    public function store(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'contenido' => 'required|string',
        ]);

        $cliente->comentarios()->create($data);

        // CORRECCIÓN AQUÍ
        return redirect()->route('admin.clientes.comentarios.index', $cliente)->with('success', 'Comentario añadido.');
    }

    public function edit(Comentario $comentario)
    {
        $cliente = $comentario->cliente;
        return view('admin.comentarios.edit', compact('cliente', 'comentario'));
    }

    public function update(Request $request, Comentario $comentario)
    {
        $data = $request->validate([
            'contenido' => 'required|string',
        ]);

        $comentario->update($data);

        // CORRECCIÓN AQUÍ
        return redirect()->route('admin.clientes.comentarios.index', $comentario->cliente)->with('success', 'Comentario actualizado.');
    }

    public function destroy(Comentario $comentario)
    {
        $cliente = $comentario->cliente;
        $comentario->delete();
        
        // CORRECCIÓN AQUÍ
        return redirect()->route('admin.clientes.comentarios.index', $cliente)->with('success', 'Comentario eliminado.');
    }
}