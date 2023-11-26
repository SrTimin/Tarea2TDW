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


