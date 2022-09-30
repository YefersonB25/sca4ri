<?php

namespace App\Imports;

use App\Models\universidad_semestres;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniversidadSemestresImport implements ToCollection, WithHeadingRow
{
    protected $semestreCarrera = array();
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            $semestreCarreraNombre = "{$row['uni_codigo']} {$row['sede_codigo']} {$row['carrera_nombre']} {$row['semestre_nombre']}";
            if(!in_array($semestreCarreraNombre, $this->semestreCarrera))
            {
                array_push($this->semestreCarrera, $semestreCarreraNombre);
                $carreraSedeId = DB::table('universidad_sedes')
                ->select('id')->where('sede_codigo', '=', $row['sede_codigo'])
                ->get();

                $carreraId = DB::table('universidad_carreras')
                ->select('id')
                ->where([
                    ['carrera_sedeid', '=', $carreraSedeId[0]->id],
                    ['carrera_nombre', '=', $row['carrera_nombre']]
                ])
                ->get()[0]->id;

                universidad_semestres::create([
                    'semestre_carreraid' => $carreraId,
                    'semestre_nombre' => $row['semestre_nombre']
                ]);
            }
        }
    }
}
