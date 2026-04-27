@extends('layout')

@section('cashier')

    <div class="flex flex-wrap items-center justify-center gap-4 mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            Cashier
        </h2>
    </div>

    <section class="pb-6">

        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
            <div class="overflow-x-auto">
                <table id="cashier-table" class="w-full text-sm"
                       data-payment-base="{{ url('/queue') }}">
                    <thead>
                    <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-left text-[10px] uppercase tracking-widest
                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Car</th>
                        <th class="px-5 py-3">Wash Type</th>
                        <th class="px-5 py-3">Box</th>
                        <th class="px-5 py-3">Washer</th>
                        <th class="px-5 py-3">Amount</th>
                        <th class="px-5 py-3">Paid</th>
                        <th class="px-5 py-3">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($queues as $queue)
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors" data-queue-row>
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
                                @if(!$queue->is_paid)
                                    <button type="button"
                                            onclick="document.getElementById('pay-modal-{{ $queue->id }}').classList.remove('hidden')"
                                            title="Collect payment"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-emerald-600 dark:text-emerald-400
                                                   hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors font-bold text-2xl">
                                        ₾
                                    </button>

                                    {{-- Per-row payment modal --}}
                                    <div id="pay-modal-{{ $queue->id }}"
                                         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                         onclick="if(event.target===this) this.classList.add('hidden')">

                                        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                            <div class="flex items-center justify-between mb-5">
                                                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Collect Payment</h3>
                                                <button type="button"
                                                        onclick="document.getElementById('pay-modal-{{ $queue->id }}').classList.add('hidden')"
                                                        class="flex items-center justify-center w-7 h-7 rounded-lg
                                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="space-y-2 mb-5 rounded-xl bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)] p-4 text-sm">
                                                <div class="flex justify-between">
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Car</span>
                                                    <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->car?->car_number }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Wash Type</span>
                                                    <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->wash_type }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Washer</span>
                                                    <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->washer?->name ?? '—' }}</span>
                                                </div>
                                                <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                                                    <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Amount</span>
                                                    <span class="font-bold text-lg text-emerald-600 dark:text-emerald-400">₾{{ number_format($queue->wash_price, 2) }}</span>
                                                </div>
                                            </div>

                                            <form action="{{ route('queue.payment', $queue) }}" method="POST">
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
                                                        <option value="cash">Cash</option>
                                                        <option value="BOG_TERMINAL">BOG_TERMINAL</option>
                                                        <option value="TBC_TERMINAL">TBC_TERMINAL</option>
                                                    </select>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button"
                                                            onclick="document.getElementById('pay-modal-{{ $queue->id }}').classList.add('hidden')"
                                                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                                                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                                   hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                                                   bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                                        Confirm Payment
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                No cars in the queue today.
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
    const table  = document.getElementById('cashier-table');
    const tbody  = table?.querySelector('tbody');
    if (!table) return;

    const payBase = table.dataset.paymentBase;
    const csrf    = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const today   = new Date().toISOString().slice(0, 10);

    function buildRow(e) {
        const rowNum = tbody.querySelectorAll('tr[data-queue-row]').length + 1;
        const payUrl = `${payBase}/${e.id}/payment`;

        return `
        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors" data-queue-row>
            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">${rowNum}</td>

            <td class="px-5 py-3">
                <p class="font-semibold">${e.car_number ?? '—'}</p>
                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">${e.car_type ?? ''}</p>
            </td>
            <td class="px-5 py-3">${e.wash_type ?? '—'}</td>
            <td class="px-5 py-3">${e.box_number ?? '—'}</td>
            <td class="px-5 py-3">${e.washer_name ?? '—'}</td>
            <td class="px-5 py-3 font-semibold">₾${Number(e.wash_price).toFixed(2)}</td>

            <td class="px-5 py-3">
                <span class="inline-block w-5 h-5 rounded-full bg-rose-500 dark:bg-rose-600"></span>
            </td>

            <td class="px-3 py-3">
                <button type="button"
                        onclick="document.getElementById('pay-modal-${e.id}').classList.remove('hidden')"
                        title="Collect payment"
                        class="flex items-center justify-center w-7 h-7 rounded-lg
                               text-emerald-600 dark:text-emerald-400
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors font-bold text-2xl">
                    ₾
                </button>

                <div id="pay-modal-${e.id}"
                     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                     onclick="if(event.target===this) this.classList.add('hidden')">
                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Collect Payment</h3>
                            <button type="button"
                                    onclick="document.getElementById('pay-modal-${e.id}').classList.add('hidden')"
                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-2 mb-5 rounded-xl bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)] p-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Car</span>
                                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">${e.car_number ?? '—'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Wash Type</span>
                                <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">${e.wash_type ?? '—'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Washer</span>
                                <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">${e.washer_name ?? '—'}</span>
                            </div>
                            <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Amount</span>
                                <span class="font-bold text-lg text-emerald-600 dark:text-emerald-400">₾${Number(e.wash_price).toFixed(2)}</span>
                            </div>
                        </div>

                        <form action="${payUrl}" method="POST">
                            <input type="hidden" name="_token" value="${csrf}">
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
                                    <option value="cash">Cash</option>
                                    <option value="BOG_TERMINAL">BOG_TERMINAL</option>
                                    <option value="TBC_TERMINAL">TBC_TERMINAL</option>
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="button"
                                        onclick="document.getElementById('pay-modal-${e.id}').classList.add('hidden')"
                                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                               bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                    Confirm Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </td>
        </tr>`;
    }

    window.addEventListener('wash-queue-created', function ({ detail: e }) {
        if (e.wash_date !== today) return;

        const emptyRow = tbody.querySelector('td[colspan]');
        if (emptyRow) emptyRow.closest('tr').remove();

        tbody.insertAdjacentHTML('afterbegin', buildRow(e));
        const sound = document.getElementById('successSound');
        // sound.play().catch(err => console.log("Audio blocked:", err));
        sound.play().catch(err => alert('To play notification sound , you have to enable Sound Permissions in your browser'));
    });
});
</script>
@endpush
