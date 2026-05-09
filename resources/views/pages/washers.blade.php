@extends('layout')

@section('washers')

@php
    $activeWashers   = $washers->where('is_active', true);
    $inactiveWashers = $washers->where('is_active', false);
@endphp

<section class="pb-6">

    {{-- Top bar: tabs + add button --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex gap-1 p-1 rounded-xl bg-[var(--color-border-light)] dark:bg-[var(--color-border-dark)]">
            <button data-tab="active"
                    class="tab-btn px-4 py-1.5 rounded-lg text-sm font-medium transition-colors">
                აქტიური
                <span class="ml-1 text-[10px] font-bold px-1.5 py-0.5 rounded-full
                             bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">
                    {{ $activeWashers->count() }}
                </span>
            </button>
            <button data-tab="inactive"
                    class="tab-btn px-4 py-1.5 rounded-lg text-sm font-medium transition-colors">
                არააქტიური
                <span class="ml-1 text-[10px] font-bold px-1.5 py-0.5 rounded-full
                             bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                    {{ $inactiveWashers->count() }}
                </span>
            </button>
        </div>

        <button type="button" onclick="document.getElementById('create-washer-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            მრეცხავის დამატება
        </button>
    </div>

    {{-- ── Tab: Active washers ── --}}
    <div id="tab-active">

        {{-- Date range picker --}}
        <div class="flex flex-wrap items-center justify-center gap-4 mb-5">
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
                    {{ $activeWashers->sum('washes_count') }}
                </p>
            </div>
            <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                        bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Revenue</p>
                <p class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                    ₾{{ number_format($activeWashers->sum('total_amount'), 2) }}
                </p>
            </div>
            <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                        bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Commissions</p>
                <p class="text-2xl font-bold text-[var(--color-brand-500)]">
                    ₾{{ number_format($activeWashers->sum('total_commission'), 2) }}
                </p>
            </div>
        </div>

        {{-- Active washer cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($activeWashers as $washer)
                <a href="{{ route('washer.single', ['washer_id' => $washer->id, 'from' => $from->toDateString(), 'to' => $to->toDateString()]) }}"
                   class="block rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                          bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5
                          hover:border-[var(--color-brand-400)] hover:shadow-sm transition-all group">

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
                    <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">აქტიური მრეცხავი არ არის.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ── Tab: Inactive washers ── --}}
    <div id="tab-inactive" class="hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($inactiveWashers as $washer)
                <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5 opacity-70">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full
                                    bg-slate-100 dark:bg-slate-800
                                    flex items-center justify-center shrink-0
                                    text-slate-500 dark:text-slate-400 font-bold text-sm">
                            {{ strtoupper(substr($washer->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-sm truncate text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                {{ $washer->name }}
                            </p>
                            <span class="inline-block text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                         bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                {{ $washer->commission }}% rate
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] pt-4">
                        <form action="{{ route('washer.toggle_active', $washer) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full px-3 py-1.5 rounded-xl text-xs font-semibold
                                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                           hover:text-emerald-600 dark:hover:text-emerald-400
                                           hover:border-emerald-300 dark:hover:border-emerald-800 transition-colors">
                                გააქტიურება
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-10 text-center">
                    <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">არააქტიური მრეცხავი არ არის.</p>
                </div>
            @endforelse
        </div>
    </div>

</section>

{{-- ── Create Washer Modal ── --}}
<div id="create-washer-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                მრეცხავის დამატება
            </h3>
            <button type="button" onclick="document.getElementById('create-washer-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('washer.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    სახელი
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('name')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    ელ-ფოსტა
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('email')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    მობილური
                </label>
                <input type="text" name="mobile" value="{{ old('mobile') }}"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    კომისიის % <span class="normal-case font-normal">(0–100)</span>
                </label>
                <div class="relative">
                    <input type="number" name="commission" value="{{ old('commission', 35) }}"
                           min="0" max="100" step="0.01" required
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

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    პაროლი
                </label>
                <input type="password" name="password" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('password')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-washer-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    გაუქმება
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                    შენახვა
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const tabs   = document.querySelectorAll('.tab-btn');
        const panels = { active: document.getElementById('tab-active'), inactive: document.getElementById('tab-inactive') };

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
            sessionStorage.setItem('washers-tab', name);
        }

        tabs.forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));

        @if($errors->any())
            switchTab('active');
            document.getElementById('create-washer-modal').classList.remove('hidden');
        @else
            switchTab(sessionStorage.getItem('washers-tab') || 'active');
        @endif
    })();
</script>

@endsection
