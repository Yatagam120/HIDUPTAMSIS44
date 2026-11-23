<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherContactController extends Controller
{
    public function index()
    {
        $isHighAuth = SubjectController::isHighAuthority();
        $uid = (int) Auth::id();
        $contacts = collect();

        if (Schema::hasTable('teacher_contacts')) {
            $query = DB::table('teacher_contacts')->orderBy('teacher_name');
            if (!$isHighAuth) {
                $query->where(function ($q) use ($uid) {
                    $q->where('status', 'approved')->orWhere('submitted_by', $uid);
                });
            }
            $contacts = $query->get();
        }

        return view('teachers.phone', compact('contacts', 'isHighAuth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_name' => 'required|string|max:120',
            'subject_name' => 'nullable|string|max:120',
            'phone_number' => 'required|string|max:30',
        ]);

        $isHighAuth = SubjectController::isHighAuthority();
        $status = $isHighAuth ? 'approved' : 'pending';

        DB::table('teacher_contacts')->insert([
            'teacher_name' => $request->teacher_name,
            'subject_name' => $request->subject_name,
            'phone_number' => preg_replace('/[^0-9+]/', '', $request->phone_number),
            'status'       => $status,
            'submitted_by' => Auth::id(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $msg = $status === 'approved'
            ? 'Nomor WA guru berhasil ditambahkan!'
            : 'Nomor WA guru diajukan! Menunggu verifikasi Admin / Ketua Kelas / Guru.';

        return back()->with('success', $msg);
    }

    public function approve($id)
    {
        if (!SubjectController::isHighAuthority()) {
            abort(403);
        }

        DB::table('teacher_contacts')->where('id', $id)->update([
            'status' => 'approved',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Nomor guru telah disetujui!');
    }

    public function destroy($id)
    {
        if (!SubjectController::isHighAuthority()) {
            abort(403);
        }

        DB::table('teacher_contacts')->where('id', $id)->delete();

        return back()->with('success', 'Nomor guru berhasil dihapus!');
    }
}