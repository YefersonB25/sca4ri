<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\universidad_carreras;
use App\Models\universidad_sedes;
use App\Models\universidad_semestres;
use App\Models\universidades;
use App\Models\universitarios;
use App\Models\universitarios_asignados;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UniversitariosAsignadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universidades = universidades::all();
        $grupos = universitarios_asignados::all();
        return view('universitarios.universitariosAsignados', ['universidades' => $universidades, 'grupos' => $grupos]);
    }

    public function ver($id)
    {
        $universidades = universidades::all();
        $grupoUniversitarios = universitarios_asignados::findOrFail($id);
        $universitarios = array();
        
        foreach ($grupoUniversitarios->uni_asig_universitariosid as $idUniversitario) 
        {
            if(!empty($idUniversitario['id']))
            {
                $universitario = universitarios::findOrFail($idUniversitario['id']);
                array_push($universitarios, $universitario);
            }
        }

        return view('universitarios.ver', [
            'grupoUniversitarios' => $grupoUniversitarios,
            'universitarios' => $universitarios, 
            'universidades' => $universidades
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GuardarLista(Request $request)
    {
        $Userid = Auth::user()->id;

        Validator::make($request->all(), [
            'uni_asig_nombre_grupo' => ['required', 'min:4', 'unique:universitarios_asignados,uni_asig_nombre'],
            'listaUniversitariosAsignados' => ['required']
        ], [
            'required' => 'The field is required.',
            'unique' => 'The name has already been taken.'
        ])->validate();

        $universitarios = explode(',', $request->listaUniversitariosAsignados);
        $uni_asig_universitarioid = array();

        foreach ($universitarios as $key => $idUniversitario) 
        {
            $id = array(
                'id' => $idUniversitario
            );

            array_push($uni_asig_universitarioid, $id);
        }

        $universitarios_asignados = new universitarios_asignados;
        $universitarios_asignados->uni_asig_nombre = $request->uni_asig_nombre_grupo;
        $universitarios_asignados->uni_asig_universitariosid = $uni_asig_universitarioid;
        $universitarios_asignados->save();

        UsuariosController::crearUsuariosMonitor($universitarios);

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Creo un grupo de universitarios';
        $Log->save();

        return redirect()->back()->with('mensajeOk', 'ok');
    }

    public function apiObtenerNombreGrupos(Request $request)
    {
        $response = array(
            'error' => false,
        );

        $validator = Validator::make($request->all(), [
            'nombreGrupo' => ['unique:universitarios_asignados,uni_asig_nombre']
        ]);

        if($validator->fails())
        {
            $response = array(
                'error' => true,
                'errorText' => $validator->errors()
            );

            return response()->json($response, 200);
        }

        return response()->json($response, 200);
    }

    public function actualizarLista(Request $request)
    {
        Validator::make($request->all(), [
            'idGrupo' => ['required'],
            'listaUniversitariosAsignados' => ['required']
        ], [
            'required' => 'The field is required.',
        ])->validate();

        $grupo = universitarios_asignados::where('id', $request->idGrupo)->get();
        $universitariosId = $grupo[0]->uni_asig_universitariosid;
        $universitarios = explode(',', $request->listaUniversitariosAsignados);
        $logs = array();

        foreach ($universitarios as $key => $idUniversitario) 
        {
            $universitario = universitarios::findOrFail($idUniversitario);
            $log = "Ha añadido al universitario {$universitario->est_nombre_1} {$universitario->est_apellido_1} con indentificación {$universitario->est_tipodooc} {$universitario->est_numerodoc} al grupo de monitores {$grupo[0]->uni_asig_nombre} y ha creado su usuario";
            $id = array(
                'id' => $idUniversitario
            );
            
            array_push($logs, $log);
            array_push($universitariosId, $id);

        }
        
        universitarios_asignados::where('id', $grupo[0]->id)
        ->update(['uni_asig_universitariosid' => $universitariosId]);
        UsuariosController::crearUsuariosMonitor($universitarios);

        foreach ($logs as $key => $log) 
        {
            LogController::create($log);
        }

        return back()->with('universitarioAñadido', 'monitores agregado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\universitarios_asignados  $universitarios_asignados
     * @return \Illuminate\Http\Response
     */
    public function show(universitarios_asignados $universitarios_asignados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universitarios_asignados  $universitarios_asignados
     * @return \Illuminate\Http\Response
     */
    public function edit(universitarios_asignados $universitarios_asignados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universitarios_asignados  $universitarios_asignados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, universitarios_asignados $universitarios_asignados)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universitarios_asignados  $universitarios_asignados
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $universitarios_asignados = universitarios_asignados::findOrFail($id);

            foreach ($universitarios_asignados->uni_asig_universitariosid as $key) 
            {
                User::where([
                    ['numerodoc', $key['id']],
                    ['usuario_rolid', 6],
                ])->delete();
            }

            if ($universitarios_asignados){

                $universitarios_asignados->delete();

                return response()->json(array('success' => true));
            }

        }
    }
}
