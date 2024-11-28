<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verificar si el usuario no existe
        $user = DB::table('users')->where('email', 'alison@gmail.com')->first();
        $rolePersonalVentas = DB::table('roles')->where('nombre', 'Rol_PersonalVentas')->first();

        if(!$rolePersonalVentas){
            $roleId = DB::table('roles')->insertGetId([
                'nombre' => 'Rol_PersonalVentas',
                'descripcion' => 'Personal para ventas',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!$user) {
            // Insertar usuario
            $userId = DB::table('users')->insertGetId([
                'name' => 'alison',
                'cedula' => '9877532',
                'celular' => '59176392938',
                'direccion' => 'Zona Norte',
                'email' => 'alison@gmail.com',
                'password' => Hash::make('admin'),
                'remember_token' => Str::random(10),
            ]);

            // Verificar si el rol "Gerente" existe
            $role = DB::table('roles')->where('nombre', 'Rol_Gerente')->first();

            if (!$role) {
                // Insertar el rol "Gerente"
                $roleId = DB::table('roles')->insertGetId([
                    'nombre' => 'Rol_Gerente',
                    'descripcion' => 'Maxima autoridad de la empresa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $roleId = $role->id;
            }

            // Insertar en la tabla pivot "rol_user"
            DB::table('role_user')->insert([
                'user_id' => $userId,
                'role_id' => $roleId,
            ]);
        }
    }
}
