<?php

namespace App\Http\Controllers;

use App\Models\universidad_carreras;
use App\Models\universidad_semestres;
use Illuminate\Http\Request;

class UniversidadSemestresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $semestres = universidad_semestres::where('semestre_carreraid', '=', $id)->get();
        $carreraNombre = universidad_carreras::findOrFail($id)->carrera_nombre;
        $nombreSede = $request->nombreSede;
        $nombreUniversidad = $request->nombreUniversidad;

        return view('universidades.semestres', ['semestres' => $semestres, 'nombreSede' => $nombreSede, 'nombreUniversidad' => $nombreUniversidad, 'carreraNombre' => $carreraNombre]);
    }

    public function apiObtenerSemestres(Request $request)
    {
        $semestres = universidad_semestres::where('semestre_carreraid', $request->carreraId)->get();
        return response()->json(array('semestres' => $semestres), 200);
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
     * @param  \App\Models\universidad_semestres  $universidad_semestres
     * @return \Illuminate\Http\Response
     */
    public function show(universidad_semestres $universidad_semestres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universidad_semestres  $universidad_semestres
     * @return \Illuminate\Http\Response
     */
    public function edit(universidad_semestres $universidad_semestres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universidad_semestres  $universidad_semestres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, universidad_semestres $universidad_semestres)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universidad_semestres  $universidad_semestres
     * @return \Illuminate\Http\Response
     */
    public function destroy(universidad_semestres $universidad_semestres)
    {
        //
    }
}
