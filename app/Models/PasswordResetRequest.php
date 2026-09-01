<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetRequest extends Model
{
    protected $fillable = [
        'user_id',
        'otp_code',
        'status',
        'otp_expires_at',
        'request_expires_at',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'otp_expires_at'     => 'datetime',
        'request_expires_at' => 'datetime',
        'approved_at'        => 'datetime',
        'completed_at'       => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isOtpValid(): bool
    {
        return $this->status === 'approved'
            && $this->otp_expires_at !== null
            && $this->otp_expires_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->request_expires_at !== null
            && $this->request_expires_at->isPast()
            && $this->status === 'pending';
    }
}
