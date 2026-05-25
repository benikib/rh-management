<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class QrToken extends Model
{
    use HasFactory;

    protected $table = 'qr_tokens';

    protected $fillable = [
        'token',
        'type',
        'date_validite',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'date_validite' => 'date',
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    public function isExpired(): bool
    {
        return Carbon::now()->gt($this->expires_at);
    }

    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->is_used;
    }
}