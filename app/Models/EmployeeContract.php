<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeContract extends Model
{
    protected $table = 'employee_contracts';
    
    protected $fillable = [
        'employe_id',
        'contract_type_id',
        'start_date',
        'end_date',
        'terms_conditions',
        'salary',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function contractType(): BelongsTo
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    public function getContractDurationDaysAttribute(): ?int
    {
        if ($this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }
        return null;
    }

    public function getRemainingDaysAttribute(): ?int
    {
        if ($this->end_date) {
            return now()->diffInDays($this->end_date, false);
        }
        return null;
    }
}
