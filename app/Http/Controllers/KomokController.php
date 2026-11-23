<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KomokController extends Controller
{
    private function ensureAllowed(): void
    {
        $user = Auth::user();
        $role = strtolower(trim((string) ($user->role ?? $user->jabatan ?? 'siswa')));
        $allowed = ['admin', 'ppts', 'ketua_kelas', 'ketua kelas', 'wakil_ketua_kelas', 'wakil ketua kelas'];

        if (!in_array($role, $allowed, true)) {
            abort(403, 'Halaman Komok eksklusif untuk Ketua Kelas, Wakil Ketua Kelas, PPTS, dan Admin.');
        }
    }

    public function index()
    {
        $this->ensureAllowed();

        $posts = collect();
        if (Schema::hasTable('komok_posts')) {
            $rawPosts = DB::table('komok_posts')->orderByDesc('id')->get();
            $users = User::whereIn('id', $rawPosts->pluck('user_id')->unique())->get()->keyBy('id');
            $posts = $rawPosts->map(function ($p) use ($users) {
                $p->author = $users->get($p->user_id);
                $p->resolved_src = !empty($p->media_data)
                    ? $p->media_data
                    : ((!empty($p->media_path) && file_exists(public_path($p->media_path))) ? asset($p->media_path) : null);
                return $p;
            });
        }

        return view('komok.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $this->ensureAllowed();

        $request->validate([
            'title'   => 'nullable|string|max:160',
            'caption' => 'nullable|string|max:1000',
            'media'   => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,mov|max:40960',
        ]);

        $file = $request->file('media');
        $ext = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType() ?: 'image/jpeg';
        $mediaType = in_array($ext, ['mp4', 'webm', 'mov'], true) ? 'video' : 'image';

        $mediaData = null;
        if ($mediaType === 'image' && $file->getSize() <= 4194304) {
            $rawBytes = @file_get_contents($file->getRealPath());
            if ($rawBytes !== false) {
                $mediaData = 'data:' . $mime . ';base64,' . base64_encode($rawBytes);
            }
        }

        $dir = public_path('uploads/komok');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $name = 'komok_' . time() . '_' . uniqid() . '.' . $ext;
        $file->move($dir, $name);

        $insert = [
            'title'      => $request->title,
            'caption'    => $request->caption,
            'media_path' => 'uploads/komok/' . $name,
            'media_type' => $mediaType,
            'user_id'    => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (Schema::hasColumn('komok_posts', 'media_data')) {
            $insert['media_data'] = $mediaData;
        }

        DB::table('komok_posts')->insert($insert);

        return back()->with('success', 'Media Komok berhasil diposting!');
    }

    public function destroy($id)
    {
        $this->ensureAllowed();
        DB::table('komok_posts')->where('id', $id)->delete();
        return back()->with('success', 'Postingan Komok dihapus!');
    }
}