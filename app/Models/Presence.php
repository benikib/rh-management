<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    protected $fillable = [
        'employe_id',
        'date_presence',
        'heure_arrivee',
        'heure_depart',
        'statut',
        'remarque',
    ];

    protected function casts(): array
    {
        return [
            'date_presence' => 'date',
        ];
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
