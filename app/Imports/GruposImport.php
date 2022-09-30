<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\colegio_grupos;

class GruposImport implements ToCollection, WithHeadingRow
{
    protected $gruposSede = array();

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            /** IMPORT GRUPOS */ 
            $daneSedeGrupo = "{$row['sede_codigo']} - {$row['grupo_nombre']}";
            if(!in_array($daneSedeGrupo, $this->gruposSede))
            {
                array_push($this->gruposSede, $daneSedeGrupo);
                switch (strlen($row['grupo_nombre'])) 
                {
                    case 4:
                        $curso = str_split($row['grupo_nombre'], 2)[0];
                        break;
                    case 3:
                        $curso = explode('0', $row['grupo_nombre'])[0];
                        break;
                    
                    case 1:
                        $curso = '0';
                        break;
                }

                $cursoSedeId = DB::table('colegio_sedes')->select('id')->where('sede_codigo', '=', $row['sede_codigo'])->get();

                $cursoId = DB::table('colegio_cursos')
                ->select('id')
                ->where([
                    ['curso_sedeid', '=', $cursoSedeId[0]->id],
                    ['curso_nombre', '=', $curso]
                ])
                ->get()[0]->id;

                colegio_grupos::create([
                    'sede_codigo' => $cursoSedeId[0]->id,
                    'grupo_nombre' => $row['grupo_nombre'],
                    'grupo_jornada' => $row['grupo_jornada'],
                    'grupo_cursoid' => $cursoId,
                ]);
            }
            /** FIN */
        }
    }
}
