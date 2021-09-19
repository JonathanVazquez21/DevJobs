<?php

namespace App\Http\Controllers;

use App\Models\Salario;
use App\Models\Vacante;
use App\Models\Categoria;
use App\Models\Ubicacion;
use App\Models\Experiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VacanteController extends Controller
{
    public function __construct(){
         //Revisar que el usuario este autenticado por login y correo
         $this->middleware(['auth', 'verified']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vacantes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Consultas
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();

        
        return view('vacantes.create')
                    ->with('categorias', $categorias)
                    ->with('experiencias', $experiencias)
                    ->with('ubicaciones', $ubicaciones)
                    ->with('salarios', $salarios);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function show(Vacante $vacante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacante $vacante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacante $vacante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacante $vacante)
    {
        //
    }


    //Extras
    public function imagen(Request $request){
        $imagen = $request->file('file');
        $nombreImagen = time() . '.' . $imagen->extension();
        $imagen->move(public_path('storage/vacantes'),$nombreImagen);

        return response()->json(['correcto' => $nombreImagen]);
    }

    //Borrar imagen
    public function borrarimagen(Request $request){
        
        if ($request->ajax()) {
         $imagen = $request->get('imagen');
         if (File::exists('storage/vacantes/' . $imagen)) {
             File::delete('storage/vacantes/' . $imagen);
         }
         return response('Imagen Eliminada', 200);
        }
    }
}
