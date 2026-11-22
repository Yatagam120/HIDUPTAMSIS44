<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    private function checkAuthority(): void
    {
        abort_unless(
            in_array(Auth::user()->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']),
            403,
            'Hanya Admin, Wali Kelas, Ketua Kelas, dan Wakil Ketua Kelas yang dapat mengelola data siswa.'
        );
    }

    public function index()
    {
        $walas = Student::where('jabatan', 'walas')->first();
        $ketua = Student::where('jabatan', 'ketua_kelas')->first();
        $wakil = Student::where('jabatan', 'wakil_ketua')->first();

        $murid = Student::whereNotIn('jabatan', ['walas', 'ketua_kelas', 'wakil_ketua'])
            ->orWhereNull('jabatan')
            ->orderBy('nama')
            ->get();

        return view('students.index', compact('walas', 'ketua', 'wakil', 'murid'));
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function create()
    {
        $this->checkAuthority();
        return view('students.create');
    }

    public function store(Request $request)
    {
        $this->checkAuthority();

        $data = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'in:walas,ketua_kelas,wakil_ketua,ppts,ex_ppts,siswa'],
            'umur'    => ['nullable', 'integer', 'min:10', 'max:99'],
            'foto'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        if (in_array($data['jabatan'], ['walas', 'ketua_kelas', 'wakil_ketua'])) {
            Student::where('jabatan', $data['jabatan'])->update(['jabatan' => 'siswa']);
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('students', 'public');
        }

        $data['umur'] = $request->input('umur') ?? 17;
        $data['tanggal_lahir'] = $request->input('tanggal_lahir') ?? '2009-01-01';
        $data['hobi'] = $request->input('hobi') ?? '-';
        $data['skill'] = $request->input('skill') ?? '-';

        Student::create($data);

        Student::create($data);

        Student::create($data);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(Student $student)
    {
        $this->checkAuthority();
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $this->checkAuthority();

        $data = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'in:walas,ketua_kelas,wakil_ketua,ppts,ex_ppts,siswa'],
            'umur'    => ['nullable', 'integer', 'min:10', 'max:99'],
            'foto'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        if (in_array($data['jabatan'], ['walas', 'ketua_kelas', 'wakil_ketua'])) {
            Student::where('jabatan', $data['jabatan'])
                ->where('id', '!=', $student->id)
                ->update(['jabatan' => 'siswa']);
        }

        if ($request->boolean('hapus_foto') && $student->foto) {
            Storage::disk('public')->delete($student->foto);
            $data['foto'] = null;
        } elseif ($request->hasFile('foto')) {
            if ($student->foto) {
                Storage::disk('public')->delete($student->foto);
            }
            $data['foto'] = $request->file('foto')->store('students', 'public');
        }

        $data['umur'] = $request->input('umur') ?? ($student->umur ?? 17);

        $student->update($data);

        return redirect()->route('students.show', $student->id)->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        $this->checkAuthority();

        if ($student->foto) {
            Storage::disk('public')->delete($student->foto);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}