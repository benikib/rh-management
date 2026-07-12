<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractType extends Model
{
    protected $table = 'contract_types';
    
    protected $fillable = [
        'code',
        'label',
        'description',
        'requires_end_date',
    ];

    protected $casts = [
        'requires_end_date' => 'boolean',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(EmployeeContract::class, 'contract_type_id');
    }
}
