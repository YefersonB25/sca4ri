<?php

namespace App\Http\Controllers;

use App\Models\universidad_carreras;
use App\Models\universidad_sedes;
use Illuminate\Http\Request;

class UniversidadCarrerasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $carreras = universidad_carreras::where('carrera_sedeid', '=', $id)->get();

        $nombreUniversidad = $request->nombreUniversidad;
        $nombreSede = universidad_sedes::findOrFail($id)->sede_nombre;
        session(['idSede' => $id]);

        return view('universidades.carrera', ['carreras' => $carreras, 'nombreUniversidad' => $nombreUniversidad, 'nombreSede' => $nombreSede]);
    }

    public function apiObtenerCarreras(Request $request)
    {
        $carreras = universidad_carreras::where('carrera_sedeid', $request->sedeId)->get();
        return response()->json(array('carreras' => $carreras), 200);
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
     * @param  \App\Models\universidad_carreras  $universidad_carreras
     * @return \Illuminate\Http\Response
     */
    public function show(universidad_carreras $universidad_carreras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universidad_carreras  $universidad_carreras
     * @return \Illuminate\Http\Response
     */
    public function edit(universidad_carreras $universidad_carreras)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universidad_carreras  $universidad_carreras
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, universidad_carreras $universidad_carreras)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universidad_carreras  $universidad_carreras
     * @return \Illuminate\Http\Response
     */
    public function destroy(universidad_carreras $universidad_carreras)
    {
        //
    }
}
