<?php

namespace App\Http\Controllers;

use App\Models\universidad_sedes;
use App\Models\universidades;
use Illuminate\Http\Request;

class UniversidadSedesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sedes = universidad_sedes::where('sede_universidadid', '=', $id)->get();

        $nombreUniversidad = universidades::findOrFail($id)->uni_nombre;
        return view('universidades.sede', ['sedes' => $sedes, 'nombreUniversidad' => $nombreUniversidad]);
    }

    public function apiObtenerSedes(Request $request)
    {
        $sedes = universidad_sedes::where('sede_universidadid', $request->universidadId)->get();
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
     * @param  \App\Models\universidad_sedes  $universidad_sedes
     * @return \Illuminate\Http\Response
     */
    public function show(universidad_sedes $universidad_sedes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universidad_sedes  $universidad_sedes
     * @return \Illuminate\Http\Response
     */
    public function edit(universidad_sedes $universidad_sedes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universidad_sedes  $universidad_sedes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, universidad_sedes $universidad_sedes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universidad_sedes  $universidad_sedes
     * @return \Illuminate\Http\Response
     */
    public function destroy(universidad_sedes $universidad_sedes)
    {
        //
    }
}
