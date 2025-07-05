<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar el seeder del sistema electoral
        $this->call([
            UserSeeder::class,
        ]);
        
        $this->command->info('🗳️  Sistema Electoral inicializado correctamente');
        $this->command->info('📊 Base de datos poblada con roles, permisos y usuarios de prueba');
        $this->command->info('ℹ️  Los votantes son solo datos registrados, no usuarios del sistema');
    }
}