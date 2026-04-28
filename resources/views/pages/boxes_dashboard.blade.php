@extends('layout')

@section('boxes_dashboard')

<section class="pb-6">

    {{-- Tab bar --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex gap-1 p-1 rounded-xl bg-[var(--color-border-light)] dark:bg-[var(--color-border-dark)]">
            <button data-tab="queues"
                    class="tab-btn px-4 py-1.5 rounded-lg text-sm font-medium transition-colors
                           bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]
                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] shadow-sm">
                დღევანდელი ჩანაწერები
            </button>
            <button data-tab="boxes"
                    class="tab-btn px-4 py-1.5 rounded-lg text-sm font-medium transition-colors
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:text-[var(--color-text-light)] dark:hover:text-[var(--color-text-dark)]">
                ბოქსები
            </button>
        </div>

        <a href="{{ route('queue_create') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                  bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
           მანქანის დამატება
        </a>
    </div>

    {{-- ── Tab: Today's Queue ── --}}
    <div id="tab-queues">
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-left text-[10px] uppercase tracking-widest
                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">მანქანა</th>
                            <th class="px-5 py-3">რევხვის ტიპი</th>
                            <th class="px-5 py-3">ბოქსი</th>
                            <th class="px-5 py-3">მრეცხავი</th>
                            <th class="px-5 py-3">თანხა</th>
                            <th class="px-5 py-3">სტატუსი</th>
                            <th class="px-5 py-3">გადახდის სტატუსი</th>
                            <th class="px-5 py-3">მოქმედება</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                        @forelse ($queues as $queue)
                            @php
                                $statusColors = [
                                    'pending'     => 'bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400',
                                    'in_progress' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                                    'done'        => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                    'cancelled'   => 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400',
                                ];
                                $statusColor = $statusColors[$queue->status] ?? 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400';
                            @endphp
                            <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors"
                                data-queue-id="{{ $queue->id }}">
                                <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $loop->iteration }}</td>

                                <td class="px-5 py-3">
                                    <p class="font-semibold">{{ $queue->car?->car_number }}</p>
                                    <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">{{ $queue->car?->car_type }}</p>
                                </td>
                                <td class="px-5 py-3">{{ $queue->wash_type }}</td>
                                <td class="px-5 py-3">{{ $queue->box?->box_number ?? '—' }}</td>
                                <td class="px-5 py-3">{{ $queue->washer?->name ?? '—' }}</td>
                                <td class="px-5 py-3 font-semibold">₾{{ number_format($queue->wash_price, 2) }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold capitalize {{ $statusColor }}">
                                            {{ str_replace('_', ' ', $queue->status) }}
                                        </span>
                                        @if ($queue->status === 'pending')
                                            <form action="{{ route('queue_mark_washed', $queue) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Mark as washed"
                                                        class="flex items-center justify-center w-6 h-6 rounded-lg
                                                               bg-emerald-100 dark:bg-emerald-900/30
                                                               text-emerald-600 dark:text-emerald-400
                                                               hover:bg-emerald-200 dark:hover:bg-emerald-800/50 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @elseif ($queue->status === 'done')
                                            <form action="{{ route('queue_unmark_washed', $queue) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Undo — mark as pending"
                                                        class="flex items-center justify-center w-6 h-6 rounded-lg
                                                               bg-slate-100 dark:bg-slate-800
                                                               text-slate-500 dark:text-slate-400
                                                               hover:bg-amber-100 dark:hover:bg-amber-900/30
                                                               hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-3" data-paid-cell>
                                    @if ($queue->is_paid)
                                        <span class="inline-flex w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 items-center justify-center">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-block w-5 h-5 rounded-full bg-rose-500 dark:bg-rose-600"></span>
                                    @endif
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('queue_edit', $queue) }}"
                                           class="flex items-center justify-center w-7 h-7 rounded-lg
                                              text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                              hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                              hover:text-[var(--color-brand-500)] transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('queue_delete', $queue) }}" method="POST"
                                              onsubmit="return confirm('Delete this order?')">
                                            @csrf
                                            <button type="submit"
                                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                       hover:bg-rose-50 dark:hover:bg-rose-900/20
                                                       hover:text-rose-500 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                    დღეს არ არის ჩანაწერი.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── Tab: Wash Boxes ── --}}
    <div id="tab-boxes" class="hidden">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($boxes as $box)
                @php $activeQueue = $box->washQueues->first(); @endphp

                <div class="rounded-2xl border p-5 transition-all
                    {{ $activeQueue
                        ? 'border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/40'
                        : 'border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/40' }}">

                    {{-- Box header --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                {{ $activeQueue
                                    ? 'bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400'
                                    : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <span class="font-bold text-base">{{ $box->box_number }}</span>
                        </div>
                        <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                            {{ $activeQueue
                                ? 'bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400'
                                : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400' }}">
                            {{ $activeQueue ? 'Busy' : 'Free' }}
                        </span>
                    </div>

                    @if ($activeQueue)
                        {{-- Car info --}}
                        <div class="space-y-2 mt-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 shrink-0 text-rose-400 dark:text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l1.5-4.5A2 2 0 018.4 7h7.2a2 2 0 011.9 1.5L19 13M5 13H3m16 0h-2M5 13v4a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-4"/>
                                </svg>
                                <span class="text-sm font-semibold">{{ $activeQueue->car?->car_number }}</span>
                                <span class="text-xs capitalize text-rose-500 dark:text-rose-400">{{ $activeQueue->car?->car_type }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 shrink-0 text-rose-400 dark:text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span class="text-xs text-rose-700 dark:text-rose-300">{{ $activeQueue->wash_type }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 shrink-0 text-rose-400 dark:text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-xs text-rose-700 dark:text-rose-300">{{ $activeQueue->washer?->name ?? '—' }}</span>
                            </div>

                            <div class="flex items-center justify-between pt-2 mt-1 border-t border-rose-200 dark:border-rose-800">
                                <span class="text-xs font-bold text-rose-700 dark:text-rose-300">${{ number_format($activeQueue->wash_price, 2) }}</span>
                                <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                             bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400">
                                    {{ str_replace('_', ' ', $activeQueue->status) }}
                                </span>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-4">თავისუფალი</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</section>

<script>
    (function () {
        const tabs   = document.querySelectorAll('.tab-btn');
        const panels = { queues: document.getElementById('tab-queues'), boxes: document.getElementById('tab-boxes') };

        const activeClasses   = ['bg-[var(--color-card-light)]', 'dark:bg-[var(--color-card-dark)]',
                                  'text-[var(--color-text-light)]', 'dark:text-[var(--color-text-dark)]', 'shadow-sm'];
        const inactiveClasses = ['text-[var(--color-muted-light)]', 'dark:text-[var(--color-muted-dark)]',
                                  'hover:text-[var(--color-text-light)]', 'dark:hover:text-[var(--color-text-dark)]'];

        function switchTab(name) {
            tabs.forEach(btn => {
                const isActive = btn.dataset.tab === name;
                activeClasses.forEach(c => btn.classList.toggle(c, isActive));
                inactiveClasses.forEach(c => btn.classList.toggle(c, !isActive));
            });
            Object.entries(panels).forEach(([key, el]) => el.classList.toggle('hidden', key !== name));
            sessionStorage.setItem('dashboard-tab', name);
        }

        tabs.forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));

        switchTab(sessionStorage.getItem('dashboard-tab') || 'queues');
    })();
</script>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paidCheckmark = `
        <span class="inline-flex w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 items-center justify-center">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </span>`;

    window.addEventListener('wash-queue-paid', function ({ detail: e }) {
        const row = document.querySelector(`tr[data-queue-id="${e.queue_id}"]`);
        if (!row) return;

        const paidCell = row.querySelector('[data-paid-cell]');
        if (paidCell) paidCell.innerHTML = paidCheckmark;

        const sound = document.getElementById('successSound');
        // sound.play().catch(err => console.log("Audio blocked:", err));
        sound.play().catch(err => alert('To play notification sound , you have to enable Sound Permissions in your browser'));
    });
});
</script>
@endpush
