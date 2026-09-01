<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SuperAdminController extends Controller
{
    // ─── Halaman /pengaturan (gabungan Manajemen Admin + Reset Requests) ───────

    public function settingsIndex(Request $request)
    {
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

        $pendingCount = PasswordResetRequest::where('status', 'pending')->count();

        // Tab aktif: bisa di-pass lewat query string ?tab=persetujuan-sandi
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
            ->with('success', 'Profil berhasil diperbarui.');
    }

    // ─── Kelola Admin ──────────────────────────────────────────────────────────

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Admin berhasil dibuat.');
    }

    public function adminToggleActive(User $admin)
    {
        abort_if(!in_array($admin->role, ['admin', 'superadmin']), 404);

        $admin->is_active = !$admin->is_active;
        $admin->save();

        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('settings.index')
            ->with('success', "Admin {$admin->name} berhasil {$status}.");
    }

    public function adminDestroy(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);
        abort_if($admin->id === auth()->id(), 403);

        $admin->delete();

        return redirect()->route('settings.index')
            ->with('success', 'Admin berhasil dihapus.');
    }

    // ─── Kelola Request Reset Password ─────────────────────────────────────────

    public function approveRequest(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isPending()) {
            return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
                ->with('error', 'Request ini sudah diproses.');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $resetRequest->update([
            'status'         => 'approved',
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinute(),
            'approved_at'    => now(),
        ]);

        try {
            Mail::to($resetRequest->user->email)->send(new OtpMail($resetRequest->user, $otp, $resetRequest));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim OTP email: ' . $e->getMessage());
        }

        return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
            ->with('success', 'Request disetujui. OTP telah dikirim ke email admin.');    }

    public function rejectRequest(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isPending()) {
            return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
                ->with('error', 'Request ini sudah diproses.');
        }

        $resetRequest->update(['status' => 'rejected']);

        return redirect()->route('settings.index', ['tab' => 'persetujuan-sandi'])
            ->with('success', 'Request berhasil ditolak.');
    }
}
