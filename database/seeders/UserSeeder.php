<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // CREACIÓN DE PERMISOS DEL SISTEMA ELECTORAL
        // ============================================
        
        // Permisos de gestión de usuarios
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Permisos de gestión de perfiles
        Permission::create(['name' => 'ver perfiles']);
        Permission::create(['name' => 'crear perfiles']);
        Permission::create(['name' => 'editar perfiles']);

        // Permisos específicos del sistema electoral
        Permission::create(['name' => 'crear alcaldes']);
        Permission::create(['name' => 'crear concejales']);
        Permission::create(['name' => 'crear lideres']);
        Permission::create(['name' => 'ingresar votantes']);
        Permission::create(['name' => 'ver votantes del alcalde']);
        Permission::create(['name' => 'ver votantes del concejal']);
        Permission::create(['name' => 'ver todo dashboard']);
        Permission::create(['name' => 'ver logs sistema']);
        Permission::create(['name' => 'administrar sistema']);

        // ============================================
        // CREACIÓN DE ROLES Y ASIGNACIÓN DE PERMISOS
        // ============================================

        // 🟩 SUPER ADMIN - Control total del sistema
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $roleSuperAdmin->syncPermissions([
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver perfiles',
            'crear perfiles',
            'editar perfiles',
            'crear alcaldes',
            'ver todo dashboard',
            'ver logs sistema',
            'administrar sistema'
        ]);

        // 🟨 ASPIRANTE A LA ALCALDÍA - Control sobre concejales y votantes directos
        $roleAlcalde = Role::create(['name' => 'aspirante-alcaldia']);
        $roleAlcalde->syncPermissions([
            'crear concejales',
            'ver votantes del alcalde',
            'ingresar votantes',
            'ver perfiles',
            'editar perfiles'
        ]);

        // 🟧 ASPIRANTE AL CONCEJO - Control sobre líderes y sus votantes
        $roleConcejal = Role::create(['name' => 'aspirante-concejo']);
        $roleConcejal->syncPermissions([
            'crear lideres',
            'ver votantes del concejal',
            'ver perfiles',
            'editar perfiles'
        ]);

        // 🟦 LÍDER - Registra votantes bajo su concejal
        $roleLider = Role::create(['name' => 'lider']);
        $roleLider->syncPermissions([
            'ingresar votantes',
            'ver perfiles',
            'editar perfiles'
        ]);

        // 🔒 VOTANTE - No es necesario, solo es un dato registrado

        // ============================================
        // CREACIÓN DE USUARIO SUPER ADMIN INICIAL
        // ============================================
        
        $adminUser = User::create([
            'name' => 'Super Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'email_verified_at' => now(),
        ]);

        // Asignar rol de super admin al usuario inicial
        $adminUser->assignRole($roleSuperAdmin);

        // ============================================
        // USUARIOS DE PRUEBA PARA CADA ROL
        // ============================================
        
        // Usuario Alcalde de prueba
        $alcaldeUser = User::create([
            'name' => 'Candidato Alcalde',
            'email' => 'alcalde@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $alcaldeUser->assignRole($roleAlcalde);

        // Usuario Concejal de prueba
        $concejalUser = User::create([
            'name' => 'Candidato Concejal',
            'email' => 'concejal@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $concejalUser->assignRole($roleConcejal);

        // Usuario Líder de prueba
        $liderUser = User::create([
            'name' => 'Líder Comunitario',
            'email' => 'lider@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $liderUser->assignRole($roleLider);

        // Usuario Votante de prueba
        $votanteUser = User::create([
            'name' => 'Votante Ejemplo',
            'email' => 'votante@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
       

        // ============================================
        // INFORMACIÓN DE ROLES Y PERMISOS
        // ============================================
        
        $this->command->info('=== SISTEMA ELECTORAL INICIALIZADO ===');
        $this->command->info('Roles creados:');
        $this->command->info('- Super Admin (administración total)');
        $this->command->info('- Aspirante Alcaldía (gestiona concejales y votantes)');
        $this->command->info('- Aspirante Concejo (gestiona líderes y sus votantes)');
        $this->command->info('- Líder (registra votantes como datos)');
        $this->command->info('');
        $this->command->info('Usuarios de prueba creados:');
        $this->command->info('- admin@admin.com (Super Admin)');
        $this->command->info('- alcalde@test.com (Aspirante Alcaldía)');
        $this->command->info('- concejal@test.com (Aspirante Concejo)');
        $this->command->info('- lider@test.com (Líder)');
        $this->command->info('Contraseña: admin (Super Admin) / password (otros)');
    }
}