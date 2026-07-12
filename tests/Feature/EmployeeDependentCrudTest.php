<?php

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Poste;
use App\Models\Role;
use App\Models\User;
use App\Models\EmployeeDependent;

it('creates an employee dependent record', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'dependentadmin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $direction = Direction::create(['nom' => 'Direction RH']);
    $departement = Departement::create(['nom' => 'Ressources humaines', 'direction_id' => $direction->id]);
    $poste = Poste::create(['titre' => 'Analyste RH', 'description' => 'Test']);
    $employe = Employe::create([
        'departement_id' => $departement->id,
        'poste_id' => $poste->id,
        'matricule' => 'EMP-011',
        'nom' => 'Mwana',
        'postnom' => 'Jean',
        'prenom' => 'Lucie',
        'sexe' => 'Feminin',
        'email' => 'lucie@example.com',
        'date_embauche' => now()->toDateString(),
        'salaire_base' => 1250,
        'statut' => 'Actif',
    ]);

    $this->actingAs($user)
        ->post(route('employee-dependents.store'), [
            'employe_id' => $employe->id,
            'full_name' => 'Julie Mwana',
            'type' => 'child',
            'birth_date' => now()->subYears(10)->toDateString(),
            'identity_number' => 'ID-789',
            'is_student' => 1,
            'is_schooled' => 1,
        ])
        ->assertRedirect(route('employee-dependents.index'));

    expect(EmployeeDependent::where('employe_id', $employe->id)->exists())->toBeTrue();
});
