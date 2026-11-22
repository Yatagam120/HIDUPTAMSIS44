<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function show(Request $request, Subject $subject)
    {
        $items = $subject->items()
            ->with('user')
            ->latest()
            ->get();

        $activeTab = $request->query('tab', 'catatan');
        if (!in_array($activeTab, ['catatan', 'tugas', 'pr', 'event'])) {
            $activeTab = 'catatan';
        }

        $notifColor = $request->query('notif', '');

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

        $subject->items()->create([
            'user_id'     => Auth::id(),
            'type'        => $validated['type'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date'    => $validated['due_date'] ?? null,
        ]);

        return redirect()
            ->route('subjects.show', ['subject' => $subject->id, 'tab' => $validated['type']])
            ->with('success', 'Postingan berhasil ditambahkan!');
    }

    public function updateItem(Request $request, Subject $subject, SubjectItem $item)
    {
        abort_unless((int) $item->user_id === (int) Auth::id(), 403, 'Hanya pembuat postingan yang dapat mengedit item ini.');

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['nullable', 'date'],
        ]);

        $item->update($validated);

        return redirect()
            ->route('subjects.show', ['subject' => $subject->id, 'tab' => $item->type])
            ->with('success', 'Postingan berhasil diperbarui!');
    }

    public function destroyItem(Subject $subject, SubjectItem $item)
    {
        abort_unless((int) $item->user_id === (int) Auth::id(), 403, 'Hanya pembuat postingan yang dapat menghapus item ini.');

        $tab = $item->type;
        $item->delete();

        return redirect()
            ->route('subjects.show', ['subject' => $subject->id, 'tab' => $tab])
            ->with('success', 'Postingan berhasil dihapus!');
    }

    public function toggleComplete(SubjectItem $item)
    {
        $userId = (int) Auth::id();
        $completedBy = is_array($item->completed_by)
            ? $item->completed_by
            : (json_decode($item->completed_by ?? '[]', true) ?: []);

        if (in_array($userId, $completedBy, true)) {
            $completedBy = array_values(array_filter($completedBy, fn($id) => (int) $id !== $userId));
        } else {
            $completedBy[] = $userId;
        }

        $item->update(['completed_by' => $completedBy]);

        return back()->with('success', 'Status pengerjaan diperbarui.');
    }
}