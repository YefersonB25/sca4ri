<?php

namespace App\Imports;

use App\Models\colegio_sedes;
use App\Models\colegios;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ColegioImport implements ToCollection, WithHeadingRow/**, WithChunkReading*/
{
    protected $col_dane_colegios = array();
    protected $sede_dane = array();
    protected $sede_curso = array();

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        /** 
         * @param array $col_dane_colegios: variable que almacena los codigo dane de cada colegio.
         */

        /**
         * recorremos todas las filas del archivo excel
         */
        foreach ($rows as $row) 
        {
            /** IMPORT COLEGIOS */
            /**
             * validamos que el codigo dane no exista en la variable $col_dane_colegios
             * para evitar insertar datos duplicados en la tabla
             */
            if(!in_array($row['col_dane_colegio'], $this->col_dane_colegios))
            {
                /**
                 * sino existe lo almacenamos el codigo dane del colegio en el array $col_dane_colegios
                 */
                array_push($this->col_dane_colegios, $row['col_dane_colegio']);

                /**
                 * Guardamos los datos en la tabla 
                 */
                colegios::create([
                    'col_dane_colegio' => $row['col_dane_colegio'],
                    'col_nombre' => $row['col_nombre'],
                ]);
            }
            /** FIN */

            /** IMPORT SEDES */
            if(!in_array($row['sede_codigo'], $this->sede_dane))
            {
                array_push($this->sede_dane, $row['sede_codigo']);
                $idColegio = DB::table('colegios')->select('id')->where('col_dane_colegio', '=', $row['col_dane_colegio'])->get()[0]->id;
                colegio_sedes::create([
                    'sede_danecolegio' => $idColegio,
                    'sede_codigo' => $row['sede_codigo'],
                    'sede_nombre' => $row['sede_nombre'],
                ]);
            }
            /** FIN */
        }
    }
}
