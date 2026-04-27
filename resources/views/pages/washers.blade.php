@extends('layout')

@section('washers')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-center gap-4 mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            Washer Commissions
        </h2>

        {{-- Date range picker --}}
        <form method="GET" action="{{ route('washer_dashboard') }}" class="flex items-center gap-2">
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

    {{-- Summary totals --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Washes</p>
            <p class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                {{ $washers->sum('washes_count') }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Revenue</p>
            <p class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                ₾{{ number_format($washers->sum('total_amount'), 2) }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Commissions</p>
            <p class="text-2xl font-bold text-[var(--color-brand-500)]">
                ₾{{ number_format($washers->sum('total_commission'), 2) }}
            </p>
        </div>
    </div>

    {{-- Washer cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($washers as $washer)
            <a href="{{ route('washer.single', ['washer_id' => $washer->id, 'from' => $from->toDateString(), 'to' => $to->toDateString()]) }}"
               class="block rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                      bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5
                      hover:border-[var(--color-brand-400)] hover:shadow-sm transition-all group">

                {{-- Avatar + name --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full
                                bg-[var(--color-brand-50)] dark:bg-[var(--color-brand-900)]/40
                                flex items-center justify-center shrink-0
                                text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)] font-bold text-sm">
                        {{ strtoupper(substr($washer->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm truncate text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  group-hover:text-[var(--color-brand-500)] transition-colors">
                            {{ $washer->name }}
                        </p>
                        <span class="inline-block text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                     bg-[var(--color-brand-50)] dark:bg-[var(--color-brand-900)]/30
                                     text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)]">
                            {{ $washer->commission }}% rate
                        </span>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="space-y-2 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] pt-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Washes</span>
                        <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                            {{ $washer->washes_count }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Revenue</span>
                        <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                            ₾{{ number_format($washer->total_amount ?? 0, 2) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Commission</span>
                        <span class="font-bold text-[var(--color-brand-500)]">
                            ₾{{ number_format($washer->total_commission ?? 0, 2) }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                        bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-10 text-center">
                <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">No washers found.</p>
            </div>
        @endforelse
    </div>

</section>

@endsection
