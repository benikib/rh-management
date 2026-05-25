<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direction extends Model
{
    protected $fillable = ['nom', 'description'];

    public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }
}
