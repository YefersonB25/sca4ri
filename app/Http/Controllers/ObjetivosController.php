<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Objetivos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ObjetivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objetivos = Objetivos::all();
        return view('objetivo.index', ['objetivos' => $objetivos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearObjetivo(Request $request)
    {
        // return response()->json($request->all());
        $Userid = Auth::user()->id;
        
        Validator::make($request->all(), [
            'categoria' => ['required', 'min:4', 'max:50'],
            'nombreObj' => ['required'],
            'descripcionObj' => ['required'],
        ])->validate();

        $lenght = count($request->nombreObj);

        for ($i=0; $i < $lenght; $i++) 
        { 
            $nombreObjetivo = $request->nombreObj[$i]; 
            $descripcionObjetivo = $request->descripcionObj[$i];

            Objetivos::create([
                'objetivo_categoria' => $request->categoria,
                'objetivo_nombre' => $nombreObjetivo,
                'objetivo_descripcion' => $descripcionObjetivo
            ]);
        }

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Creo un Objetivo';
        $Log->save();

        return redirect()->back()->with('mensajeOk', 'ok');
    }

    public function apiObtenerObjetivos(Request $request)
    {
        $objetivos = Objetivos::where('id', $request->idObjetivo)->get();
        return response()->json(array('objetivos' => $objetivos), 200);
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
     * @param  \App\Models\Objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function show(Objetivos $objetivos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $objetivo = Objetivos::findOrFail($id); 

        return view('objetivo.edit',[
            'objetivo' => $objetivo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Userid = Auth::user()->id;
        
        Validator::make($request->all(), [
            'categoria' => ['required', 'min:4', 'max:50'],
            'nombreObj' => ['required'],
            'descripcionObj' => ['required'],
        ])->validate();

        $objetivo  = Objetivos::findOrFail($id);
        
        $objetivo->objetivo_categoria     =   $request->get('categoria');
        $objetivo->objetivo_nombre        =   $request->get('nombreObj');
        $objetivo->objetivo_descripcion   =   $request->get('descripcionObj');

        $objetivo->save();

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Editó un Objetivo';
        $Log->save();

        $objetivos = Objetivos::all();
        return redirect()->back()->with('mensajedit', 'ok');
        // return view('objetivo.index')->with('mensajeOk', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $objetivo = Objetivos::findOrFail($id);

            if ($objetivo){

                $objetivo->delete();

                return response()->json(array('success' => true));
                // return redirect('bodegas');
            }

        }
    }
}
