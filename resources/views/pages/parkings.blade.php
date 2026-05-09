@extends('layout')

@section('parkings')

<section class="pb-6 space-y-6">

    {{-- ── Parking Fee Settings ── --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                ტარიფები
            </h2>
            <button type="button" onclick="document.getElementById('create-fee-modal').classList.remove('hidden')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                           bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                ტარიფის დამატება
            </button>
        </div>

        @if($parkingFees->isEmpty())
            <div class="rounded-2xl border border-dashed border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                        p-6 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                ტარიფი არ არის დამატებული.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($parkingFees as $fee)
                    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                        bg-[var(--color-brand-50)] dark:bg-[var(--color-brand-900)]/30
                                        text-[var(--color-brand-500)]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button"
                                        onclick="document.getElementById('edit-fee-modal-{{ $fee->id }}').classList.remove('hidden')"
                                        class="flex items-center justify-center w-6 h-6 rounded-lg
                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                               hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                               hover:text-[var(--color-brand-500)] transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('parking-fees.destroy', $fee) }}" method="POST"
                                      onsubmit="return confirm('ტარიფი წაიშლება?')">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center justify-center w-6 h-6 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-rose-50 dark:hover:bg-rose-900/20
                                                   hover:text-rose-500 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                            ₾{{ number_format($fee->parking_price, 2) }}
                            <span class="text-xs font-normal text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">/სთ</span>
                        </p>
                        @if($fee->free_time)
                            <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mt-1">
                                უფასო: {{ $fee->free_time }} წთ
                            </p>
                        @endif
                    </div>

                    {{-- Edit Fee Modal --}}
                    <div id="edit-fee-modal-{{ $fee->id }}"
                         class="{{ $errors->any() && old('_form') === 'edit_fee_'.$fee->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                         onclick="if(event.target===this) this.classList.add('hidden')">
                        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">ტარიფის რედაქტირება</h3>
                                <button type="button" onclick="document.getElementById('edit-fee-modal-{{ $fee->id }}').classList.add('hidden')"
                                        class="flex items-center justify-center w-7 h-7 rounded-lg
                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('parking-fees.update', $fee) }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="_form" value="edit_fee_{{ $fee->id }}">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                        უფასო დრო (წუთი)
                                    </label>
                                    <input type="number" name="free_time"
                                           value="{{ old('_form') === 'edit_fee_'.$fee->id ? old('free_time') : $fee->free_time }}"
                                           min="0" placeholder="0"
                                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                        ფასი (₾/სთ)
                                    </label>
                                    <input type="number" name="parking_price"
                                           value="{{ old('_form') === 'edit_fee_'.$fee->id ? old('parking_price') : $fee->parking_price }}"
                                           min="0" step="0.01" required
                                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                    @error('parking_price') @if(old('_form') === 'edit_fee_'.$fee->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                </div>
                                <div class="flex gap-2 pt-1">
                                    <button type="button" onclick="document.getElementById('edit-fee-modal-{{ $fee->id }}').classList.add('hidden')"
                                            class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border
                                                   border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
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
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── Parking Records ── --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                პარკინგის ჩანაწერები
            </h2>
            <button type="button" onclick="document.getElementById('create-parking-modal').classList.remove('hidden')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                           bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                ჩანაწერის დამატება
            </button>
        </div>

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
                            <th class="px-5 py-3">მომხმარებელი</th>
                            <th class="px-5 py-3">შესვლა</th>
                            <th class="px-5 py-3">გასვლა</th>
                            <th class="px-5 py-3">ხანგრძლ. (წთ)</th>
                            <th class="px-5 py-3">ტარიფი (₾/სთ)</th>
                            <th class="px-5 py-3">თანხა</th>
                            <th class="px-5 py-3">მოქმედება</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                        @forelse($parkings as $parking)
                            <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                                <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-5 py-3 font-semibold">{{ $parking->car_number ?? '—' }}</td>
                                <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $parking->user?->name ?? '—' }}</td>
                                <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                    {{ $parking->start_time?->format('d.m.Y H:i') ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                    {{ $parking->end_time?->format('d.m.Y H:i') ?? '—' }}
                                </td>
                                <td class="px-5 py-3">
                                    @if($parking->duration !== null)
                                        @php $h = intdiv((int)$parking->duration, 60); $m = (int)$parking->duration % 60; @endphp
                                        {{ $h > 0 ? $h.'სთ ' : '' }}{{ $m }}წთ
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    {{ $parking->parking_rate !== null ? '₾'.number_format($parking->parking_rate, 2) : '—' }}
                                </td>
                                <td class="px-5 py-3 font-semibold">
                                    {{ $parking->parking_fee !== null ? '₾'.number_format($parking->parking_fee, 2) : '—' }}
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1.5">
                                        @if(!$parking->end_time)
                                            <button type="button"
                                                    onclick="document.getElementById('exit-modal-{{ $parking->id }}').classList.remove('hidden')"
                                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                                           text-emerald-500
                                                           hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                                    title="გასვლა">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                            </button>
                                        @endif
                                        <button type="button"
                                                onclick="document.getElementById('edit-parking-modal-{{ $parking->id }}').classList.remove('hidden')"
                                                class="flex items-center justify-center w-7 h-7 rounded-lg
                                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                       hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                       hover:text-[var(--color-brand-500)] transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <form action="{{ route('parkings.destroy', $parking) }}" method="POST"
                                              onsubmit="return confirm('ჩანაწერი წაიშლება?')">
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

                            {{-- Edit Parking Modal --}}
                            <div id="edit-parking-modal-{{ $parking->id }}"
                                 class="{{ $errors->any() && old('_form') === 'edit_parking_'.$parking->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                 onclick="if(event.target===this) this.classList.add('hidden')">
                                <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
                                    <div class="flex items-center justify-between mb-5">
                                        <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">ჩანაწერის რედაქტირება</h3>
                                        <button type="button" onclick="document.getElementById('edit-parking-modal-{{ $parking->id }}').classList.add('hidden')"
                                                class="flex items-center justify-center w-7 h-7 rounded-lg
                                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                       hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('parkings.update', $parking) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="_form" value="edit_parking_{{ $parking->id }}">
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მანქანის ნომერი</label>
                                            <input type="text" name="car_number"
                                                   value="{{ old('_form') === 'edit_parking_'.$parking->id ? old('car_number') : $parking->car_number }}"
                                                   required placeholder="AA-000-AA"
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                            @error('car_number') @if(old('_form') === 'edit_parking_'.$parking->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მომხმარებელი</label>
                                            <select name="user_id"
                                                    class="w-full rounded-xl px-4 py-2.5 text-sm
                                                           bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                           outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                <option value="">—</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" @selected($parking->user_id == $user->id)>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">შესვლის თარიღი</label>
                                            <input type="date" name="start_date"
                                                   value="{{ old('_form') === 'edit_parking_'.$parking->id ? old('start_date') : $parking->start_time?->format('Y-m-d') }}"
                                                   required
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">შესვლის დრო</label>
                                            <input type="time" name="start_time"
                                                   value="{{ old('_form') === 'edit_parking_'.$parking->id ? old('start_time') : $parking->start_time?->format('H:i') }}"
                                                   required
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">გასვლის თარიღი</label>
                                            <input type="date" name="end_date"
                                                   value="{{ old('_form') === 'edit_parking_'.$parking->id ? old('end_date') : $parking->end_time?->format('Y-m-d') }}"
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">გასვლის დრო</label>
                                            <input type="time" name="end_time"
                                                   value="{{ old('_form') === 'edit_parking_'.$parking->id ? old('end_time') : $parking->end_time?->format('H:i') }}"
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ტარიფი</label>
                                            <select name="parking_fee_id"
                                                    class="w-full rounded-xl px-4 py-2.5 text-sm
                                                           bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                           outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
{{--                                                <option value="">— ტარიფის გარეშე —</option>--}}
                                                @foreach($parkingFees as $fee)
                                                    <option value="{{ $fee->id }}"
                                                        {{ old('parking_fee_id', $parking->parking_fee_id ?? '') == $fee->id ? 'selected' : '' }}>
                                                        ₾{{ $fee->parking_price }}/სთ · უფასო {{ $fee->free_time }} წთ
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="flex gap-2 pt-1">
                                            <button type="button" onclick="document.getElementById('edit-parking-modal-{{ $parking->id }}').classList.add('hidden')"
                                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border
                                                           border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
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

                            {{-- Exit Modal --}}
                            @if(!$parking->end_time)
                                <div id="exit-modal-{{ $parking->id }}"
                                     class="{{ $errors->any() && old('_form') === 'exit_parking_'.$parking->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                     onclick="if(event.target===this) this.classList.add('hidden')">
                                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
                                        <div class="flex items-center justify-between mb-5">
                                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">გასვლის დასტური</h3>
                                            <button type="button" onclick="document.getElementById('exit-modal-{{ $parking->id }}').classList.add('hidden')"
                                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <form action="{{ route('parkings.exit', $parking) }}" method="POST" class="space-y-4">
                                            @csrf
                                            <input type="hidden" name="_form" value="exit_parking_{{ $parking->id }}">
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">გასვლის თარიღი</label>
                                                <input type="date" name="end_date"
                                                       value="{{ old('_form') === 'exit_parking_'.$parking->id ? old('end_date') : date('Y-m-d') }}"
                                                       required
                                                       class="w-full rounded-xl px-4 py-2.5 text-sm
                                                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                @error('end_date') @if(old('_form') === 'exit_parking_'.$parking->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">გასვლის დრო</label>
                                                <input type="time" name="end_time"
                                                       value="{{ old('_form') === 'exit_parking_'.$parking->id ? old('end_time') : date('H:i') }}"
                                                       required
                                                       class="w-full rounded-xl px-4 py-2.5 text-sm
                                                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                @error('end_time') @if(old('_form') === 'exit_parking_'.$parking->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ტარიფი</label>
                                                <select name="parking_fee_id"
                                                        class="w-full rounded-xl px-4 py-2.5 text-sm
                                                               bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                    <option value="">— ტარიფის გარეშე —</option>
                                                    @foreach($parkingFees as $fee)
                                                        <option value="{{ $fee->id }}"
                                                            {{ old('_form') === 'exit_parking_'.$parking->id && old('parking_fee_id') == $fee->id ? 'selected' : '' }}>
                                                            ₾{{ $fee->parking_price }}/სთ · უფასო {{ $fee->free_time }} წთ
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="flex gap-2 pt-1 mt-2">
                                                <button type="button" onclick="document.getElementById('exit-modal-{{ $parking->id }}').classList.add('hidden')"
                                                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border
                                                               border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                               hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                    გაუქმება
                                                </button>
                                                <button type="submit"
                                                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                                               bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                                    გასვლა
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                    პარკინგის ჩანაწერი არ არის.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

{{-- ── Create Parking Fee Modal ── --}}
<div id="create-fee-modal"
     class="{{ $errors->any() && old('_form') === 'create_fee' ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">ტარიფის დამატება</h3>
            <button type="button" onclick="document.getElementById('create-fee-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('parking-fees.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create_fee">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    უფასო დრო (წუთი)
                </label>
                <input type="number" name="free_time" value="{{ old('free_time') }}" min="0" placeholder="0"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    ფასი (₾/სთ)
                </label>
                <input type="number" name="parking_price" value="{{ old('parking_price') }}"
                       min="0" step="0.01" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('parking_price') @if(old('_form') === 'create_fee') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>
            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-fee-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border
                               border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
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

{{-- ── Create Parking Record Modal ── --}}
<div id="create-parking-modal"
     class="{{ $errors->any() && old('_form') === 'create_parking' ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">ჩანაწერის დამატება</h3>
            <button type="button" onclick="document.getElementById('create-parking-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('parkings.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create_parking">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მანქანის ნომერი</label>
                <input type="text" name="car_number" value="{{ old('car_number') }}" required placeholder="AA-000-AA"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('car_number') @if(old('_form') === 'create_parking') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">შესვლის თარიღი</label>
                <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('start_date') @if(old('_form') === 'create_parking') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">შესვლის დრო</label>
                <input type="time" name="start_time" value="{{ old('start_time', date('H:i')) }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('start_time') @if(old('_form') === 'create_parking') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>
            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-parking-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border
                               border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
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

@endsection
