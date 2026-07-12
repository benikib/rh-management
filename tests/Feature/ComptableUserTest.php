<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;

it('creates a comptable role and allows authentication', function () {
    $this->seed([RoleSeeder::class, UserSeeder::class]);

    $role = Role::where('nom', 'Comptable')->first();
    $user = User::where('email', 'comptable@rh-management.com')->first();

    expect($role)->not->toBeNull();
    expect($user)->not->toBeNull();
    expect(Auth::attempt(['email' => $user->email, 'password' => 'password']))->toBeTrue();
});

it('grants module access according to the role profile', function () {
    $this->seed([RoleSeeder::class, UserSeeder::class]);

    $missionUser = User::where('email', 'charge-mission@rh-management.com')->first();
    $formationUser = User::where('email', 'charge-formation@rh-management.com')->first();
    $comptableUser = User::where('email', 'comptable@rh-management.com')->first();
    $directorUser = User::where('email', 'directeur@rh-management.com')->first();

    expect($missionUser->canAccessModule('missions'))->toBeTrue();
    expect($formationUser->canAccessModule('formations'))->toBeTrue();
    expect($comptableUser->canAccessModule('presences'))->toBeTrue();
    expect($directorUser->canAccessModule('reports'))->toBeTrue();
});
