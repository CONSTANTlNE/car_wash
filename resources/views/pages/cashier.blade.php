@extends('layout')

@section('cashier')

    <div class="flex flex-wrap items-center justify-center gap-4 mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            სალარო
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
                        <th class="px-5 py-3">მანქანა</th>
                        <th class="px-5 py-3">რეცხვის ტიპი</th>
                        <th class="px-5 py-3">ბოქსი</th>
                        <th class="px-5 py-3">მრეცხავი</th>
                        <th class="px-5 py-3">თანხა</th>
                        <th class="px-5 py-3">გადახდის სტატუსი</th>
                        <th class="px-5 py-3">მოქმედება</th>
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
                                                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">გადახდის მიღება</h3>
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
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">მანქანა</span>
                                                    <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->car?->car_number }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">რეცხვის ტიპი</span>
                                                    <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->wash_type }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">მრეცხავი</span>
                                                    <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $queue->washer?->name ?? '—' }}</span>
                                                </div>
                                                <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                                                    <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">თანხა</span>
                                                    <span class="font-bold text-lg text-emerald-600 dark:text-emerald-400">₾{{ number_format($queue->wash_price, 2) }}</span>
                                                </div>
                                            </div>

                                            <form action="{{ route('queue.payment', $queue) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                                        გადახდის მეთოდი
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
                                                        გაუქმება
                                                    </button>
                                                    <button type="submit"
                                                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                                                   bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                                        შენახვა
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
                             ჩანაწერი არ მოიძებნა
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </section>

    {{-- Parking Section --}}
    <div class="flex flex-wrap items-center justify-center gap-4 mb-5 mt-4">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            პარკინგი
        </h2>
    </div>

    <section class="pb-6">
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
            <div class="overflow-x-auto">
                <table id="parking-table" class="w-full text-sm"
                       data-payment-base="{{ url('/parkings') }}">
                    <thead>
                    <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-left text-[10px] uppercase tracking-widest
                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">მანქანა</th>
                        <th class="px-5 py-3">შემოსვლა</th>
                        <th class="px-5 py-3">გასვლა</th>
                        <th class="px-5 py-3">დრო</th>
                        <th class="px-5 py-3">თანხა</th>
                        <th class="px-5 py-3">გადახდის სტატუსი</th>
                        <th class="px-5 py-3">მოქმედება</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($parkings as $parking)
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors" data-parking-row>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-semibold">{{ $parking->car_number }}</td>
                            <td class="px-5 py-3 text-xs">{{ $parking->start_time?->format('H:i') }}</td>
                            <td class="px-5 py-3 text-xs">{{ $parking->end_time?->format('H:i') ?? '—' }}</td>
                            <td class="px-5 py-3 text-xs">{{ $parking->duration ? round($parking->duration).'წთ' : '—' }}</td>
                            <td class="px-5 py-3 font-semibold">₾{{ number_format($parking->parking_fee, 2) }}</td>

                            <td class="px-5 py-3">
                                @if ($parking->is_paid)
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
                                @if (!$parking->is_paid && $parking->end_time)
                                    <button type="button"
                                            onclick="document.getElementById('parking-pay-modal-{{ $parking->id }}').classList.remove('hidden')"
                                            title="Collect payment"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-emerald-600 dark:text-emerald-400
                                                   hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors font-bold text-2xl">
                                        ₾
                                    </button>

                                    <div id="parking-pay-modal-{{ $parking->id }}"
                                         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                         onclick="if(event.target===this) this.classList.add('hidden')">
                                        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                            <div class="flex items-center justify-between mb-5">
                                                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">გადახდის მიღება</h3>
                                                <button type="button"
                                                        onclick="document.getElementById('parking-pay-modal-{{ $parking->id }}').classList.add('hidden')"
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
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">მანქანა</span>
                                                    <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $parking->car_number }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">დრო</span>
                                                    <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $parking->duration ? round($parking->duration).'წთ' : '—' }}</span>
                                                </div>
                                                <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                                                    <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">თანხა</span>
                                                    <span class="font-bold text-lg text-emerald-600 dark:text-emerald-400">₾{{ number_format($parking->parking_fee, 2) }}</span>
                                                </div>
                                            </div>

                                            <form action="{{ route('parkings.payment', $parking) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                                        გადახდის მეთოდი
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
                                                            onclick="document.getElementById('parking-pay-modal-{{ $parking->id }}').classList.add('hidden')"
                                                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                                                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                                   hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                        გაუქმება
                                                    </button>
                                                    <button type="submit"
                                                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                                                   bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                                        შენახვა
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
                                ჩანაწერი არ მოიძებნა
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
        sound.play().catch(err => alert('To play notification sound , you have to enable Sound Permissions in your browser'));
    });

    // Parking real-time updates
    const parkingTable = document.getElementById('parking-table');
    const parkingTbody = parkingTable?.querySelector('tbody');
    const parkingPayBase = parkingTable?.dataset.paymentBase;

    function buildParkingRow(p) {
        const rowNum = parkingTbody.querySelectorAll('tr[data-parking-row]').length + 1;
        const payUrl = `${parkingPayBase}/${p.id}/payment`;
        const duration = p.duration ? Math.round(p.duration) + 'წთ' : '—';
        const endTime = p.end_time ? new Date(p.end_time).toTimeString().slice(0, 5) : '—';
        const startTime = p.start_time ? new Date(p.start_time).toTimeString().slice(0, 5) : '—';

        return `
        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors" data-parking-row>
            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">${rowNum}</td>
            <td class="px-5 py-3 font-semibold">${p.car_number ?? '—'}</td>
            <td class="px-5 py-3 text-xs">${startTime}</td>
            <td class="px-5 py-3 text-xs">${endTime}</td>
            <td class="px-5 py-3 text-xs">${duration}</td>
            <td class="px-5 py-3 font-semibold">₾${Number(p.parking_fee).toFixed(2)}</td>
            <td class="px-5 py-3">
                <span class="inline-block w-5 h-5 rounded-full bg-rose-500 dark:bg-rose-600"></span>
            </td>
            <td class="px-3 py-3">
                <button type="button"
                        onclick="document.getElementById('parking-pay-modal-${p.id}').classList.remove('hidden')"
                        class="flex items-center justify-center w-7 h-7 rounded-lg text-emerald-600 dark:text-emerald-400
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors font-bold text-2xl">₾</button>
                <div id="parking-pay-modal-${p.id}"
                     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                     onclick="if(event.target===this) this.classList.add('hidden')">
                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">გადახდის მიღება</h3>
                            <button type="button" onclick="document.getElementById('parking-pay-modal-${p.id}').classList.add('hidden')"
                                    class="flex items-center justify-center w-7 h-7 rounded-lg text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-2 mb-5 rounded-xl bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)] p-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">მანქანა</span>
                                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">${p.car_number ?? '—'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">დრო</span>
                                <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">${duration}</span>
                            </div>
                            <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">თანხა</span>
                                <span class="font-bold text-lg text-emerald-600 dark:text-emerald-400">₾${Number(p.parking_fee).toFixed(2)}</span>
                            </div>
                        </div>
                        <form action="${payUrl}" method="POST">
                            <input type="hidden" name="_token" value="${csrf}">
                            <div class="mb-4">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">გადახდის მეთოდი</label>
                                <select name="payment_method" required
                                        class="w-full rounded-xl px-4 py-2.5 text-sm bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                    <option value="cash">Cash</option>
                                    <option value="BOG_TERMINAL">BOG_TERMINAL</option>
                                    <option value="TBC_TERMINAL">TBC_TERMINAL</option>
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" onclick="document.getElementById('parking-pay-modal-${p.id}').classList.add('hidden')"
                                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                    გაუქმება
                                </button>
                                <button type="submit"
                                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                    შენახვა
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </td>
        </tr>`;
    }

    window.addEventListener('parking-created', function ({ detail: p }) {
        if (!parkingTbody || !p.parking_fee) return;

        const emptyRow = parkingTbody.querySelector('td[colspan]');
        if (emptyRow) emptyRow.closest('tr').remove();

        parkingTbody.insertAdjacentHTML('afterbegin', buildParkingRow(p));
        const sound = document.getElementById('successSound');
        sound.play().catch(() => {});
    });

    window.addEventListener('parking-paid', function ({ detail: p }) {
        const row = parkingTbody?.querySelector(`tr[data-parking-row] button[onclick*="parking-pay-modal-${p.parking_id}"]`)?.closest('tr');
        if (!row) return;
        const statusCell = row.querySelectorAll('td')[6];
        const actionCell = row.querySelectorAll('td')[7];
        if (statusCell) statusCell.innerHTML = `<span class="inline-flex w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 items-center justify-center"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>`;
        if (actionCell) actionCell.innerHTML = '';
    });
});
</script>
@endpush
