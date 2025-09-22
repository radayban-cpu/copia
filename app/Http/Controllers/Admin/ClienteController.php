<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::withCount('comentarios')->latest()->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:255',
            'empresa'   => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'telefono'  => 'nullable|string|max:255',
        ]);

        Cliente::create($data);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado.');
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:255',
            'empresa'   => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'telefono'  => 'nullable|string|max:255',
        ]);

        $cliente->update($data);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado.');
    }
}