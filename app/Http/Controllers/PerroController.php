<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perro;


class PerroController extends Controller
{
    public function index()
    {
        $perros = Perro::all();
        return response()->json($perros);
    }

    public function show($id)
    {
        $perro = Perro::find($id);
        return response()->json($perro);
    }

    public function create()
    {
        return view('perros.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:12',
            'foto_url' => 'required|url',
            'descripcion' => 'required|string',
        ], [
            'nombre.required' => 'El nombre es requerido',
            'foto_url.required' => 'La URL de la foto es requerida',
            'descripcion.required' => 'La descripción es requerida',
        ]);
        
    
        $perro = Perro::create([
            'nombre' => $request->nombre,
            'foto_url' => $request->foto_url,
            'descripcion' => $request->descripcion,
        ]);
    
        return response()->json(['perro' => $perro, 'message' => 'Perro creado exitosamente.'], 201);
    }
    
    
    public function update(Request $request, $id)
    {
        $perro = Perro::find($id);
        $perro->update($request->all());
        return response()->json($perro);
    }

    public function destroy($id)
    {
        $perro = Perro::find($id);
        $perro->delete();
        return response()->json('Perro eliminado correctamente');
    }
}
