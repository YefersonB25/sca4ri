<?php

namespace App\Imports;

use App\Models\profesores;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProfesoresColegioImport implements ToCollection, WithHeadingRow
{
    protected $DNI = array();
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            /** IMPORT PROFESORES */
            if(!in_array($row['profe_numerodoc'], $this->DNI))
            {
                array_push($this->DNI, $row['profe_numerodoc']);
                
                profesores::create([
                    'profe_nombre' => "{$row['profe_nombre_1']}  {$row['profe_apellido_1']}",
                    'dane_empresa' => $row['dane_empresa'],
                    'profe_numerodoc' => $row['profe_numerodoc'],
                    // 'profe_tipodoc' => $row['profe_tipodoc'],
                    'empresa' => 1
                ]);
            }
            /** FIN */
        }
    }
}
