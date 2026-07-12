<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string|array $roles): bool
    {
        $roleNames = array_map('strval', (array) $roles);
        $roleName = optional($this->role)->nom;

        if ($roleName === null) {
            return false;
        }

        if ($roleName === 'Administrateur') {
            return true;
        }

        return in_array($roleName, $roleNames, true);
    }

    public function canAccessModule(string $module): bool
    {
        if ($this->hasRole('Administrateur')) {
            return true;
        }

        return match ($module) {
            'users', 'roles' => $this->hasRole(['Responsable RH']),
            'employes', 'contract-types', 'employee-statuses', 'employee-family-infos', 'employee-dependents', 'employee-position-history', 'employee-history-logs' => $this->hasRole(['Chef du personnel', 'Responsable RH']),
            'missions' => $this->hasRole(['Chef du personnel', 'Charge de mission', 'Responsable RH']),
            'formations', 'competences', 'stagiaires' => $this->hasRole(['Charge de formation', 'Responsable RH']),
            'presences', 'paie' => $this->hasRole(['Comptable', 'Responsable RH']),
            'personnel-tasks', 'evaluations' => $this->hasRole(['Chef de service', 'Directeur', 'Responsable RH']),
            'reports' => $this->hasRole(['Directeur', 'Responsable RH']),
            default => true,
        };
    }

    public function canManageEvaluations(): bool
    {
        return $this->hasRole(['Administrateur', 'Responsable RH', 'Chef de service', 'Directeur']);
    }
}
