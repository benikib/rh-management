<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    protected $fillable = ['nom', 'description', 'direction_id'];

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);
    }
}
