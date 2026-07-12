<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaritalStatus extends Model
{
    protected $table = 'marital_statuses';
    
    protected $fillable = [
        'code',
        'label',
    ];

    public function familyInfos(): HasMany
    {
        return $this->hasMany(EmployeeFamilyInfo::class, 'marital_status_id');
    }
}
