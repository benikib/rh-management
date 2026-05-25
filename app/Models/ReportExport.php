<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'report_type',
        'report_name',
        'file_name',
        'file_path',
        'file_type',
        'filters',
        'employe_id',
        'department_id',
        'direction_id',
        'generated_by',
        'status',
    ];

    protected $casts = [
        'filters' => 'array',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function department()
    {
        return $this->belongsTo(Departement::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
