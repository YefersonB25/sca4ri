<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //** USUARIO ADMIN PREDETERMINADO */
    public function run()
    {
        User::create([
            'name' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123123'),
            'usuario_rolid' => 1
        ])->assignRole('SuperAdmin');

        // User::factory(9)->create();
    }
    //** FIN */
}
