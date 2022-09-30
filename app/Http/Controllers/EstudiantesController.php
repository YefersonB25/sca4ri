<?php

namespace App\Http\Controllers;

use App\Models\colegio_grupos;
use App\Models\estudiantes;
use App\Models\tipo_documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EstudiantesController extends Controller
{
    private $model;

    public function __construct() 
    {
        $this->model = new estudiantes();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $estudiantes = DB::table($this->model->getTable())
        ->where('est_grupoid', '=', $id)
        ->get();
        $nombreSede = $request->nombreSede;
        $nombreColegio = $request->nombreColegio;
        $cursoNombre = colegio_grupos::findOrFail($id)->grupo_nombre;
        $tiposDocumentos = tipo_documento::all();
        
        return view('colegios.estudiantes', ['idGrupo' => $id, 'tiposDocumentos' => $tiposDocumentos, 'estudiantes' => $estudiantes, 'nombreSede' => $nombreSede, 'nombreColegio' => $nombreColegio, 'cursoNombre' => $cursoNombre]);
    }

    public function apiObtenerEstudiantes(Request $request)
    {
        $estudiantes = estudiantes::where('est_grupoid', $request->grupoId)->get();
        return response()->json(array('estudiantes' => $estudiantes), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'primer_nombre' => ['required'],
            'primer_apellido' => ['required'],
            'numero_documento' => ['required', 'unique:estudiantes,est_numerodoc'],
            'tipo_documento' => ['required'],
            'grupo' => ['required']
        ])->validate();

        $estudiantes = new estudiantes();

        $estudiantes->est_nombre_1 = strtoupper($request->primer_nombre);
        $estudiantes->est_nombre_2 = isset($request->segundo_nombre) ? strtoupper($request->segundo_nombre) : null;
        $estudiantes->est_apellido_1 = strtoupper($request->primer_apellido);
        $estudiantes->est_apellido_2 = isset($request->segundo_apellido) ? strtoupper($request->segundo_apellido) : null;
        $estudiantes->est_numerodoc = $request->numero_documento;
        $estudiantes->est_tipodoc = strtoupper($request->tipo_documento);
        $estudiantes->est_grupoid = $request->grupo;
        $estudiantes->save();

        return back()->with('guardar', 'guardado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $estudiante = estudiantes::findOrFail($id);
        $tiposDocumentos = tipo_documento::all();

        return view('colegios.editarEstudiante', ['estudiante' => $estudiante, 'tiposDocumentos' => $tiposDocumentos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'primer_nombre' => ['required'],
            'primer_apellido' => ['required'],
            // 'numero_documento' => ['required', "unique:estudiantes,id,$request->estudiante"],
            'tipo_documento' => ['required'],
            'estudiante' => ['required']
        ])->validate();

        $estudiante = estudiantes::findOrFail($request->estudiante);

        $estudiante->est_nombre_1 = strtoupper($request->primer_nombre);
        $estudiante->est_nombre_2 = isset($request->segundo_nombre) ? strtoupper($request->segundo_nombre) : null;
        $estudiante->est_apellido_1 = strtoupper($request->primer_apellido);
        $estudiante->est_apellido_2 = isset($request->segundo_apellido) ? strtoupper($request->segundo_apellido) : null;
        $estudiante->est_numerodoc = $request->numero_documento;
        $estudiante->est_tipodoc = strtoupper($request->tipo_documento);
        $estudiante->save();

        return redirect()->back()->with('editar', 'editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $estudiante = estudiantes::findOrFail($id);

            if ($estudiante){

                $estudiante->delete();

                return response()->json(array('success' => true));
            }

        }
    }
}
