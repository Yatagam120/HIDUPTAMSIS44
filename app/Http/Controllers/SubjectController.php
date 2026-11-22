<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SubjectController extends Controller
{
    private function getSubjectItemsCollection(Subject $subject)
    {
        try {
            if (method_exists($subject, 'items')) {
                return $subject->items()->latest()->get();
            }
            if (Schema::hasTable('subject_items')) {
                $query = SubjectItem::query();
                if (Schema::hasColumn('subject_items', 'subject_id')) {
                    $query->where('subject_id', $subject->id);
                }
                return $query->latest()->get();
            }
        } catch (\Throwable $e) {
            return collect();
        }

        return collect();
    }

    public function show(Request $request, Subject $subject)
    {
        $items = $this->getSubjectItemsCollection($subject);

        $activeTab = strtolower((string) $request->query('tab', 'catatan'));
        if (!in_array($activeTab, ['catatan', 'tugas', 'pr', 'event'], true)) {
            $activeTab = 'catatan';
        }

        $notifColor = (string) $request->query('notif', '');

        return view('subjects.show', compact('subject', 'items', 'activeTab', 'notifColor'));
    }

    public function storeItem(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'type'        => ['required', 'in:catatan,tugas,pr,event'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['nullable', 'date'],
        ]);

        try {
            if (method_exists($subject, 'items')) {
                $subject->items()->create([
                    'user_id'     => Auth::id(),
                    'type'        => $validated['type'],
                    'title'       => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'due_date'    => $validated['due_date'] ?? null,
                ]);
            } elseif (Schema::hasTable('subject_items')) {
                SubjectItem::create([
                    'subject_id'  => $subject->id,
                    'user_id'     => Auth::id(),
                    'type'        => $validated['type'],
                    'title'       => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'due_date'    => $validated['due_date'] ?? null,
                ]);
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['msg' => 'Gagal menyimpan postingan: ' . $e->getMessage()]);
        }

        return redirect()
            ->route('subject.show', ['subject' => $subject->id, 'tab' => $validated['type']])
            ->with('success', 'Postingan berhasil ditambahkan!');
    }

    public function updateItem(Request $request, Subject $subject, $itemId)
    {
        $item = SubjectItem::findOrFail($itemId);
        abort_unless((int) $item->user_id === (int) Auth::id(), 403, 'Hanya pembuat postingan yang dapat mengedit item ini.');

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['nullable', 'date'],
        ]);

        $item->update($validated);

        return redirect()
            ->route('subject.show', ['subject' => $subject->id, 'tab' => $item->type ?? 'catatan'])
            ->with('success', 'Postingan berhasil diperbarui!');
    }

    public function destroyItem(Subject $subject, $itemId)
    {
        $item = SubjectItem::findOrFail($itemId);
        abort_unless((int) $item->user_id === (int) Auth::id(), 403, 'Hanya pembuat postingan yang dapat menghapus item ini.');

        $tab = $item->type ?? 'catatan';
        $item->delete();

        return redirect()
            ->route('subject.show', ['subject' => $subject->id, 'tab' => $tab])
            ->with('success', 'Postingan berhasil dihapus!');
    }

    public function toggleComplete($itemId)
    {
        $item = SubjectItem::findOrFail($itemId);
        $userId = (int) Auth::id();
        $completedBy = is_array($item->completed_by ?? null)
            ? $item->completed_by
            : (json_decode($item->completed_by ?? '[]', true) ?: []);

        $intList = array_map('intval', $completedBy);
        if (in_array($userId, $intList, true)) {
            $intList = array_values(array_filter($intList, fn($id) => (int) $id !== $userId));
        } else {
            $intList[] = $userId;
        }

        $item->update(['completed_by' => $intList]);

        return back()->with('success', 'Status pengerjaan diperbarui.');
    }
}