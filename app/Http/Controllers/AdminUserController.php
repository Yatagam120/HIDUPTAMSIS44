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

    /**
     * Tampilkan halaman AP (Admin Panel): daftar user/persetujuan + section Kritik/Critic.
     */
    public function index()
    {
        $this->ensureAdmin();

        $users = User::orderByRaw("FIELD(role, 'admin', 'guru', 'ketua_kelas', 'wakil_ketua', 'murid')")
            ->latest()
            ->get();

        $feedbacks = Feedback::with('user')->latest()->get();

        return view('admin.users', compact('users', 'feedbacks'));
    }

    /**
     * Setujui akun user baru (jika menggunakan sistem persetujuan is_approved).
     */
    public function approve(User $user)
    {
        $this->ensureAdmin();

        $user->update(['is_approved' => true]);

        return back()->with('success', "Akun {$user->name} berhasil disetujui!");
    }

    /**
     * Ubah role user dari Admin Panel.
     */
    public function updateRole(Request $request, User $user)
    {
        $this->ensureAdmin();

        $request->validate([
            'role' => ['required', 'in:admin,guru,ketua_kelas,wakil_ketua,murid'],
        ]);

        // Cegah admin menurunkan role dirinya sendiri secara tidak sengaja
        if ((int) $user->id === (int) Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat menurunkan role Admin milik Anda sendiri.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi " . strtoupper(str_replace('_', ' ', $request->role)) . ".");
    }

    /**
     * Hapus akun user dari Admin Panel.
     */
    public function destroy(User $user)
    {
        $this->ensureAdmin();

        if ((int) $user->id === (int) Auth::id()) {
            return back()->with('error', 'Akun Admin utama tidak dapat dihapus.');
        }

        $user->delete();

        return back()->with('success', "Akun {$user->name} berhasil dihapus.");
    }
}