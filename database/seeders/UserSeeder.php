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
        'rol' => 'super-admin',
    ],
];

        foreach ($usuarios as $data) {
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
    ]);

    $user->assignRole($data['rol']);
}
    }
}
