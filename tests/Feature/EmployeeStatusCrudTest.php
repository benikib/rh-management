<?php

use App\Models\Role;
use App\Models\User;
use App\Models\EmployeeStatus;
use Illuminate\Support\Str;

it('creates an employee status', function () {
    $role = Role::create(['nom' => 'Admin']);
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin-status@example.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
    ]);

    $code = 'status-' . Str::random(6);
    $label = 'Statut ' . Str::random(6);

    $this->actingAs($user)
        ->post(route('employee-statuses.store'), [
            'code' => $code,
            'label' => $label,
            'description' => 'Employé actif',
        ])
        ->assertRedirect(route('employee-statuses.index'));

    expect(EmployeeStatus::where('code', $code)->exists())->toBeTrue();
});
