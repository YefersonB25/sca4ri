<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::all();
        $_logs = array();

        foreach ($logs as $log) {

            $nombreUsuario = User::where('id', $log->usuario_id)->get('name');
            $_log = array(
                'nombreUsuario' => $nombreUsuario[0]->name,
                'accion' => $log->Accion,
                'fecha' => $log->created_at
            );

            array_push($_logs, $_log);
        }

        return view('log.log', ['logs' => $_logs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create($mensaje)
    {
        $Userid = Auth::user()->id;

        $Log = new Log();
        $Log->usuario_id = $Userid;
        $Log->Accion = $mensaje;
        $Log->save();
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
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}
