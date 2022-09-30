<?php

namespace App\Http\Controllers;

use App\Models\universidad_carreras;
use App\Models\universidad_semestres;
use App\Models\universitarios;
use Illuminate\Http\Request;

class UniversitariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {

        $idSede = session('idSede');
        $carreraNombre = $request->carreraNombre;
        $carrera = universidad_carreras::where([
            ['carrera_sedeid', '=', $idSede],
            ['carrera_nombre', '=', $carreraNombre]
        ])->get();

        $universitarios = universitarios::where([
            ['uni_semestreid', '=', $id],
            ['uni_carreraid', '=', $carrera[0]->id]
        ])->get();
        $nombreSede = $request->nombreSede;
        $nombreUniversidad = $request->nombreUniversidad;
        $semestreNombre = universidad_semestres::where('id', '=', $id)->get()[0]->semestre_nombre;
        
        return view('universidades.universitarios', ['universitarios' => $universitarios, 'nombreSede' => $nombreSede, 'nombreUniversidad' => $nombreUniversidad, 'semestreNombre' => $semestreNombre]);
    }

    public function apiObtenerUniversitarios(Request $request)
    {
        $universitarios = universitarios::where([
            ['uni_semestreid', $request->semestreId],
            ['uni_carreraid', $request->carreraId]
        ])->get();
        return response()->json(array('universitarios' => $universitarios), 200);
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
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function show(universitarios $universitarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function edit(universitarios $universitarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, universitarios $universitarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universitarios  $universitarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(universitarios $universitarios)
    {
        //
    }
}
