<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\SubjectPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2020 || $year > 2099) $year = now()->year;

        $currentDate = Carbon::createFromDate($year, $month, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth   = $currentDate->copy()->endOfMonth();

        // 1. Ambil penanda manual dari tabel calendar_events
        $manualEvents = CalendarEvent::with('user')
            ->whereBetween('tanggal', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->orderBy('tanggal')
            ->get();

        // 2. Ambil juga Tugas, PR, dan Event dari mata pelajaran yang punya deadline bulan ini
        $subjectPosts = SubjectPost::with(['subject', 'user'])
            ->whereIn('kategori', ['tugas', 'pr', 'event'])
            ->whereNotNull('tanggal_deadline')
            ->whereBetween('tanggal_deadline', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->get();

        // Gabungkan semuanya berdasarkan tanggal (YYYY-MM-DD)
        $eventsByDate = [];

        foreach ($manualEvents as $ev) {
            $eventsByDate[$ev->tanggal][] = [
                'source'     => 'manual',
                'id'         => $ev->id,
                'user_id'    => $ev->user_id,
                'author'     => $ev->user->name ?? 'User',
                'kategori'   => $ev->kategori, // tugas, ulangan, acara, peringatan, lainnya
                'judul'      => $ev->judul,
                'keterangan' => $ev->keterangan,
                'url'        => null,
            ];
        }

        foreach ($subjectPosts as $post) {
            $kat = $post->kategori === 'event' ? 'acara' : 'tugas';
            $eventsByDate[$post->tanggal_deadline][] = [
                'source'     => 'subject',
                'id'         => $post->id,
                'user_id'    => $post->user_id,
                'author'     => $post->user->name ?? 'User',
                'kategori'   => $kat,
                'judul'      => '[' . ($post->subject->kode_mapel ?? 'MAPEL') . '] ' . $post->judul,
                'keterangan' => $post->deskripsi,
                'url'        => route('subject.show', ['subject' => $post->subject_id, 'tab' => $post->kategori]),
            ];
        }

        return view('calendar.index', compact('currentDate', 'eventsByDate', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => ['required', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:2099-12-31'],
            'kategori'   => ['required', 'in:tugas,ulangan,acara,peringatan,lainnya'],
            'judul'      => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        CalendarEvent::create([
            'user_id'    => Auth::id(),
            'tanggal'    => $request->tanggal,
            'kategori'   => $request->kategori,
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
        ]);

        $date = Carbon::parse($request->tanggal);
        return redirect()
            ->route('calendar.index', ['month' => $date->month, 'year' => $date->year])
            ->with('success', 'Penanda kalender berhasil ditambahkan!');
    }

    public function destroy(CalendarEvent $calendarEvent)
    {
        $user = Auth::user();
        $isAuthority = in_array($user->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']);

        abort_unless(
            $isAuthority || (int) $calendarEvent->user_id === (int) $user->id,
            403,
            'Anda tidak memiliki izin menghapus penanda ini.'
        );

        $calendarEvent->delete();
        return back()->with('success', 'Penanda kalender berhasil dihapus!');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $item = \App\Models\CalendarEvent::findOrFail($id);

        $data = $request->validate([
            'tanggal'    => 'required|date',
            'judul'      => 'required|string|max:255',
            'jenis'      => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $cols = \Illuminate\Support\Facades\Schema::getColumnListing($item->getTable());
        if (in_array('tanggal', $cols)) $item->tanggal = $data['tanggal'];
        if (in_array('date', $cols)) $item->date = $data['tanggal'];
        if (in_array('judul', $cols)) $item->judul = $data['judul'];
        if (in_array('title', $cols)) $item->title = $data['judul'];
        if (in_array('jenis', $cols) && isset($data['jenis'])) $item->jenis = $data['jenis'];
        if (in_array('type', $cols) && isset($data['jenis'])) $item->type = $data['jenis'];
        if (in_array('keterangan', $cols)) $item->keterangan = $data['keterangan'] ?? null;
        if (in_array('description', $cols)) $item->description = $data['keterangan'] ?? null;

        $item->save();

        return back()->with('success', 'Agenda kalender berhasil diperbarui!');
    }
}
