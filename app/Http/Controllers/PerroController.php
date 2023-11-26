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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:12',
            'url_foto' => 'required|url',
            'descripcion' => 'required|string',
        ]);

        Perro::create([
            'nombre' => $request->nombre,
            'url_foto' => $request->url_foto,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('perros.index')->with('success', 'Perro creado exitosamente.');
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
