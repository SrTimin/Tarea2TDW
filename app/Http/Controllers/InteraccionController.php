<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaccion;
use App\Models\Perro;


class InteraccionController extends Controller
{
    public function index()
    {
        $interacciones = Interaccion::all();
        return response()->json($interacciones);
    }

    public function showPreferencias($idPerroInteresado)
    {
        $perroInteresado = Perro::find($idPerroInteresado);
        if (!$perroInteresado) {
            return response()->json(['error' => 'Perro no encontrado'], 404);
        }
    
        $aceptados = Interaccion::where('perro_interesado_id', $idPerroInteresado)
                                ->where('preferencia', 'A')
                                ->get();
        $rechazados = Interaccion::where('perro_interesado_id', $idPerroInteresado)
                                 ->where('preferencia', 'R')
                                 ->get();
    
        $preferencias = "El perro " . $perroInteresado->nombre . " (id: " . $idPerroInteresado . ") le dió aceptar a: ";
        foreach ($aceptados as $aceptado) {
            $perroCandidato = Perro::find($aceptado->perro_candidato_id);
            $preferencias .= $perroCandidato->nombre . " (id:" . $aceptado->perro_candidato_id . "), ";
        }
        $preferencias .= "Por otro lado, rechazó a: ";
        foreach ($rechazados as $rechazado) {
            $perroCandidato = Perro::find($rechazado->perro_candidato_id);
            $preferencias .= $perroCandidato->nombre . " (id:" . $rechazado->perro_candidato_id . "), ";
        }
    
        return response()->json(['preferencias' => $preferencias]);
    }

    public function show($id)
    {
        $interaccion = Interaccion::find($id);
        if (!$interaccion) {
            return response()->json(['error' => 'Interacción no encontrada'], 404);
        }
        return response()->json($interaccion);
    }

    
    
    

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'perro_interesado_id' => 'required|exists:perros,id',
            'preferencia' => 'required|in:A,R',
        ]);
    
        // Lógica para obtener el perro random
        $response = app('App\Http\Controllers\PerroController')->randomPerro();
        $perroRandom = json_decode($response->getContent());
    
        // Verificar si ya existe una interacción con el mismo perro_interesado_id y perro_candidato_id
        $existeInteraccion = Interaccion::where('perro_interesado_id', $request->perro_interesado_id)
            ->where('perro_candidato_id', $perroRandom->id)
            ->exists();
    
        if ($existeInteraccion) {
            return response()->json(['message' => 'Ya existe una interacción con el mismo perro interesado y perro candidato.'], 400);
        }
    
        // Lógica para obtener los perros candidatos con excepción del perro interesado
        $responseCandidatos = app('App\Http\Controllers\PerroController')->getCandidatos($request->perro_interesado_id);
        $perrosCandidatos = json_decode($responseCandidatos->getContent());
    
        // Lógica para crear una interacción utilizando los resultados obtenidos
        $interaccion = new Interaccion();
        $interaccion->perro_interesado_id = $request->perro_interesado_id;
        $interaccion->perro_candidato_id = $perroRandom->id;
        // Aquí puedes establecer las lógicas adicionales para determinar la preferencia
        $interaccion->preferencia = $request->preferencia;
        // Guardar la interacción en la base de datos
        $interaccion->save();
    
        // Lógica para verificar si hay un match
        $match = Interaccion::where('perro_interesado_id', $interaccion->perro_candidato_id)
            ->where('perro_candidato_id', $interaccion->perro_interesado_id)
            ->where('preferencia', 'A')
            ->first();
    
        if ($match && $interaccion->preferencia == 'A') {
            return response()->json(['message' => '¡Hay match!', 'interaccion' => $interaccion], 201);
        } else {
            return response()->json(['message' => 'Ok', 'interaccion' => $interaccion], 201);
        }
    }
    
    
    

    public function update(Request $request, $id)
    {
        $interaccion = Interaccion::find($id);
        if (!$interaccion) {
            return response()->json(['error' => 'Interacción no encontrada'], 404);
        }
        $interaccion->update($request->all());
        return response()->json($interaccion);
    }
    
    public function destroy($id)
    {
        $interaccion = Interaccion::find($id);
        if (!$interaccion) {
            return response()->json(['error' => 'Interacción no encontrada'], 404);
        }
        $interaccion->delete();
        return response()->json('Interacción eliminada correctamente');
    }
    
}
