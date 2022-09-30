<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\colegios;
use App\Imports\ColegioImport;
use App\Imports\CursoGradoImport;
use App\Imports\EstudiantesImport;
use App\Imports\GruposImport;
use App\Models\colegio_cursos;
use App\Models\colegio_grupos;
use App\Models\colegio_sedes;
use App\Models\estudiantes;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ColegiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colegios = colegios::all();
        return view('colegios.index', ['colegios' => $colegios]);
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
     * @param  \App\Models\colegios  $colegios
     * @return \Illuminate\Http\Response
     */
    public function show(colegios $colegios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\colegios  $colegios
     * @return \Illuminate\Http\Response
     */
    public function edit(colegios $colegios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\colegios  $colegios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colegios $colegios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\colegios  $colegios
     * @return \Illuminate\Http\Response
     */
    public function destroy(colegios $colegios)
    {
        //
    }
    public function importExportView()
    {
        // return response()->json("czxcx");

        return view('focalizado');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function export() 
    // {
    //     return Excel::download(new ColegioImport, 'Focalizado.xlsx');
    // }

    public function import() 
    {
        $Userid = Auth::user()->id;

        colegios::truncate();
        colegio_sedes::truncate();
        colegio_cursos::truncate();
        colegio_grupos::truncate();
        estudiantes::truncate();
        
        Excel::import(new ColegioImport,request()->file('file'));
        Excel::import(new CursoGradoImport,request()->file('file'));
        Excel::import(new GruposImport,request()->file('file'));
        Excel::import(new EstudiantesImport,request()->file('file'));

        $Log = new Log;
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Importo Colegios';
        $Log->save();
        
        return back()->with('mensageimport', 'ok');
    }
}
