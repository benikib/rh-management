<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poste extends Model
{
    protected $fillable = ['titre', 'description', 'salaire_reference'];

    protected function casts(): array
    {
        return [
            'salaire_reference' => 'decimal:2',
        ];
    }

    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);
    }
}
