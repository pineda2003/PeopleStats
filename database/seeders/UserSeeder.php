<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Super Administrador',
                'email' => 'luisguillermo@gmail.com',
                'password' => bcrypt('123456789'),
                'rol_id' => 1,
            ],
            
            
        ];

        foreach ($usuarios as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'rol_id' => $data['rol_id'], // este campo sigue existiendo en la tabla
            ]);

            if ($data['rol_id']) {
                $rol = Role::find($data['rol_id']);
                if ($rol) {
                    $user->assignRole($rol->name); // Asignar por nombre
                }
            }
        }
    }
}
