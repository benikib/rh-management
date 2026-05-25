<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Critere extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'note_max',
        'ponderation'
    ];

    public function evaluationCriteres()
    {
        return $this->hasMany(EvaluationCritere::class);
    }
}