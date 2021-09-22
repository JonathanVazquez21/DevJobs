<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacanteController;
use App\Http\Controllers\CandidatoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rutas Protegidas
Route::middleware(['auth', 'verified'])->group(function () {
    //Ruta de vacantes
    Route::get('vacantes', [VacanteController::class, 'index'])->name('vacantes.index');
    Route::get('vacantes/create', [VacanteController::class, 'create'])->name('vacantes.create');
    Route::post('vacantes', [VacanteController::class, 'store'])->name('vacantes.store');
    //Subir imagenes con Dropzone
    Route::post('/vacantes/imagen', [VacanteController::class, 'imagen'])->name('vacantes.imagen');
    Route::post('/vacantes/borrarimagen', [VacanteController::class, 'borrarimagen'])->name('vacantes.borrar');
});

Route::post('candidatos/store', [CandidatoController::class, 'store'])->name('candidatos.store');

//Muestra los trabajos en el FrontEnd sin autenticación
Route::get('vacantes/{vacante}', [VacanteController::class, 'show'])->name('vacantes.show');






