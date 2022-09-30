<?php

namespace App\Http\Controllers;

use App\Models\semilleros;
use App\Models\User;
use App\Models\estudiantes_asignados;
use App\Models\profesores;
use App\Models\universitarios_asignados;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cantidadSemi = count(semilleros::all());
        $cantidadGruestu = count(estudiantes_asignados::all());
        $cantidadGruuni = count(universitarios_asignados::all());
        $cantidadUser = count(User::all());
        $cantidadProfesores = count(profesores::all());

        return view('admin.index',
        [
            'cantidadSemi' => $cantidadSemi,
            'cantidadGruestu' => $cantidadGruestu,
            'cantidadGruuni' => $cantidadGruuni,
            'cantidadUser' => $cantidadUser,
            'cantidadProfesores' => $cantidadProfesores
        ]);
    }
}
