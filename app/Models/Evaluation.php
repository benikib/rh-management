<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'employe_matricule',
        'evaluateur_id',
        'date_evaluation',
        'note_totale',
        'commentaire'
    ];

    protected $casts = [
        'date_evaluation' => 'date'
    ];

    public function employe()
    {
        return $this->belongsTo(
            Employe::class,
            'employe_matricule',
            'matricule'
        );
    }

    public function criteres()
    {
        return $this->hasMany(EvaluationCritere::class);
    }
}