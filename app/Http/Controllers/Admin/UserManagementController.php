<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'superadmin')
            ->orWhere('id', Auth::id())
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,user',
        ]);

        $validated['password']  = Hash::make($validated['password']);
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$validated['name']} berhasil dibuat.");
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'superadmin' && $user->id !== Auth::id()) {
            abort(403, 'Tidak dapat mengedit akun Super Admin lain.');
        }

        $validated = $request->validate([
            'username'  => 'required|string|unique:users,username,' . $user->id,
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,user',
            'is_active' => 'boolean',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak dapat menghapus akun Super Admin.');
        }

        $name = $user->name;
        DB::table('sessions')->where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$name} berhasil dihapus.");
    }

    public function kickUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat kick akun sendiri.');
        }
        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak dapat kick akun Super Admin.');
        }

        DB::table('sessions')->where('user_id', $user->id)->delete();
        $user->update(['is_active' => false]);

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$user->name} berhasil di-kick dan dinonaktifkan.");
    }
}
