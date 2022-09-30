<?php

namespace App\Http\Controllers;

use App\Models\colegio_cursos;
use App\Models\colegio_sedes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColegioCursosController extends Controller
{
    private $model;

    public function __construct() 
    {
        $this->model = new colegio_cursos();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $cursos = DB::table($this->model->getTable())->where('curso_sedeid', '=', $id)->get();

        $nombreColegio = $request->nombreColegio;
        $nombreSede = colegio_sedes::findOrFail($id)->sede_nombre;

        return view('colegios.cursos', ['cursos' => $cursos, 'nombreColegio' => $nombreColegio, 'nombreSede' => $nombreSede]);
    }

    public function apiObtenerCursos(Request $request)
    {
        $cursos = colegio_cursos::where('curso_sedeid', $request->sedeId)->get();
        return response()->json(array('cursos' => $cursos), 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\colegio_cursos  $colegio_cursos
     * @return \Illuminate\Http\Response
     */
    public function show(colegio_cursos $colegio_cursos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\colegio_cursos  $colegio_cursos
     * @return \Illuminate\Http\Response
     */
    public function edit(colegio_cursos $colegio_cursos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\colegio_cursos  $colegio_cursos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colegio_cursos $colegio_cursos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\colegio_cursos  $colegio_cursos
     * @return \Illuminate\Http\Response
     */
    public function destroy(colegio_cursos $colegio_cursos)
    {
        //
    }
}
