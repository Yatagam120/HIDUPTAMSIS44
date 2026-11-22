<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403, 'Hanya Admin yang dapat mengakses Admin Panel.');
    }

    public function index()
    {
        $this->ensureAdmin();

        $users = User::orderByRaw("FIELD(role, 'admin', 'guru', 'ketua_kelas', 'wakil_ketua', 'murid')")
            ->latest()
            ->get();

        $feedbacks = Feedback::with('user')->latest()->get();

        return view('admin.users', compact('users', 'feedbacks'));
    }

    public function approve(User $user)
    {
        $this->ensureAdmin();

        $user->is_approved = true;
        if (empty($user->role)) {
            $user->role = 'murid';
        }
        $user->save();

        return redirect()->route('admin.users')->with('success', "Akun {$user->name} berhasil disetujui!");
    }

    public function updateRole(Request $request, User $user)
    {
        $this->ensureAdmin();

        $request->validate([
            'role' => ['required', 'in:admin,guru,ketua_kelas,wakil_ketua,murid'],
        ]);

        if ((int) $user->id === (int) Auth::id() && $request->role !== 'admin') {
            return redirect()->route('admin.users')->with('error', 'Anda tidak dapat menurunkan role Admin milik Anda sendiri.');
        }

        $user->role = $request->role;
        $user->is_approved = true;
        $user->save();

        return redirect()->route('admin.users')->with('success', "Role {$user->name} berhasil diubah menjadi " . strtoupper(str_replace('_', ' ', $request->role)) . ".");
    }

    public function destroy(User $user)
    {
        $this->ensureAdmin();

        if ((int) $user->id === (int) Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Akun Admin utama tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', "Akun {$user->name} berhasil dihapus.");
    }
}