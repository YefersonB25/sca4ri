<?php

namespace App\Imports;

use App\Models\estudiantes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

// use Maatwebsite\Excel\Concerns\mergeCell;

class EstudiantesImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $DNI = array();

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        set_time_limit(120);
        foreach ($rows as $row) 
        {
            /** IMPORT CURSOS */
            if(!in_array($row['est_numerodoc'], $this->DNI))
            {
                array_push($this->DNI, $row['est_numerodoc']);
                $sede = DB::table('colegio_sedes')
                ->select('id')
                ->where('sede_codigo', '=', $row['sede_codigo'])
                ->get();

                $grupoId = DB::table('colegio_grupos')
                ->select('id')
                ->where([
                    ['sede_codigo', '=', $sede[0]->id],
                    ['grupo_nombre', '=', $row['grupo_nombre']]
                ])->get();

                estudiantes::create([
                    'est_nombre_1' => $row['est_nombre_1'],
                    'est_nombre_2' => $row['est_nombre_2'],
                    'est_apellido_1' => $row['est_apellido_1'],
                    'est_apellido_2' => $row['est_apellido_2'],
                    'est_numerodoc' => $row['est_numerodoc'],
                    'est_tipodoc' => $row['est_tipodoc'],
                    'est_grupoid' => $grupoId[0]->id
                ]);
            }
            /** FIN */
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
