<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCritere extends Model
{
    protected $fillable = [
        'evaluation_id',
        'critere_id',
        'note',
        'observation'
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function critere()
    {
        return $this->belongsTo(Critere::class);
    }
}