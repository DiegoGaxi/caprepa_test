<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        // Método para mostrar el formulario de creación de cliente
        return view('clients.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clients')
            ],
        ], [
            'name.unique' => 'El nombre del cliente ya está en uso.',
        ]);

        // Crear un nuevo cliente en la base de datos
        Client::create([
            'name' => $request->name,  // Asegúrate de que 'name' coincida con el campo en tu tabla 'clients'
        ]);

        // Redireccionar a la vista de clientes
        return redirect()->route('clients.index')
                         ->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Client $cliente)
    {
        return view('clients.show', compact('cliente'));
    }

    public function edit(Client $cliente)
    {
        return view('clients.edit', compact('cliente'));
    }

    public function update(Request $request, Client $cliente)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clients')->ignore($cliente->id),
            ],
        ], [
            'name.unique' => 'El nombre del cliente ya está en uso.',
        ]);
    
        $cliente->name = $request->name;
        $cliente->save();
    
        return redirect()->route('clients.index')
                         ->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Client $cliente)
    {
        $cliente->delete();

        return redirect()->route('clients.index')
                         ->with('success', 'Cliente eliminado exitosamente.');
    }
}
