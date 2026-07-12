<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeFamilyInfo extends Model
{
    protected $table = 'employee_family_info';
    
    protected $fillable = [
        'employe_id',
        'marital_status_id',
        'spouse_name',
        'spouse_identity',
        'marriage_date',
        'marriage_certificate_path',
        'number_of_children',
    ];

    protected $casts = [
        'marriage_date' => 'date',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id');
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(EmployeeDependent::class, 'employe_id', 'employe_id');
    }
}
