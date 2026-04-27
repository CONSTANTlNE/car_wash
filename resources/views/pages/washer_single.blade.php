@extends('layout')

@section('washer_single')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-start gap-4 mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('washer_dashboard', ['from' => $from->toDateString(), 'to' => $to->toDateString()]) }}"
               class="flex items-center justify-center w-8 h-8 rounded-xl
                      text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                      hover:bg-[var(--color-card-light)] dark:hover:bg-[var(--color-card-dark)]
                      hover:text-[var(--color-text-light)] dark:hover:text-[var(--color-text-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-full
                            bg-[var(--color-brand-50)] dark:bg-[var(--color-brand-900)]/40
                            flex items-center justify-center shrink-0
                            text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)] font-bold text-sm">
                    {{ strtoupper(substr($washer->name, 0, 2)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $washer->name }}</h2>
                        <button type="button" onclick="document.getElementById('name-modal').classList.remove('hidden')"
                                title="Edit name"
                                class="flex items-center justify-center w-5 h-5 rounded-md
                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                       hover:text-[var(--color-brand-500)] transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>

                        {{-- Active toggle --}}
                        <form action="{{ route('washer.toggle_active', $washer) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    title="{{ $washer->is_active ? 'Deactivate washer' : 'Activate washer' }}"
                                    @class([
                                        'inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full transition-colors',
                                        'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-900/50' => $washer->is_active,
                                        'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700' => !$washer->is_active,
                                    ])>
                                <span class="w-1.5 h-1.5 rounded-full {{ $washer->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $washer->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </div>
                    <button type="button" onclick="document.getElementById('commission-modal').classList.remove('hidden')"
                            class="inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                   bg-[var(--color-brand-50)] dark:bg-[var(--color-brand-900)]/30
                                   text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)]
                                   hover:bg-[var(--color-brand-100)] dark:hover:bg-[var(--color-brand-900)]/50 transition-colors">
                        {{ $washer->commission }}% commission rate
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Date range picker --}}
        <form method="GET" action="{{ route('washer.single') }}" class="flex items-center gap-2">
            <input type="hidden" name="washer_id" value="{{ $washer->id }}">
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

    {{-- Stats cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Washes</p>
            <p class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                {{ $stats['washes'] }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Revenue</p>
            <p class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                ₾{{ number_format($stats['amount'], 2) }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Commission</p>
            <p class="text-2xl font-bold text-[var(--color-brand-500)]">
                ₾{{ number_format($stats['commission'], 2) }}
            </p>
        </div>
    </div>

    {{-- Queue table --}}
    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-left text-[10px] uppercase tracking-widest
                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Car</th>
                        <th class="px-5 py-3">Wash Type</th>
                        <th class="px-5 py-3">Box</th>
                        <th class="px-5 py-3">Amount</th>
                        <th class="px-5 py-3">Commission</th>
                        <th class="px-5 py-3">Status</th>
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
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ \Carbon\Carbon::parse($queue->wash_date)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-semibold">{{ $queue->car?->car_number }}</p>
                                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">{{ $queue->car?->car_type }}</p>
                            </td>
                            <td class="px-5 py-3">{{ $queue->wash_type }}</td>
                            <td class="px-5 py-3">{{ $queue->box?->box_number ?? '—' }}</td>
                            <td class="px-5 py-3 font-semibold">${{ number_format($queue->wash_price, 2) }}</td>
                            <td class="px-5 py-3 font-bold text-[var(--color-brand-500)]">
                                ${{ number_format($queue->washer_commission, 2) }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold capitalize {{ $statusColor }}">
                                    {{ str_replace('_', ' ', $queue->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                No washes in this date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

{{-- Name modal --}}
<div id="name-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                Edit Name
            </h3>
            <button type="button" onclick="document.getElementById('name-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('washer.update_name', $washer) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    Name
                </label>
                <input type="text" name="name" value="{{ $washer->name }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('name')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('name-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Commission modal --}}
<div id="commission-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                Update Commission Rate
            </h3>
            <button type="button" onclick="document.getElementById('commission-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('washer.update_commission', $washer) }}" method="POST">
            @csrf
            <input type="hidden" name="washer_id" value="{{ $washer->id }}">
            <input type="hidden" name="from" value="{{ $from->toDateString() }}">
            <input type="hidden" name="to" value="{{ $to->toDateString() }}">

            <div class="mb-5">
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    Commission Rate (%)
                </label>
                <div class="relative">
                    <input type="number" name="commission" min="0" max="100" step="0.01"
                           value="{{ $washer->commission }}"
                           class="w-full rounded-xl px-4 py-2.5 pr-10 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold
                                 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">%</span>
                </div>
                @error('commission')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('commission-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
