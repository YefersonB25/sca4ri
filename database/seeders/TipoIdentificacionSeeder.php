<?php

namespace Database\Seeders;

use App\Models\tipo_documento;
use Illuminate\Database\Seeder;

class TipoIdentificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tipo_documento::create([
            'tipodoc_nombre' => 'Cedula de ciudadania',
        ]);
    }
}
