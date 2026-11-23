<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SubjectController extends Controller
{
    public static function isHighAuthority($user = null): bool
    {
        $user = $user ?? Auth::user();
        if (!$user) return false;
        $role = strtolower(trim((string) ($user->role ?? $user->jabatan ?? 'siswa')));
        return in_array($role, [
            'admin',
            'guru',
            'ppts',
            'ketua_kelas',
            'ketua kelas',
            'wakil_ketua_kelas',
            'wakil ketua kelas',
        ], true);
    }

    private function resolveTargetTable(): string
    {
        return Schema::hasTable('subject_posts') ? 'subject_posts' : 'subject_items';
    }

    private function normalizeRow($row)
    {
        $rawType = $row->category ?? $row->kategori ?? $row->type ?? $row->jenis ?? $row->tipe ?? 'catatan';
        $type = strtolower(trim((string) $rawType));
        if (!in_array($type, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $type = 'catatan';
        }

        $row->type = $type;
        $row->title = $row->title ?? $row->judul ?? 'Tanpa Judul';
        $row->description = $row->description ?? $row->deskripsi ?? $row->content ?? $row->isi ?? null;
        $row->due_date = $row->due_date ?? $row->deadline ?? $row->tanggal_deadline ?? $row->tanggal ?? null;
        $row->status = $row->status ?? 'approved';
        $row->media_path = $row->media_path ?? $row->image ?? $row->file_path ?? null;
        $row->media_type = $row->media_type ?? null;

        if (!$row->media_type && $row->media_path) {
            $ext = strtolower(pathinfo($row->media_path, PATHINFO_EXTENSION));
            $row->media_type = in_array($ext, ['mp4', 'webm', 'mov', 'avi'], true) ? 'video' : 'image';
        }

        return $row;
    }

    public function show($id, Request $request)
    {
        $subject = Subject::findOrFail($id);
        $table = $this->resolveTargetTable();
        $isHighAuth = self::isHighAuthority();
        $uid = (int) Auth::id();

        $items = collect();
        if (Schema::hasTable($table)) {
            $columns = Schema::getColumnListing($table);
            $query = DB::table($table)->where('subject_id', $subject->id)->orderByDesc('id');

            // Siswa/Ex-PPTS hanya melihat yang approved + miliknya yang masih pending
            if (!$isHighAuth && in_array('status', $columns, true)) {
                $query->where(function ($q) use ($uid) {
                    $q->where('status', 'approved')->orWhere('user_id', $uid);
                });
            }

            $items = $query->get()->map(fn($row) => $this->normalizeRow($row));
        }

        // Ambil komentar ala Facebook per item
        $commentsByItem = collect();
        if (Schema::hasTable('item_comments') && $items->isNotEmpty()) {
            $itemIds = $items->pluck('id')->all();
            $comments = DB::table('item_comments')
                ->whereIn('item_id', $itemIds)
                ->orderBy('id')
                ->get();

            $commentUserIds = $comments->pluck('user_id')->unique()->values();
            $commentUsers = $commentUserIds->isNotEmpty()
                ? \App\Models\User::whereIn('id', $commentUserIds)->get()->keyBy('id')
                : collect();

            $commentsByItem = $comments->map(function ($c) use ($commentUsers) {
                $c->user = $commentUsers->get($c->user_id);
                return $c;
            })->groupBy('item_id');
        }

        $activeTab = strtolower(trim((string) $request->query('tab', session('active_tab', 'catatan'))));
        if (!in_array($activeTab, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $activeTab = 'catatan';
        }
        $notifColor = $request->query('notif', '');

        return view('subjects.show', compact(
            'subject',
            'items',
            'activeTab',
            'notifColor',
            'isHighAuth',
            'commentsByItem'
        ));
    }

    public function storeItem(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,mov|max:25600',
        ]);

        $type = strtolower(trim((string) ($request->input('type') ?? 'catatan')));
        if (!in_array($type, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $type = 'catatan';
        }

        $table = $this->resolveTargetTable();
        $columns = Schema::getColumnListing($table);
        $isHighAuth = self::isHighAuthority();

        $mediaPath = null;
        $mediaType = null;

        // Dukung hasil crop base64 dari modal crop atau file upload langsung
        if ($request->filled('cropped_image_base64') && str_starts_with($request->cropped_image_base64, 'data:image/')) {
            $rawBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $request->cropped_image_base64);
            $binary = base64_decode($rawBase64);
            if ($binary !== false) {
                $dir = public_path('uploads/subject_media');
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                $fileName = 'crop_' . time() . '_' . uniqid() . '.png';
                file_put_contents($dir . '/' . $fileName, $binary);
                $mediaPath = 'uploads/subject_media/' . $fileName;
                $mediaType = 'image';
            }
        } elseif ($request->hasFile('media')) {
            $file = $request->file('media');
            $ext = strtolower($file->getClientOriginalExtension());
            $dir = public_path('uploads/subject_media');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $fileName = 'media_' . time() . '_' . uniqid() . '.' . $ext;
            $file->move($dir, $fileName);
            $mediaPath = 'uploads/subject_media/' . $fileName;
            $mediaType = in_array($ext, ['mp4', 'webm', 'mov'], true) ? 'video' : 'image';
        }

        $status = $isHighAuth ? 'approved' : 'pending';

        $data = [
            'subject_id' => $subject->id,
        ];

        if (in_array('user_id', $columns, true)) $data['user_id'] = Auth::id() ?? 1;
        if (in_array('status', $columns, true)) $data['status'] = $status;

        foreach (['category', 'kategori', 'type', 'jenis', 'tipe'] as $col) {
            if (in_array($col, $columns, true)) $data[$col] = $type;
        }

        if (in_array('title', $columns, true)) $data['title'] = $request->title;
        elseif (in_array('judul', $columns, true)) $data['judul'] = $request->title;

        if (in_array('description', $columns, true)) $data['description'] = $request->description;
        elseif (in_array('deskripsi', $columns, true)) $data['deskripsi'] = $request->description;
        elseif (in_array('content', $columns, true)) $data['content'] = $request->description;

        if ($request->filled('due_date')) {
            foreach (['due_date', 'deadline', 'tanggal_deadline', 'tanggal'] as $dCol) {
                if (in_array($dCol, $columns, true)) {
                    $data[$dCol] = $request->due_date;
                    break;
                }
            }
        }

        if ($mediaPath) {
            if (in_array('media_path', $columns, true)) $data['media_path'] = $mediaPath;
            elseif (in_array('image', $columns, true)) $data['image'] = $mediaPath;
            if (in_array('media_type', $columns, true)) $data['media_type'] = $mediaType;
        }

        if (in_array('completed_by', $columns, true)) $data['completed_by'] = json_encode([]);
        if (in_array('created_at', $columns, true)) $data['created_at'] = now();
        if (in_array('updated_at', $columns, true)) $data['updated_at'] = now();

        DB::table($table)->insert($data);

        $msg = $status === 'approved'
            ? ucfirst($type) . ' berhasil diposting!'
            : ucfirst($type) . ' berhasil diajukan! Menunggu verifikasi Admin / Ketua Kelas / Guru.';

        return redirect()
            ->route('subjects.show', ['subject' => $subject->id, 'tab' => $type])
            ->with('active_tab', $type)
            ->with('success', $msg);
    }

    public function updateItem(Request $request, $id, $itemId)
    {
        if (!self::isHighAuthority()) {
            abort(403, 'Hanya otoritas tinggi yang dapat mengedit postingan.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $table = $this->resolveTargetTable();
        $columns = Schema::getColumnListing($table);
        $data = [];

        if (in_array('title', $columns, true)) $data['title'] = $request->title;
        elseif (in_array('judul', $columns, true)) $data['judul'] = $request->title;

        if (in_array('description', $columns, true)) $data['description'] = $request->description;
        elseif (in_array('deskripsi', $columns, true)) $data['deskripsi'] = $request->description;
        elseif (in_array('content', $columns, true)) $data['content'] = $request->description;

        foreach (['due_date', 'deadline', 'tanggal_deadline', 'tanggal'] as $dCol) {
            if (in_array($dCol, $columns, true)) {
                $data[$dCol] = $request->due_date ?: null;
                break;
            }
        }

        if (in_array('updated_at', $columns, true)) $data['updated_at'] = now();

        DB::table($table)->where('id', $itemId)->update($data);

        return back()->with('success', 'Postingan berhasil diperbarui!');
    }

    public function destroyItem($id, $itemId)
    {
        if (!self::isHighAuthority()) {
            abort(403, 'Siswa dan Ex-PPTS tidak diizinkan menghapus postingan.');
        }

        $table = $this->resolveTargetTable();
        DB::table($table)->where('id', $itemId)->delete();

        return back()->with('success', 'Postingan berhasil dihapus!');
    }

    public function approveItem($itemId)
    {
        if (!self::isHighAuthority()) {
            abort(403);
        }

        $table = $this->resolveTargetTable();
        if (Schema::hasTable($table) && Schema::hasColumn($table, 'status')) {
            DB::table($table)->where('id', $itemId)->update(['status' => 'approved', 'updated_at' => now()]);
        }

        return back()->with('success', 'Postingan telah disetujui dan tampil publik!');
    }

    public function toggleComplete($itemId)
    {
        $table = $this->resolveTargetTable();
        if (!Schema::hasTable($table)) {
            return back();
        }

        // Fix #10: pastikan kolom completed_by selalu ada agar tidak server error 500
        if (!Schema::hasColumn($table, 'completed_by')) {
            Schema::table($table, function ($t) {
                $t->json('completed_by')->nullable();
            });
        }

        $item = DB::table($table)->where('id', $itemId)->first();
        if ($item) {
            $userId = (int) Auth::id();
            $raw = $item->completed_by ?? '[]';
            $decoded = is_array($raw) ? $raw : json_decode((string) $raw, true);
            $completedBy = is_array($decoded) ? array_map('intval', $decoded) : [];

            if (in_array($userId, $completedBy, true)) {
                $completedBy = array_values(array_diff($completedBy, [$userId]));
            } else {
                $completedBy[] = $userId;
            }

            DB::table($table)
                ->where('id', $itemId)
                ->update(['completed_by' => json_encode($completedBy)]);
        }

        return back()->with('success', 'Status penyelesaian diperbarui!');
    }

    public function storeComment(Request $request, $itemId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        if (Schema::hasTable('item_comments')) {
            DB::table('item_comments')->insert([
                'item_id' => (int) $itemId,
                'user_id' => (int) Auth::id(),
                'body' => $request->body,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Komentar terkirim!');
    }

    public function destroyComment($commentId)
    {
        if (Schema::hasTable('item_comments')) {
            $comment = DB::table('item_comments')->where('id', $commentId)->first();
            if ($comment && ((int) $comment->user_id === (int) Auth::id() || self::isHighAuthority())) {
                DB::table('item_comments')->where('id', $commentId)->delete();
            }
        }
        return back();
    }

    public function allTasks(Request $request)
    {
        $table = $this->resolveTargetTable();
        $subjects = Subject::all()->keyBy('id');
        $isHighAuth = self::isHighAuthority();
        $uid = (int) Auth::id();
        $tasks = collect();

        if (Schema::hasTable($table)) {
            $columns = Schema::getColumnListing($table);
            $typeCol = collect(['category', 'kategori', 'type', 'jenis', 'tipe'])->first(fn($c) => in_array($c, $columns, true));

            $query = DB::table($table)->orderByDesc('id');
            if ($typeCol) {
                $query->whereIn($typeCol, ['tugas', 'pr', 'event', 'Tugas', 'PR', 'Event']);
            }
            if (!$isHighAuth && in_array('status', $columns, true)) {
                $query->where(function ($q) use ($uid) {
                    $q->where('status', 'approved')->orWhere('user_id', $uid);
                });
            }

            $tasks = $query->get()->map(function ($row) use ($subjects) {
                $row = $this->normalizeRow($row);
                $row->subject = $subjects->get($row->subject_id);
                return $row;
            });
        }

        return view('subjects.tasks', [
            'tasks' => $tasks,
            'items' => $tasks,
            'posts' => $tasks,
            'subjects' => $subjects->values(),
            'isHighAuth' => $isHighAuth,
        ]);
    }
}