@extends('layout')

@section('boxes_dashboard')

    <section class="pb-6">

        {{-- Tab bar --}}
        <div class="flex items-center justify-between flex-wrap  mb-5">
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

{{--            <a href="{{ route('queue_create') }}"--}}
{{--               class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white--}}
{{--                  bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">--}}
{{--                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>--}}
{{--                </svg>--}}
{{--                მანქანის დამატება--}}
{{--            </a>--}}
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
                            <th class="px-5 py-3 text-center">#</th>
                            <th class="px-5 py-3 text-center">მანქანა</th>
                            <th class="px-5 py-3 text-center">რევხვის ტიპი</th>
                            <th class="px-5 py-3 text-center">ბოქსი</th>
                            <th class="px-5 py-3 text-center">მრეცხავი</th>
                            <th class="px-5 py-3 text-center">თანხა</th>
                            <th class="px-5 py-3 text-center">სტატუსი</th>
                            <th class="px-5 py-3 text-center">გადახდის სტატუსი</th>
                            <th class="px-5 py-3 text-center">მოქმედება</th>
                        </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
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
                                <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]  text-center">{{ $loop->iteration }}</td>

                                <td class="px-5 py-3 text-center">
                                    <p class="font-semibold">{{ $queue->car?->car_number }}</p>
                                    <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] capitalize">{{ $queue->car?->car_type }}</p>
                                </td>
                                <td class="px-5 py-3 text-center">{{ $queue->wash_type }}</td>
                                <td class="px-5 py-3 text-center">{{ $queue->box?->box_number ?? '—' }}</td>
                                <td class="px-5 py-3 text-center">{{ $queue->washer?->name ?? '—' }}</td>
                                <td class="px-5 py-3 font-semibold text-center">
                                    ₾{{ number_format($queue->wash_price, 2) }}</td>
                                <td class="px-5 py-3 text-center">
                                    <div class="flex flex-col justify-center items-center gap-2">
                                        <span
                                            class="inline-block px-2 py-0.5 rounded-full text-[11px] font-semibold capitalize {{ $statusColor }}">
                                            {{ str_replace('_', ' ', $queue->status) }}
                                        </span>

                                        @if ($queue->status === 'pending')
                                            <form action="{{ route('queue_mark_washed', $queue) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Mark as washed"
                                                        class="flex items-center justify-center h-6 rounded-lg
                                                               bg-emerald-100 dark:bg-emerald-900/30
                                                               text-emerald-600 dark:text-emerald-400
                                                               hover:bg-emerald-200 dark:hover:bg-emerald-800/50 transition-colors px-2">
                                                    {{--                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">--}}
                                                    {{--                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>--}}
                                                    {{--                                                    </svg>--}}
                                                    დასრულება
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
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-3 text-center" data-paid-cell>
                                    @if ($queue->is_paid)
                                        <span
                                            class="inline-flex w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 items-center justify-center">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                 stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                    @else
                                        <span
                                            class="inline-block w-5 h-5 rounded-full bg-rose-500 dark:bg-rose-600"></span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('queue_edit', $queue) }}"
                                           class="flex items-center justify-center w-7 h-7 rounded-lg
                                              text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                              hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                              hover:text-[var(--color-brand-500)] transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
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
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
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

            {{-- Boxes tab header --}}
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                    {{ $boxes->count() }} ბოქსი
                </p>
                <button type="button" onclick="document.getElementById('create-box-modal').classList.remove('hidden')"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                           bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    ბოქსის დამატება
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($boxes as $box)
                    @php $activeQueue = $box->washQueues->first(); @endphp

                    <a href="{{ $activeQueue ? route('queue_edit', $activeQueue) : route('queue_create', ['box' => $box->id]) }}"
                       class="rounded-2xl border p-5 transition-all
                    {{ $activeQueue
                        ? 'border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/40'
                        : 'border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/40' }}">

                        {{-- Box header --}}
                        <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                {{ $activeQueue
                                    ? 'bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400'
                                    : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400' }}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <span class="font-bold text-base">{{ $box->box_number }}</span>
                            </div>

                            <div class="flex items-center flex-wrap gap-1">
                            <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                {{ $activeQueue
                                    ? 'bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400'
                                    : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400' }}">
                                {{ $activeQueue ? 'დაკავებული' : 'თავისუფალი' }}
                            </span>
                                <div class="flex items-center gap-1">
                                    <button type="button"
                                            onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('washer-modal-{{ $box->id }}').classList.remove('hidden')"
                                            title="მრეცხავის მინიჭება"
                                            class="flex items-center justify-center w-6 h-6 rounded-lg
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-white/60 dark:hover:bg-white/10
                                           hover:text-[var(--color-brand-500)] transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </button>

                                    @if( (auth('web')->check() && auth('web')->user()->hasRole('admin')) || auth('admin')->check() )
                                    <button type="button"
                                            onclick="event.preventDefault(); event.stopPropagation(); openEditBoxModal({{ $box->id }}, '{{ addslashes($box->box_number) }}')"
                                            title="ბოქსის რედაქტირება"
                                            class="flex items-center justify-center w-6 h-6 rounded-lg
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-white/60 dark:hover:bg-white/10
                                           hover:text-[var(--color-brand-500)] transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    <form action="{{ route('box.destroy', $box) }}" method="POST"
                                          onclick="event.stopPropagation()"
                                          onsubmit="return confirm('ბოქსი წაიშლება?')">
                                        @csrf
                                        <button type="submit" title="ბოქსის წაშლა"
                                                class="flex items-center justify-center w-6 h-6 rounded-lg
                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                               hover:bg-white/60 dark:hover:bg-white/10
                                               hover:text-rose-500 transition-colors cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!$activeQueue)
                            <div class="flex items-center gap-2 mt-3">
                                <svg class="w-3.5 h-3.5 shrink-0 text-emerald-500 dark:text-emerald-400" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-xs text-emerald-700 dark:text-emerald-300">
                                {{ $box->washer?->name ?? '...' }}
                            </span>
                            </div>
                        @endif

                        @if ($activeQueue)
                            {{-- Car info --}}
                            <div class="space-y-2 mt-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-rose-400 dark:text-rose-500" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5 13l1.5-4.5A2 2 0 018.4 7h7.2a2 2 0 011.9 1.5L19 13M5 13H3m16 0h-2M5 13v4a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-4"/>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ $activeQueue->car?->car_number }}</span>
                                    <span
                                        class="text-xs capitalize text-rose-500 dark:text-rose-400">{{ $activeQueue->car?->car_type }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-rose-400 dark:text-rose-500" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span
                                        class="text-xs text-rose-700 dark:text-rose-300">{{ $activeQueue->wash_type }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 shrink-0 text-rose-400 dark:text-rose-500" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span
                                        class="text-xs text-rose-700 dark:text-rose-300">{{ $activeQueue->washer?->name ?? '—' }}</span>
                                </div>

                                <div
                                    class="flex items-center justify-between flex-wrap pt-2 mt-1 border-t border-rose-200 dark:border-rose-800">
                                    <span
                                        class="text-xs font-bold text-rose-700 dark:text-rose-300">₾{{ number_format($activeQueue->wash_price, 2) }}</span>
                                    <div class="flex items-center flex-wrap gap-1.5 mt-2">
                                    <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full
                                                 bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400">
                                        {{ str_replace('_', ' ', $activeQueue->status) }}
                                    </span>

                                        @if($activeQueue->status === 'pending')
                                            <form action="{{ route('queue_mark_washed', $activeQueue) }}" method="POST"
                                                  onclick="event.stopPropagation()">
                                                @csrf
                                                <button type="submit"
                                                        class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                                           bg-emerald-100 dark:bg-emerald-900/50
                                                           text-emerald-700 dark:text-emerald-400
                                                           hover:bg-emerald-200 dark:hover:bg-emerald-800/60 transition-colors">
                                                    დასრულება
                                                </button>
                                            </form>
                                        @elseif($activeQueue->status === 'done')
                                            <form action="{{ route('queue_unmark_washed', $activeQueue) }}"
                                                  method="POST"
                                                  onclick="event.stopPropagation()">
                                                @csrf
                                                <button type="submit"
                                                        class="flex items-center justify-center w-5 h-5 rounded-full
                                                           bg-slate-100 dark:bg-slate-800
                                                           text-slate-500 dark:text-slate-400
                                                           hover:bg-amber-100 dark:hover:bg-amber-900/30
                                                           hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            {{--                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-4">თავისუფალი</p>--}}
                        @endif
                    </a>

                    {{-- ── Assign Washer Modal (per-box) ── --}}
                    @php $takenWasherIds = $boxes->where('id', '!=', $box->id)->pluck('user_id')->filter()->values(); @endphp
                    <div id="washer-modal-{{ $box->id }}"
                         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                         onclick="if(event.target===this) this.classList.add('hidden')">
                        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                    {{ $box->box_number }} — მრეცხავი
                                </h3>
                                <button type="button"
                                        onclick="document.getElementById('washer-modal-{{ $box->id }}').classList.add('hidden')"
                                        class="flex items-center justify-center w-7 h-7 rounded-lg
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('box.washer', $box) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მრეცხავი</label>
                                    <select name="user_id"
                                            class="w-full rounded-xl px-4 py-2.5 text-sm
                                               bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        <option value="">— მრეცხავის გარეშე —</option>
                                        @foreach($washers as $washer)
                                            @if(!$takenWasherIds->contains($washer->id))
                                                <option value="{{ $washer->id }}"
                                                    {{ $box->user_id == $washer->id ? 'selected' : '' }}>
                                                    {{ $washer->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-2 pt-1">
                                    <button type="button"
                                            onclick="document.getElementById('washer-modal-{{ $box->id }}').classList.add('hidden')"
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

                @endforeach
            </div>
        </div>

    </section>

    {{-- ── Create Box Modal ── --}}
    <div id="create-box-modal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         onclick="if(event.target===this) this.classList.add('hidden')">

        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                    ბოქსის დამატება
                </h3>
                <button type="button" onclick="document.getElementById('create-box-modal').classList.add('hidden')"
                        class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('box.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_form" value="create_box">
                <div class="mb-5">
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        ბოქსის ნომერი
                    </label>
                    <input type="text" name="box_number" value="{{ old('box_number') }}" required autofocus
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    @error('box_number')
                    @if(old('_form') === 'create_box')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @endif
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('create-box-modal').classList.add('hidden')"
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

    {{-- ── Edit Box Modal ── --}}
    <div id="edit-box-modal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         onclick="if(event.target===this) this.classList.add('hidden')">

        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                    ბოქსის რედაქტირება
                </h3>
                <button type="button" onclick="document.getElementById('edit-box-modal').classList.add('hidden')"
                        class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="edit-box-form" action="" method="POST">
                @csrf
                <input type="hidden" name="_form" value="edit_box">
                <input type="hidden" id="edit-box-id" name="box_id" value="">
                <div class="mb-5">
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        ბოქსის ნომერი
                    </label>
                    <input type="text" id="edit-box-number" name="box_number" required
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    @error('box_number')
                    @if(old('_form') === 'edit_box')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @endif
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('edit-box-modal').classList.add('hidden')"
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
            const tabs = document.querySelectorAll('.tab-btn');
            const panels = {queues: document.getElementById('tab-queues'), boxes: document.getElementById('tab-boxes')};

            const activeClasses = ['bg-[var(--color-card-light)]', 'dark:bg-[var(--color-card-dark)]',
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

            @if($errors->has('box_number') && old('_form') === 'create_box')
            switchTab('boxes');
            document.getElementById('create-box-modal').classList.remove('hidden');
            @elseif($errors->has('box_number') && old('_form') === 'edit_box')
            switchTab('boxes');
            document.getElementById('edit-box-number').value = '{{ addslashes(old('box_number')) }}';
            document.getElementById('edit-box-form').action = '/boxes/{{ old('box_id') }}/update';
            document.getElementById('edit-box-modal').classList.remove('hidden');
            @else
            switchTab(sessionStorage.getItem('dashboard-tab') || 'queues');
            @endif
        })();

        function openEditBoxModal(boxId, boxNumber) {
            document.getElementById('edit-box-id').value = boxId;
            document.getElementById('edit-box-number').value = boxNumber;
            document.getElementById('edit-box-form').action = '/boxes/' + boxId + '/update';
            document.getElementById('edit-box-modal').classList.remove('hidden');
        }
    </script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const paidCheckmark = `
        <span class="inline-flex w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 items-center justify-center">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </span>`;

                window.addEventListener('wash-queue-paid', function ({detail: e}) {
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

@endsection
