<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaieSetting extends Model
{
    protected $fillable = [
        'calculation_method',
        'jours_travail_par_mois',
        'heures_par_jour',
        'overtime_multiplier',
    ];

    protected $casts = [
        'jours_travail_par_mois' => 'integer',
        'heures_par_jour' => 'integer',
        'overtime_multiplier' => 'decimal:2',
    ];
}
