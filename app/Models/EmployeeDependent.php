<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDependent extends Model
{
    protected $table = 'employee_dependents';
    
    protected $fillable = [
        'employe_id',
        'full_name',
        'type',
        'birth_date',
        'identity_number',
        'school_certificate_path',
        'family_composition_document',
        'is_student',
        'is_schooled',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_student' => 'boolean',
        'is_schooled' => 'boolean',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
