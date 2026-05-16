<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employe extends Model
{
    protected $fillable = [
        'departement_id',
        'poste_id',
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

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom} {$this->postnom}";
    }
}
