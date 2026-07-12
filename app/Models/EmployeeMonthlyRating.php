<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeMonthlyRating extends Model
{
    protected $table = 'employee_monthly_ratings';
    
    protected $fillable = [
        'employe_id',
        'departement_id',
        'year',
        'month',
        'performance_score',
        'attendance_score',
        'productivity_score',
        'observations',
    ];

    protected $casts = [
        'performance_score' => 'decimal:2',
        'attendance_score' => 'decimal:2',
        'productivity_score' => 'decimal:2',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function getAverageScoreAttribute(): ?float
    {
        $scores = array_filter([
            $this->performance_score,
            $this->attendance_score,
            $this->productivity_score,
        ]);
        
        return count($scores) > 0 ? array_sum($scores) / count($scores) : null;
    }
}
