<?php

namespace App\Http\Controllers;

use App\Models\PostAttachment;
use App\Models\PostReaction;
use App\Models\Subject;
use App\Models\SubjectPost;
use App\Services\SubjectBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubjectPostController extends Controller
{
    /**
     * Cek apakah user berhak mengedit/menghapus postingan:
     * Admin, Guru/Walas, Ketua Kelas, dan Wakil Ketua bisa mengelola semua post.
     * Murid hanya bisa mengelola post miliknya sendiri.
     */
    /**
     * Halaman List Tugas: gabungkan seluruh Tugas, PR, dan Event dari semua mata pelajaran.
     */
    public function allTasks(Request $request)
    {
        $filter = $request->query('filter', 'semua');
        $query = SubjectPost::with(['subject', 'user', 'attachments', 'reactions'])
            ->whereIn('kategori', ['tugas', 'pr', 'event']);

        if (in_array($filter, ['tugas', 'pr', 'event'])) {
            $query->where('kategori', $filter);
        }

        $tasks = $query
            ->orderByRaw('tanggal_deadline IS NULL ASC')
            ->orderBy('tanggal_deadline', 'asc')
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks', 'filter'));
    }
    private function authorizePostAccess(SubjectPost $post): void
    {
        $user = Auth::user();
        $isAuthority = in_array($user->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']);

        abort_unless(
            $isAuthority || ((int) $post->user_id === (int) $user->id),
            403,
            'Anda hanya dapat mengedit atau menghapus postingan milik Anda sendiri.'
        );
    }

    /**
     * Tampilkan halaman detail mata pelajaran beserta tab Catatan, Tugas, PR, dan Event.
     */
    public function show(Request $request, Subject $subject)
    {
        $tab = $request->query('tab', 'catatan');
        if (!in_array($tab, ['catatan', 'tugas', 'pr', 'event'])) {
            $tab = 'catatan';
        }

        $posts = SubjectPost::with(['user', 'attachments', 'reactions'])
            ->where('subject_id', $subject->id)
            ->where('kategori', $tab)
            ->latest()
            ->get();

        return view('subject.show', compact('subject', 'tab', 'posts'));
    }

    /**
     * Simpan Catatan, Tugas, PR, atau Event baru + Auto-Backup ke folder mapel.
     */
    public function store(Request $request, Subject $subject)
    {
        $request->validate([
            'kategori'         => ['required', 'in:catatan,tugas,pr,event'],
            'judul'            => ['required', 'string', 'max:255'],
            'deskripsi'        => ['nullable', 'string'],
            'tanggal_deadline' => ['nullable', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:2099-12-31'],
            'media.*'          => ['nullable', 'file', 'mimetypes:image/*,video/*', 'max:102400'],
        ]);

        $post = SubjectPost::create([
            'subject_id'       => $subject->id,
            'user_id'          => Auth::id(),
            'kategori'         => $request->kategori,
            'judul'            => $request->judul,
            'deskripsi'        => $request->deskripsi,
            'tanggal_deadline' => $request->tanggal_deadline,
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mime = $file->getMimeType() ?? '';
                $fileType = str_starts_with($mime, 'video/') ? 'video' : 'image';
                $path = $file->store('subject_posts', 'public');

                PostAttachment::create([
                    'subject_post_id' => $post->id,
                    'file_path'       => $path,
                    'file_type'       => $fileType,
                ]);
            }
        }

        // Otomatis simpan salinan fisik ke storage/app/backup_mapel/{Nama_Mapel}/{Kategori}
        SubjectBackupService::backupPost($post);

        return redirect()
            ->route('subject.show', ['subject' => $subject->id, 'tab' => $request->kategori])
            ->with('success', ucfirst($request->kategori) . ' berhasil ditambahkan & otomatis ter-backup!');
    }

    /**
     * Tampilkan halaman edit postingan.
     */
    public function edit(SubjectPost $post)
    {
        $this->authorizePostAccess($post);
        $post->load(['subject', 'attachments']);

        return view('subject.edit', compact('post'));
    }

    /**
     * Perbarui postingan + perbarui salinan backup-nya.
     */
    public function update(Request $request, SubjectPost $post)
    {
        $this->authorizePostAccess($post);

        $request->validate([
            'judul'            => ['required', 'string', 'max:255'],
            'deskripsi'        => ['nullable', 'string'],
            'tanggal_deadline' => ['nullable', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:2099-12-31'],
            'media.*'          => ['nullable', 'file', 'mimetypes:image/*,video/*', 'max:102400'],
        ]);

        $post->update([
            'judul'            => $request->judul,
            'deskripsi'        => $request->deskripsi,
            'tanggal_deadline' => $request->tanggal_deadline,
        ]);

        // Hapus lampiran lama jika dicentang untuk dihapus
        if ($request->filled('delete_attachments')) {
            $attachmentsToDelete = PostAttachment::where('subject_post_id', $post->id)
                ->whereIn('id', $request->delete_attachments)
                ->get();

            foreach ($attachmentsToDelete as $att) {
                Storage::disk('public')->delete($att->file_path);
                $att->delete();
            }
        }

        // Tambah lampiran baru jika ada
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mime = $file->getMimeType() ?? '';
                $fileType = str_starts_with($mime, 'video/') ? 'video' : 'image';
                $path = $file->store('subject_posts', 'public');

                PostAttachment::create([
                    'subject_post_id' => $post->id,
                    'file_path'       => $path,
                    'file_type'       => $fileType,
                ]);
            }
        }

        // Perbarui file backup fisik setelah diedit
        SubjectBackupService::backupPost($post);

        return redirect()
            ->route('subject.show', ['subject' => $post->subject_id, 'tab' => $post->kategori])
            ->with('success', ucfirst($post->kategori) . ' berhasil diperbarui & backup diperbarui!');
    }

    /**
     * Hapus postingan dari database web (file di folder backup_mapel tetap aman tersimpan).
     */
    public function destroy(SubjectPost $post)
    {
        $this->authorizePostAccess($post);

        $subjectId = $post->subject_id;
        $kategori  = $post->kategori;

        foreach ($post->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
            $att->delete();
        }

        $post->reactions()->delete();
        $post->delete();

        return redirect()
            ->route('subject.show', ['subject' => $subjectId, 'tab' => $kategori])
            ->with('success', ucfirst($kategori) . ' berhasil dihapus dari tampilan web (salinan backup tetap aman).');
    }

    /**
     * Toggle reaksi emoji & tanda selesai (✅) per user.
     */
    public function toggleReaction(Request $request, SubjectPost $post)
    {
        $request->validate([
            'emoji' => ['required', 'string', 'max:16'],
        ]);

        $existing = PostReaction::where('subject_post_id', $post->id)
            ->where('user_id', Auth::id())
            ->where('emoji', $request->emoji)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            PostReaction::create([
                'subject_post_id' => $post->id,
                'user_id'         => Auth::id(),
                'emoji'           => $request->emoji,
            ]);
        }

        return back();
    }
}