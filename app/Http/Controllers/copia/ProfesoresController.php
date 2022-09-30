<?php

namespace App\Http\Controllers;

use App\Imports\ProfesoresColegioImport;
use App\Imports\ProfesoresUniversidadImport;
use App\Models\Log;
use App\Models\profesores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = profesores::all();
        return view('profesores.index', ['profesores' => $profesores]);
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
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function show(profesores $profesores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function edit(profesores $profesores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, profesores $profesores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function destroy(profesores $profesores)
    {
        //
    }

    public function importProfesoresColegio() 
    {
        $Userid = Auth::user()->id;

        profesores::where('empresa', 'Colegio')->delete();
        
        Excel::import(new ProfesoresColegioImport,request()->file('file'));

        $Log = new Log;
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Importo profesores de Colegios';
        $Log->save();

        return back()->with('mensageimport', 'ok');
    }

    public function importProfesoresUniversidad() 
    {
        $Userid = Auth::user()->id;

        profesores::where('empresa', 'Universidad')->delete();

        Excel::import(new ProfesoresUniversidadImport,request()->file('file'));

        $Log = new Log;
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Importo profesores de Univesidades';
        $Log->save();
        
        return back()->with('mensageimport', 'ok');

    }
}
