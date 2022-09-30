<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\colegio_cursos;
use Illuminate\Support\Facades\DB;

class CursoGradoImport implements ToCollection, WithHeadingRow
{
    protected $sede_curso = array();

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            /** IMPORT CURSOS */
            $nombreSedeCurso = "{$row['sede_codigo']} - {$row['curso_nombre']}";
        
            if(!in_array($nombreSedeCurso, $this->sede_curso))
            {
                $cursoSedeId = array();
                array_push($this->sede_curso, $nombreSedeCurso);
                $cursoSedeId = DB::table('colegio_sedes')->select('id')->where('sede_codigo', '=', $row['sede_codigo'])->get();                    

                colegio_cursos::create([
                    'curso_sedeid' => $cursoSedeId[0]->id,
                    'curso_nombre' => $row['curso_nombre'],
                ]);
            }
            /** FIN */
        }
    }
}
