<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'administrador',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'id_rol' => 1, 
                'created_at' => now(),   
                'updated_at' => now(),    
            ],
            [
                'name' => 'vendedor',
                'email' => 'vendedor@gmail.com',
                'password' => bcrypt('12345678'),
                'id_rol' => 2,
                'created_at' => now(),
                'updated_at' => now(), 
            ],
        ]);

        DB::table('permisos')->insert([
            ['nombre' => 'Crear Usuario'],
            ['nombre' => 'Editar Usuario'],
            ['nombre' => 'Eliminar Usuario'],

            ['nombre' => 'Crear Cliente'],
            ['nombre' => 'Editar Cliente'],
            ['nombre' => 'Eliminar Cliente'],
        ]);

        DB::table('users_permisos')->insert([
            ['id_permisos' => 1, 'id_users' => 1],
            ['id_permisos' => 2, 'id_users' => 1],
            ['id_permisos' => 3, 'id_users' => 1],
            ['id_permisos' => 4, 'id_users' => 1],
            ['id_permisos' => 5, 'id_users' => 1],
            ['id_permisos' => 6, 'id_users' => 1],

            ['id_permisos' => 4, 'id_users' => 2],
            ['id_permisos' => 5, 'id_users' => 2],
            ['id_permisos' => 6, 'id_users' => 2],
        ]);

        DB::table('roles')->insert([
            ['nombre' => 'administrador'],
            ['nombre' => 'vendedor'],
        ]);
        
        for ($i=1; $i < 51; $i++) { 
            DB::table('clientes')->insert([
                ['documento' => $i, 'nombre' => 'cliente'.$i, 'correo' => 'cliente'.$i.'@gmail.com', 'direccion' => 'Calle'.$i],
            ]);
        }
        
    }
}
