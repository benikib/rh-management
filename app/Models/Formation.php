<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Formation extends Model
{
    protected $fillable = [
        'employe_id',
        'titre',
        'description',
        'organisme_formation',
        'date_debut',
        'date_fin',
        'duree_heures',
        'certificat',
        'cout',
        'observations',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'duree_heures' => 'integer',
            'cout' => 'decimal:2',
        ];
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function competences(): BelongsToMany
    {
        return $this->belongsToMany(Competence::class, 'formation_competences');
    }
}
