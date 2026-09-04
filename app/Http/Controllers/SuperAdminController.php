<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SuperAdminController extends Controller
{
    // TTL pendingCount — lebih sering berubah, cache 1 menit
    private const CACHE_PENDING_TTL = 60;

    // ─── Invalidasi cache settings ────────────────────────────────────────────
    private static function forgetSettingsCache(): void
    {
        Cache::forget('settings_pending_count');
    }

    // ─── Halaman /pengaturan (gabungan Manajemen Admin + Reset Requests) ───────

    public function settingsIndex(Request $request)
    {
        // Paginator Eloquent tidak aman di-cache karena objek model tidak bisa
        // di-serialize/deserialize dengan andal oleh semua driver cache.
        // Query ini ringan (hanya tabel users, filter role admin/superadmin) — langsung query.
        $admins = User::whereIn('role', ['admin', 'superadmin'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $requests = PasswordResetRequest::with('user')
            ->orderByRaw("CASE status
                WHEN 'pending'    THEN 1
                WHEN 'approved'   THEN 2
                WHEN 'completed'  THEN 3
                WHEN 'auto_reset' THEN 4
                WHEN 'rejected'   THEN 5
                ELSE 6 END")
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // pendingCount di-cache pendek (1 menit) — ditampilkan di badge notifikasi
        $pendingCount = Cache::remember('settings_pending_count', self::CACHE_PENDING_TTL, function () {
            return PasswordResetRequest::where('status', 'pending')->count();
        });

        $activeTab = $request->query('tab', 'profil-saya');

        return view('settings.index', compact('admins', 'requests', 'pendingCount', 'activeTab'));
    }

    // ─── Update Profil Super Admin ─────────────────────────────────────────────

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'username'   => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'      => 'required|email|unique:users,email,' . $user->id,
        ]);

        $name = trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? ''));

        $user->update([
            'name'     => $name,
            'username' => $validated['username'],
            'email'    => $validated['email'],
        ]);

        return redirect()->route('settings.index', ['tab' => 'profil-saya'])
            ->with('success', 'Sukses update profil pengguna!');
    }

    // ─── Kelola Admin ──────────────────────────────────────────────────────────

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'nullable|string|in:admin,superadmin',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'] ?? 'admin',
            'is_active' => true,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Admin berhasil dibuat.',
                'user'    => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role],
            ], 201);
        }

        self::forgetSettingsCache();

        return redirect()->route('settings.index')
            ->with('success', 'Sukses menambahkan admin baru!');
    }

    public function adminToggleActive(User $admin)
    {
        abort_if(!in_array($admin->role, ['admin', 'superadmin']), 404);

        $admin->is_active = !$admin->is_active;
        $admin->save();

        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';
        self::forgetSettingsCache();

        return redirect()->route('settings.index')
            ->with('success', "Sukses: Admin {$admin->name} berhasil {$status}!");
    }

    public function adminDestroy(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);
        abort_if($admin->id === auth()->id(), 403);

        $admin->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Admin berhasil dihapus.']);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Sukses menghapus data admin!');
    }

    // ─── Kelola Request Reset Password ─────────────────────────────────────────

    public function approveRequest(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isPending()) {
            return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
                ->with('error', 'Gagal: Permintaan ini sudah diproses sebelumnya.');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $resetRequest->update([
            'status'         => 'approved',
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinute(),
            'approved_at'    => now(),
        ]);

        // Invalidasi cache polling user ybs agar status langsung diperbarui
        Cache::forget("poll_status_user_{$resetRequest->user_id}");

        try {
            Mail::to($resetRequest->user->email)->send(new OtpMail($resetRequest->user, $otp, $resetRequest));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim OTP email: ' . $e->getMessage());
        }

        return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
            ->with('success', 'Sukses menyetujui permintaan! Kode OTP telah dikirim ke email.');
    }

    public function rejectRequest(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isPending()) {
            return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
                ->with('error', 'Gagal: Permintaan ini sudah diproses sebelumnya.');
        }

        $resetRequest->update(['status' => 'rejected']);

        // Invalidasi cache polling user ybs
        Cache::forget("poll_status_user_{$resetRequest->user_id}");

        return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
            ->with('success', 'Sukses menolak permintaan reset kata sandi.');
    }
}
