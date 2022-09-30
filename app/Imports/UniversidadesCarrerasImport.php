<?php

namespace App\Imports;

use App\Models\universidad_carreras;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniversidadesCarrerasImport implements ToCollection, WithHeadingRow
{
    protected $carreraSede = array();

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            /** IMPORT Carreras */ 
            $daneSedeUniversidad = "{$row['sede_codigo']} - {$row['carrera_nombre']}";
            if(!in_array($daneSedeUniversidad, $this->carreraSede))
            {
                array_push($this->carreraSede, $daneSedeUniversidad);
                $carreraSedeId = DB::table('universidad_sedes')->select('id')->where('sede_codigo', '=', $row['sede_codigo'])->get();

                universidad_carreras::create([
                    'carrera_codigo' => null,
                    'carrera_nombre' => $row['carrera_nombre'],
                    'carrera_sedeid' => $carreraSedeId[0]->id,
                ]);
            }
            /** FIN */
        }
    }
}
