<?php

namespace App\Http\Controllers;

use App\Imports\UniversidadesCarrerasImport;
use App\Imports\UniversidadesImport;
use App\Imports\UniversidadSemestresImport;
use App\Imports\UniversitariosImport;
use App\Models\Log;
use App\Models\universidad_carreras;
use App\Models\universidad_sedes;
use App\Models\universidad_semestres;
use App\Models\universidades;
use App\Models\universitarios;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UniversidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universidades = universidades::all();
        return view('universidades.index', ['universidades' => $universidades]);
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
     * @param  \App\Models\universidades  $universidades
     * @return \Illuminate\Http\Response
     */
    public function show(universidades $universidades)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\universidades  $universidades
     * @return \Illuminate\Http\Response
     */
    public function edit(universidades $universidades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\universidades  $universidades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, universidades $universidades)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\universidades  $universidades
     * @return \Illuminate\Http\Response
     */
    public function destroy(universidades $universidades)
    {
        //
    }

    public function import() 
    {
        $Userid = Auth::user()->id;
        
        universidades::truncate();
        universidad_sedes::truncate();
        universidad_carreras::truncate();
        universidad_semestres::truncate();
        universitarios::truncate();
        
        Excel::import(new UniversidadesImport,request()->file('file'));
        Excel::import(new UniversidadesCarrerasImport,request()->file('file'));
        Excel::import(new UniversidadSemestresImport,request()->file('file'));
        Excel::import(new UniversitariosImport,request()->file('file'));
        
        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Importo Univesidades';
        $Log->save();
        return back()->with('mensageimport', 'ok');
    }
}
