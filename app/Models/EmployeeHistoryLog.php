<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeHistoryLog extends Model
{
    protected $table = 'employee_history_logs';
    
    protected $fillable = [
        'employe_id',
        'event_type',
        'event_date',
        'status_id',
        'reason',
        'notes',
        'recorded_by_id',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(EmployeeStatus::class, 'status_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by_id');
    }

    public static function getEventTypeLabel(string $type): string
    {
        return match($type) {
            'hired' => 'Embauche',
            'promoted' => 'Promotion',
            'transferred' => 'Mutation',
            'demoted' => 'Rétrogradation',
            'formation' => 'Formation',
            'leave_medical' => 'Arrêt maladie',
            'leave_extended' => 'Absence prolongée',
            'deceased' => 'Décédé',
            'retired' => 'Retraité',
            'dismissed' => 'Renvoyé',
            'resigned' => 'Démissionné',
            'disciplinary' => 'Sanction disciplinaire',
            'reactivated' => 'Réactivé',
            default => $type,
        };
    }
}
