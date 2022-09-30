<?php

namespace App\Http\Controllers;

use App\Models\colegio_cursos;
use App\Models\colegio_grupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColegioGruposController extends Controller
{
    private $model;

    public function __construct() 
    {
        $this->model = new colegio_grupos();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $grupos = DB::table($this->model->getTable())->where('grupo_cursoid', '=', $id)->get();
        $cursoNombre = colegio_cursos::findOrFail($id)->curso_nombre;
        $nombreSede = $request->nombreSede;
        $nombreColegio = $request->nombreColegio;

        return view('colegios.grupos', ['grupos' => $grupos, 'nombreSede' => $nombreSede, 'nombreColegio' => $nombreColegio, 'cursoNombre' => $cursoNombre]);
    }

    public function apiObtenerGrupos(Request $request)
    {
        $grupos = colegio_grupos::where('grupo_cursoid', $request->cursoId)->get();
        return response()->json(array('grupos' => $grupos), 200);
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
     * @param  \App\Models\colegio_grupos  $colegio_grupos
     * @return \Illuminate\Http\Response
     */
    public function show(colegio_grupos $colegio_grupos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\colegio_grupos  $colegio_grupos
     * @return \Illuminate\Http\Response
     */
    public function edit(colegio_grupos $colegio_grupos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\colegio_grupos  $colegio_grupos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colegio_grupos $colegio_grupos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\colegio_grupos  $colegio_grupos
     * @return \Illuminate\Http\Response
     */
    public function destroy(colegio_grupos $colegio_grupos)
    {
        //
    }
}
