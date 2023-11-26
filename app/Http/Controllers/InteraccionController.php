<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaccion;

class InteraccionController extends Controller
{
    public function index()
    {
        $interacciones = Interaccion::all();
        return response()->json($interacciones);
    }

    public function show($id)
    {
        $interaccion = Interaccion::find($id);
        return response()->json($interaccion);
    }

    public function store(Request $request)
    {
        $interaccion = Interaccion::create($request->all());
        return response()->json($interaccion);
    }

    public function update(Request $request, $id)
    {
        $interaccion = Interaccion::find($id);
        $interaccion->update($request->all());
        return response()->json($interaccion);
    }

    public function destroy($id)
    {
        $interaccion = Interaccion::find($id);
        $interaccion->delete();
        return response()->json('Interacción eliminada correctamente');
    }
}
