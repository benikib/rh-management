<?php

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Poste;
use App\Models\Role;
use App\Models\User;
use App\Models\EmployeePositionHistory;

it('creates an employee position history record', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'positionadmin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $direction = Direction::create(['nom' => 'Direction RH']);
    $departement = Departement::create(['nom' => 'Ressources humaines', 'direction_id' => $direction->id]);
    $poste = Poste::create(['titre' => 'Analyste RH', 'description' => 'Test']);
    $employe = Employe::create([
        'departement_id' => $departement->id,
        'poste_id' => $poste->id,
        'matricule' => 'EMP-012',
        'nom' => 'Banza',
        'postnom' => 'Jean',
        'prenom' => 'Claire',
        'sexe' => 'Feminin',
        'email' => 'claire@example.com',
        'date_embauche' => now()->toDateString(),
        'salaire_base' => 1400,
        'statut' => 'Actif',
    ]);

    $this->actingAs($user)
        ->post(route('employee-position-history.store'), [
            'employe_id' => $employe->id,
            'poste_id' => $poste->id,
            'departement_id' => $departement->id,
            'status' => 'active',
            'start_date' => now()->subMonths(6)->toDateString(),
            'end_date' => now()->addMonths(6)->toDateString(),
            'supervisor_name' => 'Manager RH',
            'observations' => 'Aucune remarque',
        ])
        ->assertRedirect(route('employee-position-history.index'));

    expect(EmployeePositionHistory::where('employe_id', $employe->id)->exists())->toBeTrue();
});
