<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeStatus extends Model
{
    protected $table = 'employee_statuses';
    
    protected $fillable = [
        'code',
        'label',
        'description',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employe::class, 'status_id');
    }

    public function historyLogs(): HasMany
    {
        return $this->hasMany(EmployeeHistoryLog::class, 'status_id');
    }
}
