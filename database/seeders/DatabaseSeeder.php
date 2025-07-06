<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
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


    }
}