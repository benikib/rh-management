<?php

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\EmployeeStatus;
use App\Models\Poste;
use App\Models\Role;
use App\Models\User;
use App\Models\EmployeeHistoryLog;
use Illuminate\Support\Str;

it('creates an employee history log', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'historyadmin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $direction = Direction::create(['nom' => 'Direction RH']);
    $departement = Departement::create(['nom' => 'Ressources humaines', 'direction_id' => $direction->id]);
    $poste = Poste::create(['titre' => 'Analyste RH', 'description' => 'Test']);
    $employe = Employe::create([
        'departement_id' => $departement->id,
        'poste_id' => $poste->id,
        'matricule' => 'EMP-013',
        'nom' => 'Mputu',
        'postnom' => 'Jean',
        'prenom' => 'Sofia',
        'sexe' => 'Feminin',
        'email' => 'sofia@example.com',
        'date_embauche' => now()->toDateString(),
        'salaire_base' => 1500,
        'statut' => 'Actif',
    ]);
    $status = EmployeeStatus::create([
        'code' => 'active-' . Str::random(6),
        'label' => 'Actif ' . Str::random(6),
    ]);

    $this->actingAs($user)
        ->post(route('employee-history-logs.store'), [
            'employe_id' => $employe->id,
            'event_type' => 'promoted',
            'event_date' => now()->toDateString(),
            'status_id' => $status->id,
            'reason' => 'Nouvelle promotion',
            'notes' => 'Promotion validée par la direction',
        ])
        ->assertRedirect(route('employee-history-logs.index'));

    expect(EmployeeHistoryLog::where('employe_id', $employe->id)->exists())->toBeTrue();
});
