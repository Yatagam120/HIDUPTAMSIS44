<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('id')->get();
        $isHighAuth = SubjectController::isHighAuthority();
        return view('students.index', compact('students', 'isHighAuth'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = Auth::user();
        $isHighAuth = SubjectController::isHighAuthority($user);

        // Siswa & Ex-PPTS hanya boleh mengedit data miliknya sendiri (dan hanya foto)
        if (!$isHighAuth && isset($student->user_id) && (int) $student->user_id !== (int) $user->id) {
            abort(403, 'Anda hanya dapat mengganti foto profil Anda sendiri.');
        }

        $request->validate([
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'name'       => 'nullable|string|max:120',
            'quote'      => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender'     => 'nullable|string|max:20',
        ]);

        $columns = Schema::getColumnListing('students');
        $updateData = [];

        // Fix #17: Upload foto unik khusus untuk 1 ID siswa ini saja
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = strtolower($file->getClientOriginalExtension());
            $dir = public_path('uploads/students');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $fileName = 'student_' . $student->id . '_' . time() . '_' . uniqid() . '.' . $ext;
            $file->move($dir, $fileName);
            $photoPath = 'uploads/students/' . $fileName;

            if (in_array('photo', $columns, true)) $updateData['photo'] = $photoPath;
            elseif (in_array('avatar', $columns, true)) $updateData['avatar'] = $photoPath;
            elseif (in_array('image', $columns, true)) $updateData['image'] = $photoPath;
        }

        // Fix #13: Hanya otoritas tinggi yang boleh ganti nama, quote, tanggal lahir, & gender
        if ($isHighAuth) {
            if ($request->filled('name') && in_array('name', $columns, true)) {
                $updateData['name'] = $request->name;
            }
            if ($request->has('quote') && in_array('quote', $columns, true)) {
                $updateData['quote'] = $request->quote;
            }
            if ($request->filled('birth_date')) {
                if (in_array('birth_date', $columns, true)) $updateData['birth_date'] = $request->birth_date;
                elseif (in_array('tanggal_lahir', $columns, true)) $updateData['tanggal_lahir'] = $request->birth_date;
            }
            if ($request->filled('gender')) {
                if (in_array('gender', $columns, true)) $updateData['gender'] = $request->gender;
                elseif (in_array('jenis_kelamin', $columns, true)) $updateData['jenis_kelamin'] = $request->gender;
            }
        }

        if (!empty($updateData)) {
            Student::where('id', $student->id)->update($updateData);
        }

        return back()->with('success', $isHighAuth
            ? 'Profil siswa berhasil diperbarui!'
            : 'Foto profil berhasil diperbarui!');
    }
}