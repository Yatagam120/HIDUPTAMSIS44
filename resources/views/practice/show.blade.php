<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl font-extrabold">{{ $quiz['title'] }}</h1>
                <p class="text-xs opacity-75 mt-1">{{ $quiz['subtitle'] }}</p>
            </div>
            <a href="{{ route('practice.index') }}" class="px-3 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">← Pilih Materi Lain</a>
        </div>

        <div id="quiz-score-banner" class="hidden theme-card border-2 border-emerald-500/60 rounded-2xl p-5 text-center space-y-1 shadow-xl">
            <div class="text-xs uppercase tracking-wider opacity-75 font-bold">Hasil Latihan Kamu</div>
            <div id="quiz-score-text" class="text-2xl font-extrabold text-emerald-400"></div>
            <p id="quiz-score-sub" class="text-xs opacity-80"></p>
        </div>

        <form id="practice-quiz-form" class="space-y-4">
            @foreach($quiz['questions'] as $idx => $item)
                <div class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow quiz-question-card" data-answer="{{ $item['answer'] }}">
                    <div class="text-xs font-extrabold opacity-70">Soal {{ $idx + 1 }} dari {{ count($quiz['questions']) }}</div>
                    <div class="text-sm font-bold leading-relaxed">{{ $item['q'] }}</div>

                    <div class="space-y-2">
                        @foreach($item['options'] as $optIdx => $optLabel)
                            <label class="flex items-center gap-2.5 p-2.5 rounded-xl border theme-border theme-soft cursor-pointer hover:opacity-90 text-xs font-semibold quiz-option-label" data-opt="{{ $optIdx }}">
                                <input type="radio" name="q_{{ $idx }}" value="{{ $optIdx }}" class="accent-emerald-500">
                                <span><strong>{{ chr(65 + $optIdx) }}.</strong> {{ $optLabel }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="hidden quiz-explain-box p-3 rounded-xl bg-sky-500/15 border border-sky-500/35 text-xs">
                        <strong>Pembahasan:</strong> {{ $item['explain'] }}
                    </div>
                </div>
            @endforeach

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="gradePracticeQuiz()" class="theme-primary px-5 py-2.5 rounded-xl text-xs font-extrabold shadow-lg">
                    ✅ Periksa Jawaban & Hitung Skor
                </button>
                <button type="button" onclick="location.reload()" class="px-4 py-2.5 rounded-xl border theme-border theme-card text-xs font-extrabold">
                    🔄 Ulangi Latihan
                </button>
            </div>
        </form>
    </div>

    <script>
        function gradePracticeQuiz() {
            const cards = document.querySelectorAll('.quiz-question-card');
            let correct = 0;

            cards.forEach((card, idx) => {
                const ans = parseInt(card.dataset.answer, 10);
                const picked = card.querySelector(`input[name="q_${idx}"]:checked`);
                const labels = card.querySelectorAll('.quiz-option-label');
                const explain = card.querySelector('.quiz-explain-box');

                labels.forEach(lbl => {
                    lbl.classList.remove('border-emerald-500', 'bg-emerald-500/20', 'border-red-500', 'bg-red-500/20');
                    const optVal = parseInt(lbl.dataset.opt, 10);
                    if (optVal === ans) {
                        lbl.classList.add('border-emerald-500', 'bg-emerald-500/20');
                    }
                });

                if (picked) {
                    const userVal = parseInt(picked.value, 10);
                    if (userVal === ans) {
                        correct++;
                    } else if (labels[userVal]) {
                        labels[userVal].classList.add('border-red-500', 'bg-red-500/20');
                    }
                }

                if (explain) explain.classList.remove('hidden');
            });

            const total = cards.length;
            const score = Math.round((correct / total) * 100);
            const banner = document.getElementById('quiz-score-banner');
            document.getElementById('quiz-score-text').textContent = `Nilai: ${score} / 100 (${correct} dari ${total} Benar)`;
            document.getElementById('quiz-score-sub').textContent = score >= 75
                ? 'Mantap! Pemahamanmu sudah sangat kuat.'
                : 'Cek pembahasan hijau di setiap soal di bawah untuk memperdalam materi!';
            banner.classList.remove('hidden');
            banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
</x-app-layout>