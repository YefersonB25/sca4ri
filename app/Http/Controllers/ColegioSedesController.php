<?php

namespace App\Http\Controllers;

use App\Models\colegio_sedes;
use App\Models\colegios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColegioSedesController extends Controller
{
    private $model;

    public function __construct() 
    {
        $this->model = new colegio_sedes();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sedes = DB::table($this->model->getTable())->where('sede_danecolegio', '=', $id)->get();

        $nombreColegio = colegios::findOrFail($id)->col_nombre;
        return view('colegios.sede', ['sedes' => $sedes, 'nombreColegio' => $nombreColegio]);
    }

    public function apiObtenerSedes(Request $request)
    {
        $sedes = colegio_sedes::where('sede_danecolegio', $request->colegioId)->get();
        return response()->json(array('sedes' => $sedes), 200);
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
     * @param  \App\Models\colegio_sedes  $colegio_sedes
     * @return \Illuminate\Http\Response
     */
    public function show(colegio_sedes $colegio_sedes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\colegio_sedes  $colegio_sedes
     * @return \Illuminate\Http\Response
     */
    public function edit(colegio_sedes $colegio_sedes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\colegio_sedes  $colegio_sedes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colegio_sedes $colegio_sedes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\colegio_sedes  $colegio_sedes
     * @return \Illuminate\Http\Response
     */
    public function destroy(colegio_sedes $colegio_sedes)
    {
        //
    }
}
