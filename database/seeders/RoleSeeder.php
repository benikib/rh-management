<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Administrateur',
            'Responsable RH',
            'Manager',
            'Chef du personnel',
            'Charge de mission',
            'Charge de formation',
            'Comptable',
            'Comptable (Service Paie)',
            'Chef de service',
            'Directeur',
            'Employé',
        ];

        foreach ($roles as $nom) {
            Role::firstOrCreate(['nom' => $nom]);
        }
    }
}
