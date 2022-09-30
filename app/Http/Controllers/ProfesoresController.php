<?php

namespace App\Http\Controllers;

use App\Imports\ProfesoresColegioImport;
use App\Imports\ProfesoresUniversidadImport;
use App\Models\colegios;
use App\Models\Log;
use App\Models\profesores;
use App\Models\tipo_documento;
use App\Models\universidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $roles = Role::where('id', 3)->get();
        $colegios = colegios::all();
        $universidades = universidades::all();
        $profesores = profesores::all();
        
        return view('profesores.index', ['profesores' => $profesores,'colegios' => $colegios, 'universidades' => $universidades]);
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
        $Userid = Auth::user()->id;

        $pro = new profesores();
        
        $pro->profe_nombre       =$request->get('name');
        $pro->profe_numerodoc    =$request->get('numdoc');
        $pro->empresa            =$request->get('empresa');
        $pro->dane_empresa       =$request->get('dane_empresa');

        
        
        // return response()->json($pro);
        $pro->save();
        
        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Creó un profesor con # identificación :' . $pro->profe_numerodoc;
        $Log->save();

        return redirect()->back()->with('new', 'ok');
    }

    public function apiProfesorEmpresa(Request $request)
    {
        Validator::make($request->all(), [
            'empresa' => ['required']
        ])->validate();

        $profesor = profesores::findOrFail('empresa', $request->empresa);

        return response()->json(['profesores' => $profesor], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function edit(profesores $profesores, $id)
    {
        $profesor = profesores::findOrFail($id); 
        $colegios = colegios::all();
        $universidades = universidades::all();
            // return response()->json($profesor);
        return view('profesores.edit',[           
            'profesor'      => $profesor,
            'colegios'        => $colegios,
            'universidades'   => $universidades
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, profesores $profesores, $id)
    {
        $Userid = Auth::user()->id;
        
        Validator::make($request->all(), [
            'numdoc' => ['required', 'min:6', 'max:12'],
            'name' => ['required'],
            'empresa' => ['required'],
        ])->validate();

        $profesores  = profesores::findOrFail($id);
        
        $profesores->profe_nombre       =   $request->get('name');
        $profesores->profe_numerodoc    =   $request->get('numdoc');

        $profesores->save();

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = 'Editó un Profesor';
        $Log->save();

        $profesores = profesores::all();
        return redirect()->back()->with('mensajedit', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    
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

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()){

            $Userid = Auth::user()->id;

            $profesores = profesores::findOrFail($id);

            if ($profesores){

                $profesores->delete();

                $Log = new Log();
                $Log->usuario_id = $Userid;
                $Log->Accion = 'Eliminó el profesor ' . $profesores->profe_nombre;
                $Log->save();

                return response()->json(array('success' => true));
            }

        }
    }
}
