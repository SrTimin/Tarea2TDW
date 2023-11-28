<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perro;
use Illuminate\Support\Facades\DB;



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
        if (!$perro) {
            return response()->json(['error' => 'Perro no encontrado'], 404);
        }
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
        if (!$perro) {
            return response()->json(['error' => 'Perro no encontrado'], 404);
        }
        $perro->update($request->all());
        return response()->json($perro);
    }

    public function destroy($id)
    {
        $perro = Perro::find($id);
        if (!$perro) {
            return response()->json(['error' => 'Perro no encontrado'], 404);
        }
        $perro->delete();
        return response()->json('Perro eliminado correctamente');
    }

    public function randomPerro()
    {
        $perro = Perro::select('id', 'nombre')->inRandomOrder()->first();
        if (!$perro) {
            return response()->json(['message' => 'No hay perros en la base de datos.'], 404);
        }
        return response()->json($perro);
    }

    public function getCandidatos($idPerroInteresado)
    {
        $perro = Perro::find($idPerroInteresado);
        if (!$perro) {
            return response()->json(['error' => 'Perro no encontrado'], 404);
        }
        $candidatos = Perro::where('id', '!=', $idPerroInteresado)->get(['id', 'nombre']);
        return response()->json($candidatos);
    }

    

}
