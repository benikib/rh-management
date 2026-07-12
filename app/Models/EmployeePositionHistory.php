<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePositionHistory extends Model
{
    protected $table = 'employee_position_history';
    
    protected $fillable = [
        'employe_id',
        'poste_id',
        'departement_id',
        'start_date',
        'end_date',
        'observations',
        'supervisor_name',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class);
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function getDurationDaysAttribute(): int
    {
        $endDate = $this->end_date ?? now();
        return $this->start_date->diffInDays($endDate);
    }
}
