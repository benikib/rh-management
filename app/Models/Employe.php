<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employe extends Model
{
    protected $fillable = [
        'departement_id',
        'poste_id',
        'status_id',
        'matricule',
        'nom',
        'postnom',
        'prenom',
        'sexe',
        'date_naissance',
        'telephone',
        'email',
        'adresse',
        'photo',
        'date_embauche',
        'salaire_base',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
            'date_embauche' => 'date',
            'salaire_base' => 'decimal:2',
        ];
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class);
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }

    public function carrieres(): HasMany
    {
        return $this->hasMany(Carriere::class);
    }

    public function conges(): HasMany
    {
        return $this->hasMany(Conge::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class);
    }

    public function competences(): BelongsToMany
    {
        return $this->belongsToMany(Competence::class, 'employe_competences')
            ->withPivot('niveau', 'date_acquisition')
            ->withTimestamps();
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom} {$this->postnom}";
    }

    public function evaluations()
    {
        return $this->hasMany(
            Evaluation::class,
            'employe_matricule',
            'matricule'
        );
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(EmployeeContract::class);
    }

    public function familyInfo()
    {
        return $this->hasOne(EmployeeFamilyInfo::class);
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(EmployeeDependent::class);
    }

    public function monthlyRatings(): HasMany
    {
        return $this->hasMany(EmployeeMonthlyRating::class);
    }

    public function positionHistory(): HasMany
    {
        return $this->hasMany(EmployeePositionHistory::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(PersonnelTask::class, 'assigned_to_id');
    }

    public function historyLogs(): HasMany
    {
        return $this->hasMany(EmployeeHistoryLog::class);
    }

    public function employeeStatus(): BelongsTo
    {
        return $this->belongsTo(EmployeeStatus::class, 'statut', 'code');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(EmployeeStatus::class, 'status_id');
    }

    /**
     * Get active contract for employee
     */
    public function getActiveContractAttribute()
    {
        return $this->contracts()->where('is_active', true)->latest()->first();
    }

    /**
     * Calculate contract remaining days
     */
    public function getContractRemainingDaysAttribute(): ?int
    {
        $contract = $this->activeContract;
        if ($contract && $contract->end_date) {
            $days = now()->diffInDays($contract->end_date, false);
            return $days > 0 ? $days : null;
        }
        return null;
    }

    /**
     * Get employee status label
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->employeeStatus?->label ?? $this->statut ?? 'Actif';
    }
}
