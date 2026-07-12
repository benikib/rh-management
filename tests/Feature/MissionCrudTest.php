<?php

use App\Models\Departement;
use App\Models\Employe;
use App\Models\Mission;
use App\Models\Poste;
use App\Models\Role;
use App\Models\User;

it('creates a mission for an employee', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $departement = Departement::create(['nom' => 'Ressources humaines']);
    $poste = Poste::create(['titre' => 'Analyste RH', 'description' => 'Test']);
    $employe = Employe::create([
        'departement_id' => $departement->id,
        'poste_id' => $poste->id,
        'matricule' => 'EMP-001',
        'nom' => 'Dupont',
        'postnom' => 'Jean',
        'prenom' => 'Paul',
        'sexe' => 'Masculin',
        'email' => 'paul@example.com',
        'date_embauche' => now()->toDateString(),
        'salaire_base' => 1000,
        'statut' => 'Actif',
    ]);

    $this->actingAs($user)
        ->post(route('missions.store'), [
            'employe_id' => $employe->id,
            'title' => 'Mission de terrain',
            'description' => 'Visite de service',
            'lieu' => 'Lubumbashi',
            'motif' => 'Audit',
            'date_debut' => now()->toDateString(),
            'date_fin' => now()->addDay()->toDateString(),
            'frais_montant' => 150,
            'statut' => 'planifiee',
        ])
        ->assertRedirect(route('missions.index'));

    expect(Mission::where('employe_id', $employe->id)->exists())->toBeTrue();
});
