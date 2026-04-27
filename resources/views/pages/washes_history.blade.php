@extends('layout')

@section('washes_history')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            Washes History
        </h2>

        <form method="GET" action="{{ route('washes_history') }}" class="flex items-center gap-2">
            <div class="flex items-center gap-1.5">
                <label class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">From</label>
                <input type="date" name="from" value="{{ $from->toDateString() }}"
                       onchange="this.form.submit()"
                       class="rounded-xl px-3 py-1.5 text-sm
                              bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>
            <div class="flex items-center gap-1.5">
                <label class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">To</label>
                <input type="date" name="to" value="{{ $to->toDateString() }}"
                       onchange="this.form.submit()"
                       class="rounded-xl px-3 py-1.5 text-sm
                              bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>
        </form>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Washes</p>
            <p id="stat-total" class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]"
               data-value="{{ $stats['total'] }}">
                {{ $stats['total'] }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Revenue</p>
            <p id="stat-amount" class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]"
               data-value="{{ $stats['amount'] }}">
                ₾{{ number_format($stats['amount'], 2) }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Commissions</p>
            <p id="stat-commission" class="text-2xl font-bold text-[var(--color-brand-500)]"
               data-value="{{ $stats['commission'] }}">
                ₾{{ number_format($stats['commission'], 2) }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
        <div class="overflow-x-auto">
            <table id="wash-history-table" class="w-full text-sm"
                   data-from="{{ $from->toDateString() }}"
                   data-to="{{ $to->toDateString() }}"
                   data-delete-base="{{ url('/queue') }}">
                <thead>
                    <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-left text-[10px] uppercase tracking-widest
                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Car</th>
                        <th class="px-5 py-3">Wash Type</th>
                        <th class="px-5 py-3">Box</th>
                        <th class="px-5 py-3">Washer</th>
                        <th class="px-5 py-3">Amount</th>
                        <th class="px-5 py-3">Commission</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Paid</th>
                        <th class="px-5 py-3"></th>
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
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $loop->iteration }}

                                {{-- Per-row delete modal --}}
                                <div id="delete-modal-{{ $queue->id }}"
                                     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                     onclick="if(event.target===this) this.classList.add('hidden')">
                                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Delete Record</h3>
                                            <button type="button"
                                                    onclick="document.getElementById('delete-modal-{{ $queue->id }}').classList.add('hidden')"
                                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-5">
                                            Delete wash record for
                                            <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->car?->car_number }}</span>?
                                            This will also remove any linked payment.
                                        </p>

                                        <div class="flex gap-2">
                                            <button type="button"
                                                    onclick="document.getElementById('delete-modal-{{ $queue->id }}').classList.add('hidden')"
                                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                                                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                Cancel
                                            </button>
                                            <form action="{{ route('queue_delete', $queue) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                                               bg-rose-500 hover:bg-rose-600 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($queue->wash_date)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-semibold">{{ $queue->car?->car_number }}</p>
                                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">{{ $queue->car?->car_type }}</p>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">{{ $queue->wash_type }}</td>
                            <td class="px-5 py-3">{{ $queue->box?->box_number ?? '—' }}</td>
                            <td class="px-5 py-3">{{ $queue->washer?->name ?? '—' }}</td>
                            <td class="px-5 py-3 font-semibold whitespace-nowrap">₾{{ number_format($queue->wash_price, 2) }}</td>
                            <td class="px-5 py-3 font-bold text-[var(--color-brand-500)] whitespace-nowrap">
                                ₾{{ number_format($queue->washer_commission, 2) }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold capitalize {{ $statusColor }}">
                                    {{ str_replace('_', ' ', $queue->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
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
                            <td class="px-5 py-3">
                                <button type="button"
                                        onclick="document.getElementById('delete-modal-{{ $queue->id }}').classList.remove('hidden')"
                                        class="flex items-center justify-center w-7 h-7 rounded-lg
                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                               hover:bg-rose-100 dark:hover:bg-rose-900/30 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                No washes in this date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table      = document.getElementById('wash-history-table');
    const tbody      = table?.querySelector('tbody');
    const statTotal  = document.getElementById('stat-total');
    const statAmount = document.getElementById('stat-amount');
    const statComm   = document.getElementById('stat-commission');

    if (!table) return;

    const rangeFrom = table.dataset.from;
    const rangeTo   = table.dataset.to;
    const deleteBase = table.dataset.deleteBase;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const statusColors = {
        pending:     'bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400',
        in_progress: 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
        done:        'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
        cancelled:   'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400',
    };

    function formatMoney(n) {
        return '₾' + Number(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function formatDate(str) {
        const d = new Date(str + 'T00:00:00');
        return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function playChime() {
        try {
            const ctx  = new (window.AudioContext || window.webkitAudioContext)();
            const osc  = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(880, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(660, ctx.currentTime + 0.15);
            gain.gain.setValueAtTime(0.25, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.6);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.6);
        } catch {}
    }

    function buildRow(e) {
        const statusColor = statusColors[e.status] ?? 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400';
        const statusLabel = e.status.replace('_', ' ');
        const paidIcon = e.is_paid
            ? `<span class="inline-flex w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 items-center justify-center">
                   <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
               </span>`
            : `<span class="inline-block w-5 h-5 rounded-full bg-rose-500 dark:bg-rose-600"></span>`;

        const deleteUrl = `${deleteBase}/${e.id}/delete`;

        return `
        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors" data-new-row>

            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                <span class="inline-block w-2 h-2 rounded-full bg-[var(--color-brand-500)] animate-pulse"></span>

                <div id="delete-modal-${e.id}"
                     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                     onclick="if(event.target===this) this.classList.add('hidden')">
                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Delete Record</h3>
                            <button type="button" onclick="document.getElementById('delete-modal-${e.id}').classList.add('hidden')"
                                    class="flex items-center justify-center w-7 h-7 rounded-lg text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-5">
                            Delete wash record for <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">${e.car_number ?? '—'}</span>?
                            This will also remove any linked payment.
                        </p>
                        <div class="flex gap-2">
                            <button type="button" onclick="document.getElementById('delete-modal-${e.id}').classList.add('hidden')"
                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                Cancel
                            </button>
                            <form action="${deleteUrl}" method="POST">
                                <input type="hidden" name="_token" value="${csrf}">
                                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-rose-500 hover:bg-rose-600 transition-colors">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </td>

            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] whitespace-nowrap">${formatDate(e.wash_date)}</td>
            <td class="px-5 py-3">
                <p class="font-semibold">${e.car_number ?? '—'}</p>
                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">${e.car_type ?? ''}</p>
            </td>
            <td class="px-5 py-3 whitespace-nowrap">${e.wash_type ?? '—'}</td>
            <td class="px-5 py-3">${e.box_number ?? '—'}</td>
            <td class="px-5 py-3">${e.washer_name ?? '—'}</td>
            <td class="px-5 py-3 font-semibold whitespace-nowrap">${formatMoney(e.wash_price)}</td>
            <td class="px-5 py-3 font-bold text-[var(--color-brand-500)] whitespace-nowrap">${formatMoney(e.washer_commission)}</td>
            <td class="px-5 py-3">
                <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold capitalize ${statusColor}">${statusLabel}</span>
            </td>
            <td class="px-5 py-3">${paidIcon}</td>
            <td class="px-5 py-3">
                <button type="button"
                        onclick="document.getElementById('delete-modal-${e.id}').classList.remove('hidden')"
                        class="flex items-center justify-center w-7 h-7 rounded-lg text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] hover:bg-rose-100 dark:hover:bg-rose-900/30 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        </tr>`;
    }

    function updateStats(price, commission) {
        const total = statTotal;
        const amount = statAmount;
        const comm = statComm;

        if (total) {
            const n = parseInt(total.dataset.value ?? '0') + 1;
            total.dataset.value = n;
            total.textContent = n;
        }
        if (amount) {
            const n = parseFloat(amount.dataset.value ?? '0') + price;
            amount.dataset.value = n;
            amount.textContent = formatMoney(n);
        }
        if (comm) {
            const n = parseFloat(comm.dataset.value ?? '0') + commission;
            comm.dataset.value = n;
            comm.textContent = formatMoney(n);
        }
    }

    window.addEventListener('wash-queue-created', function ({ detail: e }) {
        if (e.wash_date < rangeFrom || e.wash_date > rangeTo) return;

        const emptyRow = tbody.querySelector('td[colspan]');
        if (emptyRow) emptyRow.closest('tr').remove();

        tbody.insertAdjacentHTML('afterbegin', buildRow(e));
        updateStats(e.wash_price, e.washer_commission);
        playChime();
    });
});
</script>
@endpush
