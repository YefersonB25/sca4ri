<?php

namespace App\Imports;

use App\Models\universitarios;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

// use Maatwebsite\Excel\Concerns\mergeCell;

class UniversitariosImport implements ToCollection, WithHeadingRow, WithChunkReading
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
            /** IMPORT universitarios */
            if(!in_array($row['uni_numerodoc'], $this->DNI))
            {
                array_push($this->DNI, $row['uni_numerodoc']);
                $sede = DB::table('universidad_sedes')->select('id')->where('sede_codigo', '=', $row['sede_codigo'])->get();

                $carrera = DB::table('universidad_carreras')
                ->select('id')
                ->where([
                    ['carrera_sedeid', '=', $sede[0]->id],
                    ['carrera_nombre', '=', $row['carrera_nombre']]
                ])->get();

                $semestreID = DB::table('universidad_semestres')
                ->select('id')
                ->where([
                    ['semestre_carreraid', '=', $carrera[0]->id],
                    ['semestre_nombre', '=', $row['semestre_nombre']]
                ])->get();

                universitarios::create([
                    'uni_nombre_1' => $row['uni_nombre_1'],
                    'uni_nombre_2' => $row['uni_nombre_2'],
                    'uni_apellido_1' => $row['uni_apellido_1'],
                    'uni_apellido_2' => $row['uni_apellido_2'],
                    'uni_numerodoc' => $row['uni_numerodoc'],
                    'uni_tipodoc' => $row['uni_tipodoc'],
                    'uni_carreraid' => $carrera[0]->id,
                    'uni_semestreid' => $semestreID[0]->id
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
