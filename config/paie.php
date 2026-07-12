<?php

return [
    // Calculation mode: 'pro_rata' (by days present) or 'hours' (by total worked hours)
    'calculation_method' => env('PAIE_CALCULATION_METHOD', 'pro_rata'),

    // Number of working days per month used for pro-rata calculations
    'jours_travail_par_mois' => env('PAIE_JOURS_TRAVAIL_PAR_MOIS', 22),

    // Standard working hours per day
    'heures_par_jour' => env('PAIE_HEURES_PAR_JOUR', 8),

    // Overtime multiplier applied to overtime hours (1.5 = 50% extra)
    'overtime_multiplier' => env('PAIE_OVERTIME_MULTIPLIER', 1.5),
];
