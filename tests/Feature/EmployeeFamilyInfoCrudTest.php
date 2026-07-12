<?php

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\MaritalStatus;
use App\Models\Poste;
use App\Models\Role;
use App\Models\User;
use App\Models\EmployeeFamilyInfo;
use Illuminate\Support\Str;

it('creates an employee family info record', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'familyadmin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $direction = Direction::create(['nom' => 'Direction RH']);
    $departement = Departement::create(['nom' => 'Ressources humaines', 'direction_id' => $direction->id]);
    $poste = Poste::create(['titre' => 'Analyste RH', 'description' => 'Test']);
    $employe = Employe::create([
        'departement_id' => $departement->id,
        'poste_id' => $poste->id,
        'matricule' => 'EMP-010',
        'nom' => 'Kongo',
        'postnom' => 'Jean',
        'prenom' => 'Marie',
        'sexe' => 'Feminin',
        'email' => 'marie@example.com',
        'date_embauche' => now()->toDateString(),
        'salaire_base' => 1300,
        'statut' => 'Actif',
    ]);
    $maritalStatus = MaritalStatus::create([
        'code' => 'marie-' . Str::random(6),
        'label' => 'Marié ' . Str::random(6),
    ]);

    $this->actingAs($user)
        ->post(route('employee-family-infos.store'), [
            'employe_id' => $employe->id,
            'marital_status_id' => $maritalStatus->id,
            'spouse_name' => 'Jean-Pierre',
            'spouse_identity' => 'AB123456',
            'marriage_date' => now()->subYears(2)->toDateString(),
            'number_of_children' => 2,
        ])
        ->assertRedirect(route('employee-family-infos.index'));

    expect(EmployeeFamilyInfo::where('employe_id', $employe->id)->exists())->toBeTrue();
});
