<?php

namespace App\Http\Controllers;

use App\Models\estudiantes;
use App\Models\Log;
use App\Models\user;
use App\Models\tipo_documento;
use App\Models\universitarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $tipodocumento = tipo_documento::all();
        $usuarios = user::where('estado', '1')->get();

        return view('usuarios.index', ['usuarios' => $usuarios,'roles' => $roles,'tipodocumento' => $tipodocumento]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $Userid = Auth::user()->id;

        $Usuarios = new user;
        $Usuarios->name = $request->name;
        $Usuarios->email = $request->email;
        $Usuarios->tipodocid = $request->tipodoc;
        $Usuarios->numerodoc = $request->numdoc;
        $Usuarios->usuario_telefono = $request->usuario_telefono;
        $Usuarios->usuario_rolid = $request->rol;
        $Usuarios->password = Hash::make($request['password']);
        $Usuarios->save();

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Registro un usuario';
        $Log->save();

        return redirect()->back()->with('mensajeOk', 'ok');
    }

    public static function crearUsuariosEstudiantes(array $usuarios)
    {
        foreach ($usuarios as $key => $idEstudiante) 
        {
            $estudiantes = estudiantes::where('id', $idEstudiante)->get();

            User::create([
                'name' => "{$estudiantes[0]->est_nombre_1} {$estudiantes[0]->est_apellido_1}",
                'numerodoc' => $estudiantes[0]->id, /** numerodoc almacena el id del estudiante */
                'email' => "{$estudiantes[0]->est_numerodoc}@sca4ri.edu",
                'usuario_rolid' => 5,
                'estado' => 1,
                'password' => Hash::make($estudiantes[0]->est_numerodoc),
            ])->assignRole('Estudiante');
        }
    }

    public static function crearUsuariosMonitor(array $usuarios)
    {
        foreach ($usuarios as $key => $idUniversitario) 
        {
            $universitarios = universitarios::where('id', $idUniversitario)->get();

            User::create([
                'name' => "{$universitarios[0]->uni_nombre_1} {$universitarios[0]->uni_apellido_1}",
                'numerodoc' => $universitarios[0]->id, /** numerodoc almacena el id del universitario */
                'email' => "{$universitarios[0]->uni_numerodoc}@sca4ri.edu",
                'usuario_rolid' => 6,
                'estado' => 1,
                'password' => Hash::make($universitarios[0]->uni_numerodoc),
            ])->assignRole('Monitor universitario');
        }
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
     * @param  \App\Models\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function show(user $usuarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $roles = Role::all();

        return view('usuarios.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $Userid = Auth::user()->id;

        $user->roles()->sync($request->roles);

        $Log = new Log;
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Asigno Permisos';
        $Log->save();

        return redirect()->route('usuarios.users.edit', $user)->with('info', 'Se asignó los permisos correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $user = user::findOrFail($id);
            if ($user){

                $user->estado = 2;
                $user->save();

                LogController::create('Eliminó al usuario ' .$user->name);

                return response()->json(array('success' => true));
            }

        }
    }
}
