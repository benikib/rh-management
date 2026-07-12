<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stagiaire extends Model
{
    protected $fillable = [
        'departement_id',
        'nom',
        'postnom',
        'prenom',
        'sexe',
        'date_naissance',
        'telephone',
        'email',
        'adresse',
        'photo',
        'universite',
        'specialite',
        'date_debut_stage',
        'date_fin_stage',
        'encadrant_id',
        'observations',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
            'date_debut_stage' => 'date',
            'date_fin_stage' => 'date',
        ];
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'encadrant_id');
    }

    public function getNomCompletAttribute(): string
    {
        return trim("{$this->nom} {$this->postnom} {$this->prenom}");
    }
}
