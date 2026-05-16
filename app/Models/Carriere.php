<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carriere extends Model
{
    protected $fillable = [
        'employe_id',
        'ancien_poste_id',
        'nouveau_poste_id',
        'type_mouvement',
        'date_changement',
        'commentaire',
    ];

    protected function casts(): array
    {
        return [
            'date_changement' => 'date',
        ];
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function ancienPoste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'ancien_poste_id');
    }

    public function nouveauPoste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'nouveau_poste_id');
    }
}
