<?php

namespace App\Http\Controllers;

use App\Models\colegio_cursos;
use App\Models\colegio_grupos;
use App\Models\colegio_sedes;
use App\Models\colegios;
use App\Models\estudiantes;
use App\Models\estudiantes_asignados;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EstudiantesAsignadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colegios = colegios::all();
        $grupos = estudiantes_asignados::all();
        return view('estudiantes.estudiantesAsignados', ['colegios' => $colegios, 'grupos' => $grupos]);
    }

    public function ver($id)
    {
        $colegios = colegios::all();
        $todosEstudiantes = estudiantes::all();
        $grupoEstudiantes = estudiantes_asignados::findOrFail($id);
        $estudiantes = array();
        
        foreach ($grupoEstudiantes->est_asig_estudianteid as $idEstudiante) 
        {
            if(!empty($idEstudiante['id']))
            {
                $estudiante = estudiantes::findOrFail($idEstudiante['id']);
                array_push($estudiantes, $estudiante);
            }
        }
        
        return view('estudiantes.ver', [
            'grupoEstudiantes' => $grupoEstudiantes,
            'estudiantes' => $estudiantes, 
            'colegios' => $colegios,
            'estudiantes' => $estudiantes,
            'todosEstudiantes' => $todosEstudiantes
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
            'est_asig_nombre_grupo' => ['required', 'min:4', 'unique:estudiantes_asignados,est_asig_nombre_grupo'],
            'listaEstudiantesAsignados' => ['required']
        ], [
            'required' => 'The field is required.',
            'unique' => 'The name has already been taken.'
        ])->validate();

        $estudiantes = explode(',', $request->listaEstudiantesAsignados);
        $est_asig_estudianteid = array();
        
        foreach ($estudiantes as $key => $idEstudiante) 
        {
            $id = array(
                'id' => $idEstudiante
            );

            array_push($est_asig_estudianteid, $id);
        }

        $estudiantes_asignados = new estudiantes_asignados;
        $estudiantes_asignados->est_asig_nombre_grupo = $request->est_asig_nombre_grupo;
        $estudiantes_asignados->est_asig_estudianteid = $est_asig_estudianteid;
        $estudiantes_asignados->save();

        UsuariosController::crearUsuariosEstudiantes($estudiantes);

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Creo un grupo de Estudiantes';
        $Log->save();

        return redirect()->back()->with('mensajeOk', 'ok');
    }

    public function apiObtenerNombreGrupos(Request $request)
    {
        $response = array(
            'error' => false,
        );

        $validator = Validator::make($request->all(), [
            'nombreGrupo' => ['unique:estudiantes_asignados,est_asig_nombre_grupo']
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
            'listaEstudiantesAsignados' => ['required']
        ], [
            'required' => 'The field is required.',
            'unique' => 'The name has already been taken.'
        ])->validate();

        $grupo = estudiantes_asignados::where('id', $request->idGrupo)->get();
        $estudiantesId = $grupo[0]->est_asig_estudianteid;
        $estudiantes = explode(',', $request->listaEstudiantesAsignados);
        $logs = array();

        foreach ($estudiantes as $key => $idEstudiante) 
        {
            $estudiante = estudiantes::findOrFail($idEstudiante);
            $log = "Ha añadido al estudiante {$estudiante->est_nombre_1} {$estudiante->est_apellido_1} con indentificación {$estudiante->est_tipodooc} {$estudiante->est_numerodoc} al grupo de estudiantes {$grupo[0]->est_asig_nombre_grupo} y ha creado su usuario";
            $id = array(
                'id' => $idEstudiante
            );
            
            array_push($logs, $log);
            array_push($estudiantesId, $id);

        }
        
        estudiantes_asignados::where('id', $grupo[0]->id)
        ->update(['est_asig_estudianteid' => $estudiantesId]);
        UsuariosController::crearUsuariosEstudiantes($estudiantes);

        foreach ($logs as $key => $log) 
        {
            LogController::create($log);
        }

        return back()->with('estudianteAñadido', 'estudiante agregado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\estudiantes_asignados  $estudiantes_asignados
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $estudiantes_asignados = estudiantes_asignados::findOrFail($id);
            
            foreach ($estudiantes_asignados->est_asig_estudianteid as $key) 
            {
                User::where([
                    ['numerodoc', $key['id']],
                    ['usuario_rolid', 5],
                ])->delete();
            }

            if ($estudiantes_asignados){

                $estudiantes_asignados->delete();

                return response()->json(array('success' => true));
            }

        }
    }
}
