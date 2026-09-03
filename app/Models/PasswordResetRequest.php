<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetRequest extends Model
{
    // ── Konstanta siklus ──────────────────────────────────────────────────────
    const TEMP_PASSWORD_DELAY_SECONDS  = 60;   // Kirim temp password setelah 1 menit pending
    const TEMP_PASSWORD_LIFETIME_MINS  = 2;    // Temp password berlaku 2 menit
    const OTP_SESSION_LIFETIME_MINS    = 2;    // Session OTP setelah approve berlaku 2 menit
    const MAX_REQUESTS_PER_CYCLE       = 3;    // Maks 3 request sebelum di-block

    protected $fillable = [
        'user_id',
        'otp_code',
        'status',
        'request_count',
        'blocked_until',
        'otp_expires_at',
        'request_expires_at',
        'approved_at',
        'completed_at',
        'temp_password',
        'temp_password_sent_at',
        'temp_password_expires_at',
    ];

    protected $casts = [
        'otp_expires_at'           => 'datetime',
        'request_expires_at'       => 'datetime',
        'approved_at'              => 'datetime',
        'completed_at'             => 'datetime',
        'blocked_until'            => 'datetime',
        'temp_password_sent_at'    => 'datetime',
        'temp_password_expires_at' => 'datetime',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Status helpers ────────────────────────────────────────────────────────

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

    // ── Temp password helpers ─────────────────────────────────────────────────

    /**
     * Apakah temp password masih valid (belum expired, berlaku 2 menit).
     */
    public function isTempPasswordValid(): bool
    {
        return $this->temp_password !== null
            && $this->temp_password_expires_at !== null
            && $this->temp_password_expires_at->isFuture();
    }

    /**
     * Apakah sudah waktunya kirim temp password:
     * - Belum pernah kirim: cek apakah request sudah pending > 1 menit
     * - Sudah pernah kirim: hanya kirim lagi jika admin submit request BARU
     *   (ini dikontrol dari luar — shouldSendTempPassword hanya untuk request pertama)
     */
    public function shouldSendTempPassword(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        // Hanya kirim sekali per request (per baris DB).
        // Jika sudah pernah kirim, tidak kirim lagi kecuali admin buat request baru.
        if ($this->temp_password_sent_at !== null) {
            return false;
        }

        // Kirim jika sudah pending > 1 menit dan belum pernah kirim
        return $this->created_at->diffInSeconds(now()) >= self::TEMP_PASSWORD_DELAY_SECONDS;
    }

    // ── Block / cycle helpers ─────────────────────────────────────────────────

    /**
     * Apakah user sedang di-block (request_count >= MAX di request ini)?
     * Block berlaku selama request ini masih pending dan sudah mencapai batas.
     */
    public function isBlocked(): bool
    {
        return $this->request_count >= self::MAX_REQUESTS_PER_CYCLE
            && $this->status === 'pending';
    }

    /**
     * Hitung sisa request yang diperbolehkan sebelum block.
     */
    public function remainingRequests(): int
    {
        return max(0, self::MAX_REQUESTS_PER_CYCLE - $this->request_count);
    }

    /**
     * Apakah user boleh membuat request baru (untuk siklus baru)?
     * Boleh jika tidak ada request pending/approved yang sedang aktif,
     * atau request aktif sudah expired/rejected/completed.
     */
    public static function canUserSubmitNewRequest(int $userId): bool
    {
        $active = self::where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        // Tidak ada request aktif → boleh submit
        if (!$active) {
            return true;
        }

        // Ada request approved yang masih berlaku → tidak boleh submit baru
        if ($active->status === 'approved' && $active->isOtpValid()) {
            return false;
        }

        // Ada request pending yang sudah di-block → tidak boleh submit baru (harus tunggu approve/reject)
        if ($active->isPending() && $active->isBlocked()) {
            return false;
        }

        // Ada request pending yang belum di-block → tidak perlu submit baru, masih bisa diproses
        if ($active->isPending() && !$active->isBlocked()) {
            return false;
        }

        return false;
    }

    /**
     * Ambil request aktif milik user (pending atau approved).
     * Jika expired/rejected/completed, return null.
     */
    public static function getActiveRequest(int $userId): ?self
    {
        return self::where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();
    }
}
