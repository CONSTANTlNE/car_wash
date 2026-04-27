@extends('layout')

@section('payment_history')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            Payment History
        </h2>

        <form method="GET" action="{{ route('payment.history') }}" class="flex flex-wrap items-center gap-2">
            {{-- Car number search --}}
            <div class="relative">
                <input type="text" name="car_number" value="{{ $carNumber }}"
                       placeholder="Car number..."
                       class="rounded-xl pl-8 pr-3 py-1.5 text-sm w-40
                              bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- Date range --}}
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

            <button type="submit"
                    class="px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                           bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                Search
            </button>

            @if ($carNumber)
                <a href="{{ route('payment.history', ['from' => $from->toDateString(), 'to' => $to->toDateString()]) }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-semibold
                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                          text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                          hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Payments</p>
            <p class="text-2xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                {{ $stats['total'] }}
            </p>
        </div>
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1">Total Amount</p>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                ₾{{ number_format($stats['amount'], 2) }}
            </p>
        </div>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-left text-[10px] uppercase tracking-widest
                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Date & Time</th>
                        <th class="px-5 py-3">Car</th>
                        <th class="px-5 py-3">Wash Type</th>
                        <th class="px-5 py-3">Box</th>
                        <th class="px-5 py-3">Washer</th>
                        <th class="px-5 py-3">Method</th>
                        <th class="px-5 py-3">Amount</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($payments as $payment)
                        @php
                            $methodColors = [
                                'cash'         => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                'BOG_TERMINAL' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400',
                                'TBC_TERMINAL' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-400',
                            ];
                            $methodColor = $methodColors[$payment->payment_method] ?? 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400';
                            $methodLabel = match($payment->payment_method) {
                                'BOG_TERMINAL' => 'BOG Terminal',
                                'TBC_TERMINAL' => 'TBC Terminal',
                                default        => ucfirst($payment->payment_method),
                            };
                        @endphp
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                <p>{{ $payment->created_at->format('d M Y') }}</p>
                                <p class="text-xs">{{ $payment->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-semibold">{{ $payment->washQueue?->car?->car_number }}</p>
                                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">{{ $payment->washQueue?->car?->car_type }}</p>
                            </td>
                            <td class="px-5 py-3">{{ $payment->washQueue?->wash_type ?? '—' }}</td>
                            <td class="px-5 py-3">{{ $payment->washQueue?->box?->box_number ?? '—' }}</td>
                            <td class="px-5 py-3">{{ $payment->washQueue?->washer?->name ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $methodColor }}">
                                    {{ $methodLabel }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">
                                ₾{{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="px-5 py-3">
                                <button type="button"
                                        onclick="document.getElementById('edit-payment-{{ $payment->id }}').classList.remove('hidden')"
                                        class="flex items-center justify-center w-7 h-7 rounded-lg
                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                               hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                               hover:text-[var(--color-brand-500)] transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                {{-- Per-row edit modal --}}
                                <div id="edit-payment-{{ $payment->id }}"
                                     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                     onclick="if(event.target===this) this.classList.add('hidden')">
                                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                        <div class="flex items-center justify-between mb-5">
                                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Edit Payment</h3>
                                            <button type="button"
                                                    onclick="document.getElementById('edit-payment-{{ $payment->id }}').classList.add('hidden')"
                                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="space-y-1.5 mb-5 rounded-xl bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)] p-4 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Car</span>
                                                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $payment->washQueue?->car?->car_number }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Amount</span>
                                                <span class="font-bold text-emerald-600 dark:text-emerald-400">₾{{ number_format($payment->amount, 2) }}</span>
                                            </div>
                                        </div>

                                        <form action="{{ route('queue.payment.update', $payment) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                                    Payment Method
                                                </label>
                                                <select name="payment_method" required
                                                        class="w-full rounded-xl px-4 py-2.5 text-sm
                                                               bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                    <option value="cash" @selected($payment->payment_method === 'cash')>Cash</option>
                                                    <option value="BOG_TERMINAL" @selected($payment->payment_method === 'BOG_TERMINAL')>BOG Terminal</option>
                                                    <option value="TBC_TERMINAL" @selected($payment->payment_method === 'TBC_TERMINAL')>TBC Terminal</option>
                                                </select>
                                            </div>
                                            <div class="flex gap-2">
                                                <button type="button"
                                                        onclick="document.getElementById('edit-payment-{{ $payment->id }}').classList.add('hidden')"
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                No payments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

@endsection
