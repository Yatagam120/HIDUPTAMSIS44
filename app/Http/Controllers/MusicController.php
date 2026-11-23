<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MusicController extends Controller
{
    private function isAdmin(): bool
    {
        $user = Auth::user();
        $role = strtolower(trim((string) ($user->role ?? 'siswa')));
        return $role === 'admin';
    }

    public function storeAdmin(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Hanya Admin yang dapat menambahkan musik langsung.');
        }

        $request->validate([
            'title'  => 'required|string|max:150',
            'artist' => 'nullable|string|max:150',
            'audio'  => 'required|file|mimes:mp3,wav,ogg,m4a|max:20480',
        ]);

        $file = $request->file('audio');
        $ext = strtolower($file->getClientOriginalExtension());
        $dir = public_path('uploads/music');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $name = 'music_' . time() . '_' . uniqid() . '.' . $ext;
        $file->move($dir, $name);

        DB::table('app_musics')->insert([
            'title'        => $request->title,
            'artist'       => $request->artist,
            'file_path'    => 'uploads/music/' . $name,
            'status'       => 'approved',
            'requested_by' => Auth::id(),
            'is_active'    => true,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', 'Lagu berhasil ditambahkan ke pemutar Pengaturan!');
    }

    public function requestSong(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:150',
            'artist' => 'nullable|string|max:150',
            'audio'  => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:20480',
        ]);

        $filePath = '';
        if ($request->hasFile('audio')) {
            $file = $request->file('audio');
            $ext = strtolower($file->getClientOriginalExtension());
            $dir = public_path('uploads/music');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $name = 'req_' . time() . '_' . uniqid() . '.' . $ext;
            $file->move($dir, $name);
            $filePath = 'uploads/music/' . $name;
        }

        DB::table('app_musics')->insert([
            'title'        => $request->title,
            'artist'       => $request->artist,
            'file_path'    => $filePath,
            'status'       => 'pending',
            'requested_by' => Auth::id(),
            'is_active'    => false,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', 'Request lagu terkirim! Admin akan mereview di Admin Panel (AP).');
    }

    public function approve($id)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        DB::table('app_musics')->where('id', $id)->update([
            'status'     => 'approved',
            'is_active'  => true,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Request lagu disetujui!');
    }

    public function destroy($id)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        DB::table('app_musics')->where('id', $id)->delete();

        return back()->with('success', 'Lagu dihapus!');
    }
}