<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SubjectController extends Controller
{
    private function resolveTargetTable(): string
    {
        if (Schema::hasTable('subject_posts')) {
            return 'subject_posts';
        }
        return 'subject_items';
    }

    private function detectTypeColumn(array $columns): ?string
    {
        foreach (['category', 'kategori', 'type', 'jenis', 'tipe'] as $col) {
            if (in_array($col, $columns, true)) {
                return $col;
            }
        }
        return null;
    }

    private function normalizeRow($row)
    {
        $rawType = $row->category
            ?? $row->kategori
            ?? $row->type
            ?? $row->jenis
            ?? $row->tipe
            ?? 'catatan';

        $type = strtolower(trim((string) $rawType));
        if (!in_array($type, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $type = 'catatan';
        }

        $row->type = $type;
        $row->title = $row->title ?? $row->judul ?? 'Tanpa Judul';
        $row->description = $row->description ?? $row->deskripsi ?? $row->content ?? $row->isi ?? null;
        $row->due_date = $row->due_date ?? $row->deadline ?? $row->tanggal_deadline ?? $row->tanggal ?? null;

        return $row;
    }

    public function show($id, Request $request)
    {
        $subject = Subject::findOrFail($id);
        $table = $this->resolveTargetTable();

        $items = collect();
        if (Schema::hasTable($table)) {
            $items = DB::table($table)
                ->where('subject_id', $subject->id)
                ->orderByDesc('id')
                ->get()
                ->map(fn($row) => $this->normalizeRow($row));
        }

        $activeTab = strtolower(trim((string) $request->query('tab', session('active_tab', 'catatan'))));
        if (!in_array($activeTab, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $activeTab = 'catatan';
        }
        $notifColor = $request->query('notif', '');

        return view('subjects.show', compact('subject', 'items', 'activeTab', 'notifColor'));
    }

    public function storeItem(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $rawType = $request->input('type') ?? $request->input('category') ?? 'catatan';
        $type = strtolower(trim((string) $rawType));
        if (!in_array($type, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $type = 'catatan';
        }

        $table = $this->resolveTargetTable();
        if (!Schema::hasTable($table)) {
            return back()->withErrors(['msg' => "Tabel {$table} tidak ditemukan di database!"]);
        }

        $columns = Schema::getColumnListing($table);
        $data = [
            'subject_id' => $subject->id,
        ];

        if (in_array('user_id', $columns, true)) {
            $data['user_id'] = Auth::id() ?? 1;
        }

        // Isi semua kolom kategori yang tersedia agar sinkron di semua controller
        foreach (['category', 'kategori', 'type', 'jenis', 'tipe'] as $col) {
            if (in_array($col, $columns, true)) {
                $data[$col] = $type;
            }
        }

        if (in_array('title', $columns, true)) $data['title'] = $request->title;
        elseif (in_array('judul', $columns, true)) $data['judul'] = $request->title;

        if (in_array('description', $columns, true)) $data['description'] = $request->description;
        elseif (in_array('deskripsi', $columns, true)) $data['deskripsi'] = $request->description;
        elseif (in_array('content', $columns, true)) $data['content'] = $request->description;
        elseif (in_array('isi', $columns, true)) $data['isi'] = $request->description;

        if ($request->filled('due_date')) {
            foreach (['due_date', 'deadline', 'tanggal_deadline', 'tanggal'] as $dCol) {
                if (in_array($dCol, $columns, true)) {
                    $data[$dCol] = $request->due_date;
                    break;
                }
            }
        }

        if (in_array('completed_by', $columns, true)) {
            $data['completed_by'] = json_encode([]);
        }
        if (in_array('created_at', $columns, true)) {
            $data['created_at'] = now();
        }
        if (in_array('updated_at', $columns, true)) {
            $data['updated_at'] = now();
        }

        DB::table($table)->insert($data);

        return redirect()
            ->route('subjects.show', ['subject' => $subject->id, 'tab' => $type])
            ->with('active_tab', $type)
            ->with('success', ucfirst($type) . ' berhasil ditambahkan!');
    }

    public function updateItem(Request $request, $id, $itemId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $table = $this->resolveTargetTable();
        if (Schema::hasTable($table)) {
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
        }

        return back()->with('success', 'Postingan berhasil diperbarui!');
    }

    public function destroyItem($id, $itemId)
    {
        $table = $this->resolveTargetTable();
        if (Schema::hasTable($table)) {
            DB::table($table)->where('id', $itemId)->delete();
        }

        return back()->with('success', 'Postingan berhasil dihapus!');
    }

    public function toggleComplete($itemId)
    {
        $table = $this->resolveTargetTable();
        if (Schema::hasTable($table)) {
            $item = DB::table($table)->where('id', $itemId)->first();
            if ($item) {
                $userId = (int) Auth::id();
                $completedBy = json_decode($item->completed_by ?? '[]', true) ?: [];
                $completedBy = array_map('intval', $completedBy);

                if (in_array($userId, $completedBy, true)) {
                    $completedBy = array_values(array_diff($completedBy, [$userId]));
                } else {
                    $completedBy[] = $userId;
                }

                DB::table($table)
                    ->where('id', $itemId)
                    ->update(['completed_by' => json_encode($completedBy)]);
            }
        }

        return back();
    }

    public function allTasks(Request $request)
    {
        $table = $this->resolveTargetTable();
        $subjects = Subject::all()->keyBy('id');
        $tasks = collect();

        if (Schema::hasTable($table)) {
            $columns = Schema::getColumnListing($table);
            $typeCol = $this->detectTypeColumn($columns);

            $query = DB::table($table)->orderByDesc('id');
            if ($typeCol) {
                $query->whereIn($typeCol, ['tugas', 'pr', 'event', 'Tugas', 'PR', 'Event']);
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
        ]);
    }
}