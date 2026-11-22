<?php

namespace App\Http\Controllers;

use App\Models\FrameChangeRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class FrameRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'frame_image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:10240'],
            'student_id'  => ['nullable', 'integer'],
        ]);

        $user = Auth::user();
        $path = $request->file('frame_image')->store('student_frames', 'public');

        $studentName = $user->name;
        if ($request->filled('student_id') && Schema::hasTable('students')) {
            $student = Student::find($request->student_id);
            if ($student && isset($student->name)) {
                $studentName = $student->name;
            }
        }

        // Batalkan permintaan pending lama milik user ini agar tidak menumpuk
        FrameChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected', 'reviewed_at' => now()]);

        FrameChangeRequest::create([
            'user_id'      => $user->id,
            'student_name' => $studentName,
            'frame_path'   => $path,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Permintaan ganti gambar bingkai terkirim! Menunggu persetujuan Admin sebelum diproses.');
    }

    public function approve(FrameChangeRequest $frameRequest)
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);

        $frameRequest->status = 'approved';
        $frameRequest->reviewed_at = now();
        $frameRequest->save();

        if (Schema::hasTable('students') && Schema::hasColumn('students', 'frame_path')) {
            $query = Student::query();
            if ($frameRequest->student_name) {
                $query->where('name', $frameRequest->student_name);
            }
            $query->update(['frame_path' => $frameRequest->frame_path]);
        }

        return redirect()->route('admin.users')->with('success', "Bingkai siswa untuk {$frameRequest->student_name} telah disetujui dan diterapkan!");
    }

    public function reject(FrameChangeRequest $frameRequest)
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);

        if ($frameRequest->frame_path) {
            Storage::disk('public')->delete($frameRequest->frame_path);
        }

        $frameRequest->status = 'rejected';
        $frameRequest->reviewed_at = now();
        $frameRequest->save();

        return redirect()->route('admin.users')->with('success', "Permintaan ganti bingkai untuk {$frameRequest->student_name} ditolak.");
    }
}