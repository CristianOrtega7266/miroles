<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash; 
use App\Models\User; // Ensure the User model is included

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing roles and permissions
        Role::truncate();
        Permission::truncate();

        // Create roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $docenteRole = Role::create(['name' => 'Docente']);
        $directorRole = Role::create(['name' => 'Director']);

        // Create permissions
        $permissions = [
            'add materias',
            'edit materias',
            'delete materias',
            'view materias',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions); // The admin has all permissions
        $docenteRole->givePermissionTo(['view materias']); // Docente can only view materias
        $directorRole->givePermissionTo(['view materias', 'edit materias']); // Director can view and edit materias

        // Create the Admin user and assign the Administrador role
        $adminUser = User::create([
            'name' => 'Admin', // User's name
            'email' => 'danielni.luna@umariana.edu.co', // User's email
            'password' => Hash::make('12345678'), // Encrypted password
        ]);

        // Assign the Administrador role to the created user
        $adminUser->assignRole($adminRole);
    }
}
