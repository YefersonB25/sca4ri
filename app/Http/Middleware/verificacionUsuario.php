<?php

namespace App\Http\Middleware;

use App\Models\estudiantes_asignados;
use App\Models\semilleros;
use App\Models\universitarios_asignados;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class verificacionUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $rol_usuario = Auth::user()->usuario_rolid;
        switch ($rol_usuario) 
        {
            case 5:
                $est_asig_estudianteid = estudiantes_asignados::all('id', 'est_asig_estudianteid');

                foreach ($est_asig_estudianteid as $idEstudiantes) 
                {            
                    foreach ($idEstudiantes->est_asig_estudianteid as $key)
                    {
                        $grupoId = $idEstudiantes->id;
                        if($key['id'] == Auth::user()->numerodoc)
                        {                          
                            return redirect()->route('semilleros.index', ['grupoId' => $grupoId]);
                        }
                    }
                }
                break;
            
            case 6:
                $uni_asig_universitariosid = universitarios_asignados::all('id', 'uni_asig_universitariosid');

                foreach ($uni_asig_universitariosid as $idUniversitarios) 
                {       
                    foreach ($idUniversitarios->uni_asig_universitariosid as $key)
                    {
                        $grupoId = $idUniversitarios->id;
                        if($key['id'] == Auth::user()->numerodoc)
                        {
                            return redirect()->route('semilleros.index', ['grupoId' => $grupoId]);
                        }
                    }
                }
                break;
        }
        return $next($request);
    }
}
