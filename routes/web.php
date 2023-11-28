<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\PerroController;
use App\Http\Controllers\InteraccionController;

Route::get('/perros', [PerroController::class, 'index']);
Route::get('perros/random', [PerroController::class, 'randomPerro']);
Route::get('/perros/candidatos/{idPerroInteresado}', [PerroController::class, 'getCandidatos']);
Route::get('/perros/{id}', [PerroController::class, 'show']);
Route::post('/perros/crear', [PerroController::class, 'store']);
Route::put('/perros/{id}', [PerroController::class, 'update']);
Route::delete('/perros/{id}', [PerroController::class, 'destroy']);


Route::get('/interacciones', [InteraccionController::class, 'index']);
Route::get('/interacciones/preferencias/{idPerroInteresado}', [InteraccionController::class, 'showPreferencias']);
Route::get('/interacciones/{id}', [InteraccionController::class, 'show']);
Route::post('/interacciones/crear', [InteraccionController::class, 'store']);




Route::get('/', function () {
    return view('welcome');
});

Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        if(DB::connection()->getDatabaseName()){
            echo "Conectado exitosamente a la base de datos ".DB::connection()->getDatabaseName().".";
        }else{
            echo "No se pudo conectar a la base de datos. Por favor, revisa tus configuraciones.";
        }
    } catch (\Exception $e) {
        die("No se pudo conectar a la base de datos. Por favor, revisa tus configuraciones.");
    }
});




