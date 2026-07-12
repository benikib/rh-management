<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mission extends Model
{
    protected $fillable = [
        'employe_id',
        'title',
        'description',
        'lieu',
        'motif',
        'date_debut',
        'date_fin',
        'frais_montant',
        'statut',
        'observations',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'frais_montant' => 'decimal:2',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
