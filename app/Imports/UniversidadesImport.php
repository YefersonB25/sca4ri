<?php

namespace App\Imports;

use App\Models\universidad_sedes;
use App\Models\universidades;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniversidadesImport implements ToCollection, WithHeadingRow
{
    protected $uni_codigo = array();
    protected $sede_dane = array();
    protected $sede_curso = array();

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        /** 
         * @param array $uni_codigo: variable que almacena los codigo dane de cada universidad.
         */

        /**
         * recorremos todas las filas del archivo excel
         */
        foreach ($rows as $row) 
        {
            /** IMPORT UNIVERSIDADES */
            /**
             * validamos que el codigo dane no exista en la variable $uni_codigo
             * para evitar insertar datos duplicados en la tabla
             */
            if(!in_array($row['uni_codigo'], $this->uni_codigo))
            {
                /**
                 * sino existe lo almacenamos el codigo dane de la universidad en el array $uni_codigo
                 */
                array_push($this->uni_codigo, $row['uni_codigo']);

                /**
                 * Guardamos los datos en la tabla 
                 */
                universidades::create([
                    'uni_codigo' => $row['uni_codigo'],
                    'uni_nombre' => $row['uni_nombre'],
                ]);
            }
            /** FIN */

            /** IMPORT SEDES */
            if(!in_array($row['sede_codigo'], $this->sede_dane))
            {
                array_push($this->sede_dane, $row['sede_codigo']);
                $idUniversidad = DB::table('universidades')->select('id')->where('uni_codigo', '=', $row['uni_codigo'])->get()[0]->id;
                universidad_sedes::create([
                    'sede_universidadid' => $idUniversidad,
                    'sede_codigo' => $row['sede_codigo'],
                    'sede_nombre' => $row['sede_nombre'],
                ]);
            }
            /** FIN */
        }
    }
}
