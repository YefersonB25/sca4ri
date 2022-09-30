<?php

namespace App\Http\Controllers;

use App\Models\universidad_carreras;
use App\Models\universidad_semestres;
use App\Models\Log;
use App\Models\universitarios;
use App\Models\tipo_documento; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UniversitariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {

        $idSede = session('idSede');
        $carreraNombre = $request->carreraNombre;
        $carrera = universidad_carreras::where([
            ['carrera_sedeid', '=', $idSede],
            ['carrera_nombre', '=', $carreraNombre]
        ])->get();

        $universitarios = universitarios::where([
            ['uni_semestreid', '=', $id],
            ['uni_carreraid', '=', $carrera[0]->id]
        ])->get();
        $nombreSede = $request->nombreSede;
        $nombreUniversidad = $request->nombreUniversidad;
        $semestreNombre = universidad_semestres::where('id', '=', $id)->get()[0]->semestre_nombre;
        $tipodocumento = tipo_documento::all();

        $uni = universitarios::where([
            ['uni_semestreid', '=', $id],
            ['uni_carreraid', '=', $carrera[0]->id]
        ])->first(); 
        // dd($uni);
        
        return view('universidades.universitarios', ['universitarios' => $universitarios, 'nombreSede' => $nombreSede, 'nombreUniversidad' => $nombreUniversidad, 'semestreNombre' => $semestreNombre, 'tipodocumento' => $tipodocumento, 'uni' => $uni]);
    }

    public function apiObtenerUniversitarios(Request $request)
    {
        $universitarios = universitarios::where([
            ['uni_semestreid', $request->semestreId],
            ['uni_carreraid', $request->carreraId]
        ])->get();
        return response()->json(array('universitarios' => $universitarios), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Userid = Auth::user()->id;

        $uni = new universitarios();
        
        $uni->uni_nombre_1       =$request->get('nombre1');
        $uni->uni_nombre_2       =$request->get('nombre2');
        $uni->uni_apellido_1     =$request->get('apellido1');
        $uni->uni_apellido_2     =$request->get('apellido2');
        $uni->uni_tipodoc        =$request->get('tipodoc');
        $uni->uni_numerodoc      =$request->get('numerodoc');
        $uni->uni_carreraid      =$request->get('uni_carreraid');
        $uni->uni_semestreid     =$request->get('uni_semestreid');
        
        // return response()->json($uni);
        
        $uni->save();

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Creó un universitario con identificación '. $uni->uni_tipodoc. ' : ' . $uni->uni_numerodoc;
        $Log->save();

        return redirect()->back()->with('new', 'ok');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function show(universitarios $universitarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $universitario = universitarios::findOrFail($id); 
        $tipodocumento = tipo_documento::all();

        return view('universidades.edit',[
            'universitario' => $universitario, 'tipodocumento' => $tipodocumento
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Userid = Auth::user()->id;

        $uni  = universitarios::findOrFail($id);
        
        $uni->uni_nombre_1       =$request->get('nombre1');
        $uni->uni_nombre_2       =$request->get('nombre2');
        $uni->uni_apellido_1     =$request->get('apellido1');
        $uni->uni_apellido_2     =$request->get('apellido2');
        $uni->uni_tipodoc        =$request->get('tipodocumento');
        $uni->uni_numerodoc      =$request->get('numerodoc');
        $uni->uni_carreraid      =$request->get('uni_carreraid');
        $uni->uni_semestreid     =$request->get('uni_semestreid');

        $uni->save();

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Editó el universitario con identificación '. $uni->uni_tipodoc. ' : ' . $uni->uni_numerodoc;
        $Log->save();

        // $objetivos = Objetivos::all();
        return redirect()->back()->with('mensajedit', 'ok');
        // return view('objetivo.index')->with('mensajeOk', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $Userid = Auth::user()->id;

            $uni = universitarios::findOrFail($id);

            if ($uni){

                $uni->delete();

                $Log = new Log();
                $Log->usuario_id = $Userid;
                $Log->Accion = 'Eliminó el universitario con identificación '. $uni->uni_tipodoc. ' : ' . $uni->uni_numerodoc;
                $Log->save();

                return response()->json(array('success' => true));
                // return redirect('bodegas');
            }

        }
    }
}
