<?php

namespace App\Http\Controllers;

use App\Models\estudiantes;
use App\Models\estudiantes_asignados;
use App\Models\evidenciaModel;
use App\Models\Log;
use App\Models\materialApoyoModel;
use App\Models\Objetivos;
use App\Models\profesores;
use App\Models\semilleros;
use App\Models\universitarios;
use App\Models\universitarios_asignados;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SemillerosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolesPermitidos = array(1,3);
        if(in_array(Auth::user()->usuario_rolid, $rolesPermitidos))
        {
            $est_asig = DB::table('estudiantes_asignados')
            ->whereNotExists(function ($query) {
                $query->select()
                ->from('semilleros')
                ->whereColumn('semilleros.sem_grupo_est', '=', 'estudiantes_asignados.id');
            })
            ->get();

            $grupoEstudiantesAsig = $est_asig;

            $uni_asig = DB::table('universitarios_asignados')
            ->whereNotExists(function ($query) {
                $query->select()
                ->from('semilleros')
                ->whereColumn('semilleros.sem_grupo_uni', '=', 'universitarios_asignados.id');
            })
            ->get();

            $grupoUniversitariosAsig = $uni_asig;

            $profesores = profesores::all();
            $objetivos = Objetivos::all();
            $semilleros = semilleros::all();

            $parametros = ['grupoEstudiantesAsig' => $grupoEstudiantesAsig, 'grupoUniversitariosAsig' => $grupoUniversitariosAsig, 'profesores' => $profesores, 'objetivos' => $objetivos, 'semilleros' => $semilleros, 'rolesPermitidos' => $rolesPermitidos];
        }
        else
        {
            $semilleros = semilleros::where('sem_grupo_est', $request->grupoId)->get();
            $parametros = ['semilleros' => $semilleros, 'rolesPermitidos' => $rolesPermitidos];
        }

        return view('semilleros.index', $parametros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarSemillero(Request $request)
    {
        $Userid = Auth::user()->id;

        Validator::make($request->all(), [
            'sem_profeid' => ['required'],
            'sem_nombre' => ['required'],
            'sem_descripcion' => ['required'],
            'sem_fechainicio' => ['required', 'date'],
            'sem_fechafin' => ['required', 'date'],
            'sem_grupo_est' => ['required'],
            'sem_grupo_uni' => ['required'],
            'listaObjetivosAsignados' => ['required'],
        ])->validate();

        $objetivos = explode(',', $request->listaObjetivosAsignados);
        $objetivos_asignados = array();

        foreach ($objetivos as $key => $idObjetivos) 
        {
            $objetivo = array(
                'id' => $idObjetivos,
                'estado' => 'No cumplido',
                'supervisor' => false,
                'subirEvidencia' => false,
                'evidencia' => false
            );

            array_push($objetivos_asignados, $objetivo);
        }

        $semilleros = new semilleros;
        $semilleros->sem_nombre = $request->sem_nombre;
        $semilleros->sem_descripcion = $request->sem_descripcion;
        $semilleros->sem_fechainicio = $request->sem_fechainicio;
        $semilleros->sem_fechafin = $request->sem_fechafin;
        $semilleros->sem_grupo_profe = $request->sem_profeid;
        $semilleros->sem_grupo_est = $request->sem_grupo_est;
        $semilleros->sem_grupo_uni = $request->sem_grupo_uni;
        $semilleros->sem_objetivo = $objetivos_asignados;
        $semilleros->save();

        $ruta = "evidencias/Semillero-{$request->sem_nombre}";
        
        if(!Storage::exists($ruta))
        {
            Storage::makeDirectory($ruta);
        }
        
        
        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Creo un semillero y carpeta de evidencias ' . $request->sem_nombre;
        $Log->save();
        return back()->with('mensajeOk', 'ok');
    }

    public function apiSemilleros()
    {
        $semilleros = semilleros::all('sem_nombre', 'sem_objetivo');

        return response()->json($semilleros, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\semilleros  $semilleros
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        $rolesPermitidos = array(1,3);

        $semillero = semilleros::where('id', $id)->get();
        $estudiantes_asignados = estudiantes_asignados::where('id', $semillero[0]->sem_grupo_est)->get();
        $estudiantesAsignados = $estudiantes_asignados[0]->est_asig_estudianteid;
        $universitarios_asignados = universitarios_asignados::where('id', $semillero[0]->sem_grupo_uni)->get();
        $universitariosAsignados = $universitarios_asignados[0]->uni_asig_universitariosid;
        $objetivos_asignados = $semillero[0]->sem_objetivo;
        $profesor = profesores::where('id', $semillero[0]->sem_grupo_profe)->get()[0]->profe_nombre;
        $datosEvidencias = evidenciaModel::where('id_semillero', $id)->get();
        $datosMaterialesApoyo = materialApoyoModel::where('id_semillero', $id)->get();
        $estudiantesAll = estudiantes::all();

        $evidencias = array();
        foreach ($datosEvidencias as $evidencia) 
        {
            $usuario = User::where('id',$evidencia->id_usuario)->get()[0]->email;
            $objetivo_nombre = Objetivos::where('id', $evidencia->id_objetivo)->get()[0]->objetivo_nombre;
            $ubicacion_archivo = $evidencia->ubicacion_archivo;
            $creado = $evidencia->created_at;

            array_push($evidencias, array(
                'id' => $evidencia->id,
                'id_usuario' => $evidencia->id_usuario,
                'usuario' => $usuario,
                'objetivo_nombre' => $objetivo_nombre,
                'ubicacion_archivo' => $ubicacion_archivo,
                'creado' => $creado,
            ));
        }

        $estudiantes = array();
        $i=0;
        foreach ($estudiantesAsignados as $key => $idEstudiante) 
        {
            if(!empty($idEstudiante['id']))
            {
                
                $estudiante = estudiantes::where('id', $idEstudiante['id'])->get();
                array_push($estudiantes, $estudiante[0]);
            }
        }

        $universitarios = array();
        foreach ($universitariosAsignados as $key => $idUniversitario) 
        {
            if(!empty($idUniversitario['id']))
            {
                $universitario = universitarios::where('id', $idUniversitario['id'])->get();
                array_push($universitarios, $universitario[0]);
            }
        }

        $objetivos = array();
        foreach ($objetivos_asignados as $key => $idObjetivo) 
        {
            $objetivo = Objetivos::where('id', $idObjetivo['id'])->get();
            array_push($objetivos, 
                array(
                    'id' => $objetivo[0]->id,
                    'idObjetivo' => DB::table('semilleros')->select(DB::raw('JSON_EXTRACT(sem_objetivo, "$['.$key.'].id") AS id'))->where('id', $id)->get()[0]->id,
                    'nombre' => $objetivo[0]->objetivo_nombre,
                    'descripcion' => $objetivo[0]->objetivo_descripcion,
                    'estado' => DB::table('semilleros')->select(DB::raw('JSON_EXTRACT(sem_objetivo, "$['.$key.'].estado") AS estado'))->where('id', $id)->get()[0]->estado,
                    'subirEvidencia' => DB::table('semilleros')->select(DB::raw('JSON_EXTRACT(sem_objetivo, "$['.$key.'].subirEvidencia") AS subirEvidencia'))->where('id', $id)->get()[0]->subirEvidencia,
                    'supervisor' => DB::table('semilleros')->select(DB::raw('JSON_EXTRACT(sem_objetivo, "$['.$key.'].supervisor") AS supervisor'))->where('id', $id)->get()[0]->supervisor,
                    'evidencia' => DB::table('semilleros')->select(DB::raw('JSON_EXTRACT(sem_objetivo, "$['.$key.'].evidencia") AS evidencia'))->where('id', $id)->get()[0]->evidencia,
                )
            );
        }

        $materialesApoyo = array();
        foreach ($datosMaterialesApoyo as $materialApoyo) 
        {
            $usuario = User::where('id', $materialApoyo->id_usuario)->get()[0]->email;
            $titulo = $materialApoyo->titulo;
            $ubicacion_archivo = $materialApoyo->ubicacion_archivo;
            $creado = $materialApoyo->created_at;

            array_push($materialesApoyo, array(
                'id' => $materialApoyo->id,
                'usuario' => $usuario,
                'titulo' => $titulo,
                'ubicacion_archivo' => $ubicacion_archivo,
                'creado' => $creado,
            ));
        }

        return view('semilleros.ver', [
            'rolesPermitidos' => $rolesPermitidos,
            'profesor' => $profesor,
            'semillero' => $semillero,
            'objetivos' => $objetivos,
            'estudiantes' => $estudiantes,
            'estudiantesAll' => $estudiantesAll,
            'universitarios' => $universitarios,
            'evidencias' => $evidencias,
            'materialesApoyo' => $materialesApoyo
        ]);
    }

    public function hablilitarEvidencia(Request $request)
    {
        
        $Userid = Auth::user()->id;
        
        $validaciones = array(
            'idSemillero' => ['required'],
            'idObjetivo' => ['required'],
            'nombreObjetivo' => ['required'],
            'nombreSemillero' => ['required'],
            'indiceObjetivo' => ['required'],
            'evidencia' => ['file']
        );
        Validator::make($request->all(), $validaciones)->validate();

        $n = $request->indiceObjetivo + 1;
        $ruta = "evidencias/Semillero-{$request->nombreSemillero}/Objetivo{$n}";

        if(Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
        {
            if($request->subirEvidencia == true)
            {
                if(!Storage::exists($ruta) )
                {
                    Storage::makeDirectory($ruta);
                }
    
                DB::table('semilleros')
                ->where('id', '=', $request->idSemillero)
                ->update(['sem_objetivo' => DB::raw('JSON_SET(sem_objetivo, "$['.$request->indiceObjetivo.'].subirEvidencia", true)')]);
    
                $Log = new Log();
                $Log->usuario_id = $Userid;
                $Log->Accion = 'Habilito la subida de evidencias del semillero: '. $request->nombreSemillero.' Objetivo: '. $request->nombreObjetivo;
                $Log->save();

                $msj = 'habilitar';
            }
            else
            {
                DB::table('semilleros')
                ->where('id', '=', $request->idSemillero)
                ->update(['sem_objetivo' => DB::raw('JSON_SET(sem_objetivo, "$['.$request->indiceObjetivo.'].subirEvidencia", false)')]);
    
                $Log = new Log();
                $Log->usuario_id = $Userid;
                $Log->Accion = 'Deshabilito la subida de evidencias del semillero: '. $request->nombreSemillero.' Objetivo: '. $request->nombreObjetivo;
                $Log->save();

                $msj = 'deshabilitar';
            }
        }
        
        if($request->objCumplido == true)
        {            
            DB::table('semilleros')
            ->where('id', '=', $request->idSemillero)
            ->update(['sem_objetivo' => DB::raw('JSON_SET(sem_objetivo, "$['.$request->indiceObjetivo.'].estado", "Cumplido")')]);

            $Log = new Log();
            $Log->usuario_id = $Userid;
            $Log->Accion = 'Ha marcado el objetivo: ' . $request->nombreObjetivo . ' como cumplido del semillero: '. $request->nombreSemillero;
            $Log->save();

            $msj = 'marco';
        }
        else
        {
            DB::table('semilleros')
            ->where('id', '=', $request->idSemillero)
            ->update(['sem_objetivo' => DB::raw('JSON_SET(sem_objetivo, "$['.$request->indiceObjetivo.'].estado", "No cumplido")')]);

            $Log = new Log();
            $Log->usuario_id = $Userid;
            $Log->Accion = 'Ha marcado el objetivo: ' . $request->nombreObjetivo . ' como no cumplido del semillero: '. $request->nombreSemillero;
            $Log->save();

            $msj = 'desmarco';
        }
        
        if($request->cumplidoSupervisor == true)
        {
            DB::table('semilleros')
            ->where('id', '=', $request->idSemillero)
            ->update(['sem_objetivo' => DB::raw('JSON_SET(sem_objetivo, "$['.$request->indiceObjetivo.'].supervisor", true)')]);

            $Log = new Log();
            $Log->usuario_id = $Userid;
            $Log->Accion = 'Ha confirmado el cumplimiento del objetivo: ' . $request->nombreObjetivo . ' del semillero: ' . $request->nombreSemillero;
            $Log->save();

            $msj = 'confirmo';
        }
        else
        {
            DB::table('semilleros')
            ->where('id', '=', $request->idSemillero)
            ->update(['sem_objetivo' => DB::raw('JSON_SET(sem_objetivo, "$['.$request->indiceObjetivo.'].supervisor", false)')]);

            $Log = new Log();
            $Log->usuario_id = $Userid;
            $Log->Accion = 'Cambio el estado de cumplimiento del objetivo: ' . $request->nombreObjetivo . ' ha no cumplido del semillero: ' . $request->nombreSemillero;
            $Log->save();

            $msj = 'desconfirmo';
        }

        if(!empty($request->file('evidencia')))
        {
            $nombre = $request->file('evidencia')->getClientOriginalName();
            $usuario = Auth::user()->email;
            $rutaEvidencia = "{$ruta}/{$usuario}";

            Storage::putFileAs($rutaEvidencia, $request->file('evidencia'), $nombre);
            evidenciaModel::create([
                'id_semillero' => $request->idSemillero, 
                'id_objetivo' => $request->idObjetivo, 
                'id_usuario' => $Userid, 
                'ubicacion_archivo' => "$rutaEvidencia/{$nombre}"
            ]);
            
            $Log = new Log();
            $Log->usuario_id = $Userid;
            $Log->Accion = 'Habilito la subida de evidencias del semillero: '. $request->nombreSemillero.' Objetivo: '. $request->nombreObjetivo;
            $Log->save();

            $msj = 'evidencia';
        }       

        return redirect()->back()->with('mensajeOk', $msj);
    }

    public function subirMaterialApoyo(Request $request)
    {
        Validator::make($request->all(), [
            'id_semillero' => ['required'],
            'titulo' => ['required'],
            'materialApoyo' => ['required', 'file'],
        ])->validate();


        $Userid = Auth::user()->id;
        $ruta = "material de apoyo/Semillero-{$request->nombreSemillero}/{$request->titulo}";
        $nombre = $request->file('materialApoyo')->getClientOriginalName();
        $usuario = Auth::user()->email;
        $rutaMaterialApoyo = "{$ruta}/{$usuario}";

        Storage::putFileAs($rutaMaterialApoyo, $request->file('materialApoyo'), $nombre);
        materialApoyoModel::create([
            'id_semillero' => $request->id_semillero,
            'id_usuario' => $Userid, 
            'titulo' => $request->titulo, 
            'ubicacion_archivo' => "{$rutaMaterialApoyo}/{$nombre}"
        ]);
        
        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Subio material de apoyo de semillero: '. $request->nombreSemillero .' titulo: '. $request->titulo;
        $Log->save();

        return back()->with('mensajeOk', 'ok');
    }

    public function expulsarEstudiante($idGrupo, $idEstudiante, $idSemillero)
    {
        $Userid = Auth::user()->id;
        $estudiantes = estudiantes_asignados::where('id', $idGrupo)->get();
        $estudiante =  estudiantes::where('id', $idEstudiante)->get();
        $semillero = semilleros::where('id', $idSemillero)->get()[0]->sem_nombre;

        foreach ($estudiantes[0]->est_asig_estudianteid as $key => $value) 
        {
            estudiantes_asignados::where('id', $idGrupo)
            ->where(DB::raw('JSON_EXTRACT(est_asig_estudianteid, "$['.$key.'].id")'), '=', $idEstudiante)
            ->update(['est_asig_estudianteid' => DB::raw('JSON_REMOVE(est_asig_estudianteid, "$['.$key.'].id")')]);

            estudiantes::where('id', $idEstudiante)
            ->update(['disponibilidad' => 'Disponible']);
        }

        $this->eliminarUsuario($idEstudiante, 5);

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Ha expulsado al estudiante: '. $estudiante[0]->est_nombre_1 . ' ' . $estudiante[0]->est_apellido_1 . ' numeroDoc: ' . $estudiante[0]->est_numerodoc . ' del semillero: ' . $semillero . ' y su usuario ha sido eliminado';
        $Log->save();

        return back()->with('mensajeOk', 'Expulsado');
    }

    public function expulsarMonitor($idGrupo, $idUniversitario, $idSemillero)
    {
        $Userid = Auth::user()->id;
        $universitarios = universitarios_asignados::where('id', $idGrupo)->get();
        $universitario =  universitarios::where('id', $idUniversitario)->get();
        $semillero = semilleros::where('id', $idSemillero)->get()[0]->sem_nombre;

        foreach ($universitarios[0]->uni_asig_universitariosid as $key => $value) 
        {
            universitarios_asignados::where('id', $idGrupo)
            ->where(DB::raw('JSON_EXTRACT(uni_asig_universitariosid, "$['.$key.'].id")'), '=', $idUniversitario)
            ->update(['uni_asig_universitariosid' => DB::raw('JSON_REMOVE(uni_asig_universitariosid, "$['.$key.'].id")')]);
        }

        $this->eliminarUsuario($idUniversitario, 6);

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Ha expulsado al Monitor: '. $universitario[0]->uni_nombre_1 . ' ' . $universitario[0]->uni_apellido_1 . ' numeroDoc: ' . $universitario[0]->uni_numerodoc . ' del semillero: ' . $semillero . ' y su usuario ha sido eliminado';
        $Log->save();

        return back()->with('mensajeOk', 'Expulsado Monitor');
    }

    public function descargarArchivo($ubicacion_archivo)
    {
        $nombreExplode = explode('/', base64_decode($ubicacion_archivo));
        $n = count($nombreExplode);        
        $nombre = $nombreExplode[$n-1];

        return Storage::download(base64_decode($ubicacion_archivo), $nombre);
    }

    public function eliminarArchivo($ubicacion_archivo, $id, $model)
    {
        $Userid = Auth::user()->id;
        if($model == 'evidencia')
        {
            $nombreMensaje = 'eliminarMaterialApoyo';
            $tipo = 'evidencia';
            evidenciaModel::where([
                ['id', '=', $id]
            ])->delete();
        }
        
        if ($model == 'materialApoyo') 
        {
            $nombreMensaje = 'eliminarArchivo';
            $tipo = 'material de apoyo';
            materialApoyoModel::where([
                ['id', '=', $id]
            ])->delete();
        }        

        $nombreSemillero = explode('-', explode('/', base64_decode($ubicacion_archivo))[1])[1];
        $nombreArchivo = explode('/', base64_decode($ubicacion_archivo))[2];
        
        Storage::delete(base64_decode($ubicacion_archivo));

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = "Ha eliminado archivo de {$tipo}: {$nombreArchivo} del semillero: {$nombreSemillero}";
        $Log->save();

        return back()->with($nombreMensaje, 'ok');
    }

    public function eliminarUsuario($id, $usuario_rolid)
    {
        User::where([
            ['numerodoc', '=', $id],
            ['usuario_rolid', '=', $usuario_rolid]
        ])->delete();
    }

    public function añadirEstudiante(Request $request)
    {
        Validator::make($request->all(), [
            'semillero' => ['required'],
            'tipo' => ['required'],
            'grupoEstudiantes' => ['required'],
            'estudiante' => ['required']
        ])->validate();
        
        $estudiante = estudiantes::where('est_numerodoc',$request->estudiante)->get();

        $idEstudiante = $estudiante[0]->id;

        
        $semillero = semilleros::where('id',$request->semillero)->get();
        $grupo = estudiantes_asignados::where('id', $request->grupoEstudiantes)->get();
        $estudiantesId = $grupo[0]->est_asig_estudianteid;
        array_push($estudiantesId, array('id' => $idEstudiante));
        
        estudiantes_asignados::where('id', $grupo[0]->id)
        ->update(['est_asig_estudianteid' => $estudiantesId]);
        
        UsuariosController::crearUsuariosEstudiantes(array($idEstudiante));
        LogController::create(" Añadió al estudiante {$estudiante[0]->est_nombre_1} {$estudiante[0]->est_apellido_1} con indentificación {$estudiante[0]->est_tipodoc} #{$estudiante[0]->est_numerodoc} al semillero {$semillero[0]->sem_nombre} ");

        return back()->with('estudianteAñadido', 'estudiante agregado');
    }

    public function actualizarEstudiante($idEstudiante)
    {
        estudiantes::where('id', $idEstudiante)
        ->update(['est_asig_estudianteid' => 'activo']);
    }
}
