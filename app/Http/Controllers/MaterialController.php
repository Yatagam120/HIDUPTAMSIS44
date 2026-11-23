<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $isHighAuth = SubjectController::isHighAuthority();
        $examFilter = $request->query('jenis');
        $materials = collect();

        if (Schema::hasTable('study_materials')) {
            $query = DB::table('study_materials')->orderByDesc('id');
            if ($examFilter && $examFilter !== 'Semua') {
                $query->where('exam_type', $examFilter);
            }
            $materials = $query->get();
        }

        return view('materials.index', compact('materials', 'isHighAuth', 'examFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:200',
            'exam_type'    => 'required|string|max:50',
            'subject_name' => 'nullable|string|max:120',
            'description'  => 'nullable|string',
            'file'         => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,webp,mp4,webm|max:30720',
        ]);

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());
            $dir = public_path('uploads/materials');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $name = 'materi_' . time() . '_' . uniqid() . '.' . $ext;
            $file->move($dir, $name);
            $filePath = 'uploads/materials/' . $name;

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) $fileType = 'image';
            elseif (in_array($ext, ['mp4', 'webm'], true)) $fileType = 'video';
            else $fileType = 'doc';
        }

        DB::table('study_materials')->insert([
            'title'        => $request->title,
            'exam_type'    => $request->exam_type,
            'subject_name' => $request->subject_name,
            'description'  => $request->description,
            'file_path'    => $filePath,
            'file_type'    => $fileType,
            'user_id'      => Auth::id(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', 'Materi belajar berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (!SubjectController::isHighAuthority()) {
            abort(403);
        }

        DB::table('study_materials')->where('id', $id)->delete();

        return back()->with('success', 'Materi berhasil dihapus!');
    }
}