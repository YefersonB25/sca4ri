<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //* ASIGNACIONDE PERMISOS *//
    public function run()
    {
        $Role1 = Role::create(['name' => 'SuperAdmin']);
        $Role2 = Role::create(['name' => 'Administrador']);
        $Role3 = Role::create(['name' => 'Profesor']);
        $Role4 = Role::create(['name' => 'Decano']);
        $Role5 = Role::create(['name' => 'Estudiante']);
        $Role6 = Role::create(['name' => 'Monitor universitario']);

        /** PROFESORES */
        Permission::create(['name' => 'profesores.index'])->syncRoles([$Role1]);
        /** FIN */

        /** USUARIOS */
        Permission::create(['name' => 'usuarios.index'])->syncRoles([$Role1]);
        /** FIN */

        /** COLEGIOS */
        Permission::create(['name' => 'colegios.index'])->syncRoles([$Role1, $Role4]);
        /** FIN */

        /** UNIVERSIDADES */
        Permission::create(['name' => 'universidades.index'])->syncRoles([$Role1, $Role4]);
        /** FIN */

        /** ESTUDIANTES ASIGNADOS */
        Permission::create(['name' => 'estudiantes.asignados'])->syncRoles([$Role1, $Role2]);
        /** FIN */

        /** UNIVERSITARIOS ASIGNADOS */
        Permission::create(['name' => 'universitarios.asignados'])->syncRoles([$Role1, $Role2]);
        /** FIN */

        /** OBJETIVOS */
        Permission::create(['name' => 'objetivos.index'])->syncRoles([$Role1]);
        /** FIN */

        /** SEMILLEROS */
        Permission::create(['name' => 'semilleros.index'])->syncRoles([$Role1, $Role2, $Role3, $Role5, $Role6]);
        /** FIN */

        /** AVANCE */
        Permission::create(['name' => 'avances.index'])->syncRoles([$Role1, $Role3, $Role5]);
        /** FIN */

    }
//* FIN *//
}
