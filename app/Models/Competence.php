<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competence extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'categorie',
        'statut',
    ];

    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class, 'formation_competences');
    }

    public function employes(): BelongsToMany
    {
        return $this->belongsToMany(Employe::class, 'employe_competences');
    }
}
