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
        $personnelRole = Role::where('nom', 'Chef du personnel')->first();
        $missionRole = Role::where('nom', 'Charge de mission')->first();
        $formationRole = Role::where('nom', 'Charge de formation')->first();
        $accountantRole = Role::where('nom', 'Comptable')->first();
        $serviceRole = Role::where('nom', 'Chef de service')->first();
        $directorRole = Role::where('nom', 'Directeur')->first();

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

        User::updateOrCreate(
            ['email' => 'comptable@rh-management.com'],
            [
                'name' => 'Alice Comptable',
                'role_id' => $accountantRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'chef-personnel@rh-management.com'],
            [
                'name' => 'Paul Chef Personnel',
                'role_id' => $personnelRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'charge-mission@rh-management.com'],
            [
                'name' => 'Nadia Mission',
                'role_id' => $missionRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'charge-formation@rh-management.com'],
            [
                'name' => 'Samuel Formation',
                'role_id' => $formationRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'chef-service@rh-management.com'],
            [
                'name' => 'Clément Chef Service',
                'role_id' => $serviceRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'directeur@rh-management.com'],
            [
                'name' => 'David Directeur',
                'role_id' => $directorRole->id,
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
    }
}
