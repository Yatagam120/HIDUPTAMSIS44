<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating'   => ['required', 'numeric', 'min:0', 'max:5'],
            'komentar' => ['required', 'string', 'max:2000'],
            'media'    => ['nullable', 'array', 'max:10'],
            'media.*'  => ['file', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm,mov,avi,mkv', 'max:102400'],
        ]);

        $mediaList = [];
        $files = $request->file('media');
        if ($files) {
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }
                $mime = $file->getMimeType() ?? '';
                $type = str_starts_with($mime, 'video/') ? 'video' : 'image';
                $path = $file->store('feedback_media', 'public');
                $mediaList[] = [
                    'path' => $path,
                    'type' => $type,
                ];
            }
        }

        Feedback::create([
            'user_id'     => Auth::id(),
            'rating'      => round((float) $request->rating, 1),
            'komentar'    => $request->komentar,
            'media_paths' => $mediaList,
        ]);

        return redirect()->route('settings')->with('success', 'Terima kasih! Saran & laporan Anda berhasil dikirim ke Admin Panel.');
    }

    public function destroy(Feedback $feedback)
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);

        if (is_array($feedback->media_paths)) {
            foreach ($feedback->media_paths as $item) {
                if (!empty($item['path'])) {
                    Storage::disk('public')->delete($item['path']);
                }
            }
        }

        $feedback->delete();
        return redirect()->route('admin.users')->with('success', 'Data kritik/saran berhasil dihapus.');
    }
}