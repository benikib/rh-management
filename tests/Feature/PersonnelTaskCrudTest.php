<?php

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\PersonnelTask;
use App\Models\Poste;
use App\Models\Role;
use App\Models\User;

it('creates a personnel task', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'taskadmin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $direction = Direction::create(['nom' => 'Direction RH']);
    $departement = Departement::create(['nom' => 'Ressources humaines', 'direction_id' => $direction->id]);
    $poste = Poste::create(['titre' => 'Analyste RH', 'description' => 'Test']);
    $employe = Employe::create([
        'departement_id' => $departement->id,
        'poste_id' => $poste->id,
        'matricule' => 'EMP-002',
        'nom' => 'Mwana',
        'postnom' => 'Jean',
        'prenom' => 'Alice',
        'sexe' => 'Feminin',
        'email' => 'alice@example.com',
        'date_embauche' => now()->toDateString(),
        'salaire_base' => 1200,
        'statut' => 'Actif',
    ]);

    $this->actingAs($user)
        ->post(route('personnel-tasks.store'), [
            'direction_id' => $direction->id,
            'departement_id' => $departement->id,
            'assigned_by_id' => $user->id,
            'assigned_to_id' => $employe->id,
            'title' => 'Préparer un rapport',
            'description' => 'Faire le rapport mensuel',
            'priority' => 'high',
            'status' => 'pending',
            'due_date' => now()->addWeek()->toDateString(),
        ])
        ->assertRedirect(route('personnel-tasks.index'));

    expect(PersonnelTask::where('assigned_to_id', $employe->id)->exists())->toBeTrue();
});
