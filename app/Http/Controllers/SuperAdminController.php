<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    // ─── Dashboard Super Admin ─────────────────────────────────────────────────

    public function dashboard()
    {
        $totalAdmins    = User::where('role', 'admin')->count();
        $activeAdmins   = User::where('role', 'admin')->where('is_active', true)->count();
        $pendingRequests = PasswordResetRequest::where('status', 'pending')->count();

        return view('superadmin.dashboard', compact('totalAdmins', 'activeAdmins', 'pendingRequests'));
    }

    // ─── Kelola Admin ──────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $admins = User::where('role', 'admin')->latest()->paginate(15);

        return view('superadmin.admins.index', compact('admins'));
    }

    public function adminCreate()
    {
        return view('superadmin.admins.create');
    }

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

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin berhasil dibuat.');
    }

    public function adminEdit(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        return view('superadmin.admins.edit', compact('admin'));
    }

    public function adminUpdate(Request $request, User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $admin->id,
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name     = $validated['name'];
        $admin->username = $validated['username'];
        $admin->email    = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function adminToggleActive(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        $admin->is_active = !$admin->is_active;
        $admin->save();

        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Admin berhasil {$status}.");
    }

    public function adminDestroy(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        $admin->delete();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin berhasil dihapus.');
    }

    // ─── Kelola Request Reset Password ─────────────────────────────────────────

    public function resetRequests()
    {
        $requests = PasswordResetRequest::with('user')
            ->orderByRaw("CASE status
                WHEN 'pending'    THEN 1
                WHEN 'approved'   THEN 2
                WHEN 'completed'  THEN 3
                WHEN 'auto_reset' THEN 4
                WHEN 'rejected'   THEN 5
                ELSE 6 END")
            ->latest()
            ->paginate(20);

        return view('superadmin.reset-requests.index', compact('requests'));
    }

    public function approveRequest(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isPending()) {
            return redirect()->back()->with('error', 'Request ini sudah diproses.');
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $resetRequest->update([
            'status'      => 'approved',
            'otp_code'    => $otp,
            'otp_expires_at' => now()->addMinutes(30),
            'approved_at' => now(),
        ]);

        // Kirim OTP ke email admin
        try {
            Mail::to($resetRequest->user->email)->send(new OtpMail($resetRequest->user, $otp, $resetRequest));
        } catch (\Exception $e) {
            \Log::error('Gagal kirim OTP email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Request disetujui dan OTP telah dikirim ke email admin.');
    }

    public function rejectRequest(PasswordResetRequest $resetRequest)
    {
        if (!$resetRequest->isPending()) {
            return redirect()->back()->with('error', 'Request ini sudah diproses.');
        }

        $resetRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Request berhasil ditolak.');
    }
}
