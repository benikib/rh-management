<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('nom', 'Administrateur')->first();
        $rhRole = Role::where('nom', 'Responsable RH')->first();

        User::updateOrCreate(
            ['email' => 'admin@rh-management.com'],
            [
                'name' => 'Administrateur Système',
                'role_id' => $adminRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'rh@rh-management.com'],
            [
                'name' => 'Marie Kabila',
                'role_id' => $rhRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@rh-management.com'],
            [
                'name' => 'Jean Mukendi',
                'role_id' => Role::where('nom', 'Manager')->first()->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
    }
}
