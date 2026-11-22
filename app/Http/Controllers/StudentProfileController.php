<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403, 'Hanya Admin yang dapat mengedit atau menghapus data murid.');
    }

    public function update(Request $request, Student $student)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'role_tag'    => ['nullable', 'string', 'max:50'],
            'birth_date'  => ['nullable', 'date'],
            'age'         => ['nullable', 'integer', 'min:1', 'max:120'],
            'gender'      => ['nullable', 'string', 'max:20'],
            'quote'       => ['nullable', 'string', 'max:500'],
            'frame_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:10240'],
        ]);

        $age = $validated['age'] ?? null;
        if (!empty($validated['birth_date']) && is_null($age)) {
            $age = Carbon::parse($validated['birth_date'])->age;
        }

        $updateData = [];
        if (!empty($validated['role_tag'])) {
            foreach (['hierarchy', 'role', 'jabatan'] as $roleCol) {
                if (Schema::hasColumn('students', $roleCol)) {
                    $updateData[$roleCol] = $validated['role_tag'];
                }
            }
        }
        if (Schema::hasColumn('students', 'birth_date')) {
            $updateData['birth_date'] = $validated['birth_date'] ?? null;
        }
        if (Schema::hasColumn('students', 'age')) {
            $updateData['age'] = $age;
        }
        if (Schema::hasColumn('students', 'gender')) {
            $updateData['gender'] = $validated['gender'] ?? null;
        }
        if (Schema::hasColumn('students', 'quote')) {
            $updateData['quote'] = $validated['quote'] ?? null;
        }

        if ($request->hasFile('frame_image')) {
            $path = $request->file('frame_image')->store('student_frames', 'public');
            if (Schema::hasColumn('students', 'frame_path')) {
                if (!empty($student->frame_path)) {
                    Storage::disk('public')->delete($student->frame_path);
                }
                $updateData['frame_path'] = $path;
            }
        }

        if (!empty($updateData)) {
            $student->update($updateData);
        }

        $studentLabel = $student->name ?? $student->nama ?? 'murid';
        return back()->with('success', "Data {$studentLabel} berhasil diperbarui!");
    }

    public function destroy(Student $student)
    {
        $this->ensureAdmin();

        if (!empty($student->frame_path)) {
            Storage::disk('public')->delete($student->frame_path);
        }

        $studentLabel = $student->name ?? $student->nama ?? 'murid';
        $student->delete();

        return back()->with('success', "Data {$studentLabel} berhasil dihapus.");
    }
}