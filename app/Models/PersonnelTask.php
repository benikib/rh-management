<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonnelTask extends Model
{
    protected $table = 'personnel_tasks';
    
    protected $fillable = [
        'direction_id',
        'departement_id',
        'assigned_by_id',
        'assigned_to_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'date',
    ];

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'assigned_to_id');
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'completed' && $this->due_date && now()->isAfter($this->due_date);
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        if ($this->due_date && $this->status !== 'completed') {
            return now()->diffInDays($this->due_date, false);
        }
        return null;
    }
}
