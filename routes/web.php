<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\VacanteController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\NotificacionesController;

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

//Pagina de Inicio
Route::get('/', 'App\Http\Controllers\InicioController')->name('Inicio');
//Categorias
Route::get('categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');


//Rutas Protegidas
Route::middleware(['auth', 'verified'])->group(function () {
    //Ruta de vacantes
    Route::get('vacantes', [VacanteController::class, 'index'])->name('vacantes.index');
    Route::get('vacantes/create', [VacanteController::class, 'create'])->name('vacantes.create');
    Route::post('vacantes', [VacanteController::class, 'store'])->name('vacantes.store');
    Route::delete('/vacantes/{vacante}',[VacanteController::class,'destroy'])->name('vacantes.destroy');
    Route::get('/vacantes/{vacante}/edit',[VacanteController::class,'edit'])->name('vacantes.edit');
    Route::put('/vacantes/{vacante}', [VacanteController::class, 'update'])->name('vacantes.update');
    //Subir imagenes con Dropzone
    Route::post('/vacantes/imagen', [VacanteController::class, 'imagen'])->name('vacantes.imagen');
    Route::post('/vacantes/borrarimagen', [VacanteController::class, 'borrarimagen'])->name('vacantes.borrar');
    //Cambiar estado de la vacante
    Route::post('/vacantes/{vacante}', [VacanteController::class, 'estado'])->name('vacantes.estado');

    //Notificaciones
    Route::get('/notificaciones', 'App\Http\Controllers\NotificacionesController')->name('notificaciones');

});


//Enviar datos a la vacante
Route::get('/candidatos/{id}', [CandidatoController::class, 'index'])->name('candidatos.index');
Route::post('candidatos/store', [CandidatoController::class, 'store'])->name('candidatos.store');

//Muestra los trabajos en el FrontEnd sin autenticación
Route::get('vacantes/{vacante}', [VacanteController::class, 'show'])->name('vacantes.show');



// Muestra los trabajos en el front end sin autenticación
Route::get('/busqueda/buscar', [VacanteController::class, 'resultados'])->name('vacantes.resultados');
Route::post('/busqueda/buscar', [VacanteController::class, 'buscar'])->name('vacantes.buscar');
Route::get('/vacantes/{vacante}', [VacanteController::class, 'show'])->name('vacantes.show');


