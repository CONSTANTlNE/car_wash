@extends('layout')

@section('products')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            პროდუქტები
        </h2>
        <button type="button" onclick="document.getElementById('create-product-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            პროდუქტის დამატება
        </button>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('products.index') }}"
          class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-4 mb-5">
        <div class="flex flex-wrap justify-center gap-2">

            {{-- Date from --}}
            <div class="flex items-center gap-1.5">
                <label class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">From</label>
                <input type="date" name="from" value="{{ $from->toDateString() }}"
                       class="rounded-xl px-3 py-1.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            {{-- Date to --}}
            <div class="flex items-center gap-1.5">
                <label class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">To</label>
                <input type="date" name="to" value="{{ $to->toDateString() }}"
                       class="rounded-xl px-3 py-1.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            {{-- Search by name --}}
            <div class="relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="პროდუქტის სახელი..."
                       class="rounded-xl pl-8 pr-3 py-1.5 text-sm w-44
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- Contractor filter --}}
            <select name="contractor_id" onchange="this.form.submit()"
                    class="rounded-xl px-3 py-1.5 text-sm
                           bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                           outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                <option value="">ყველა კონტრაქტორი</option>
                @foreach ($contractors as $c)
                    <option value="{{ $c->id }}" @selected($contractorId == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>

            {{-- Payment status filter --}}
            <select name="status" onchange="this.form.submit()"
                    class="rounded-xl px-3 py-1.5 text-sm
                           bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                           outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                <option value="">ყველა სტატუსი</option>
                <option value="unpaid"  @selected($status === 'unpaid')>გადაუხდელი</option>
                <option value="partial" @selected($status === 'partial')>ნაწილობრივ</option>
                <option value="paid"    @selected($status === 'paid')>გადახდილი</option>
            </select>

            <button type="submit"
                    class="px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                           bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
                ძებნა
            </button>

            @if($search || $contractorId || $status)
                <a href="{{ route('products.index', ['from' => $from->toDateString(), 'to' => $to->toDateString()]) }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-semibold
                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                          text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                          hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    გასუფთავება
                </a>
            @endif
        </div>
    </form>

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
                        <th class="px-5 py-3">სახელი</th>
                        <th class="px-5 py-3">კონტრაქტორი</th>
                        <th class="px-5 py-3">ფასი</th>
                        <th class="px-5 py-3">გადახდილი</th>
                        <th class="px-5 py-3">ნაშთი</th>
                        <th class="px-5 py-3">სტატუსი</th>
                        <th class="px-5 py-3">მოქმედება</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($products as $product)
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3 font-semibold">{{ $product->name }}</td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $product->contractor?->name ?? '—' }}</td>
                            <td class="px-5 py-3 font-semibold">₾{{ number_format($product->price, 2) }}</td>
                            <td class="px-5 py-3 text-emerald-600 dark:text-emerald-400 font-semibold">₾{{ number_format($product->amount_paid, 2) }}</td>
                            <td class="px-5 py-3 font-semibold
                                @if($product->balance > 0) text-rose-500 dark:text-rose-400 @else text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] @endif">
                                ₾{{ number_format($product->balance, 2) }}
                            </td>
                            <td class="px-5 py-3">
                                @if ($product->is_fully_paid)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                        გადახდილი
                                    </span>
                                @elseif ($product->amount_paid > 0)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">
                                        ნაწილობრივ
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400">
                                        გადაუხდელი
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-1.5">
                                    {{-- Pay button: admin/manager only, hide when fully paid --}}
                                    @if (!$product->is_fully_paid && (auth('web')->user()?->hasAnyRole(['admin', 'manager'])))
                                        <button type="button"
                                                onclick="document.getElementById('pay-product-modal-{{ $product->id }}').classList.remove('hidden')"
                                                title="გადახდა"
                                                class="flex items-center justify-center w-7 h-7 rounded-lg
                                                       text-emerald-600 dark:text-emerald-400
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors font-bold text-xl">
                                            ₾
                                        </button>
                                    @endif

                                    <button type="button"
                                            onclick="openEditProductModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->price }}', '{{ $product->contractor_id }}')"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                   hover:text-[var(--color-brand-500)] transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('პროდუქტი წაიშლება?')">
                                        @csrf
                                        <button type="submit"
                                                class="flex items-center justify-center w-7 h-7 rounded-lg
                                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                       hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-500 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Payment modal per product --}}
                        @if (!$product->is_fully_paid && auth('web')->user()?->hasAnyRole(['admin', 'manager']))
                            <div id="pay-product-modal-{{ $product->id }}"
                                 class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                 onclick="if(event.target===this) this.classList.add('hidden')">
                                <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                    <div class="flex items-center justify-between mb-5">
                                        <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">გადახდა</h3>
                                        <button type="button"
                                                onclick="document.getElementById('pay-product-modal-{{ $product->id }}').classList.add('hidden')"
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
                                            <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">პროდუქტი</span>
                                            <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $product->name }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">სულ</span>
                                            <span class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">₾{{ number_format($product->price, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">გადახდილი</span>
                                            <span class="text-emerald-600 dark:text-emerald-400">₾{{ number_format($product->amount_paid, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                                            <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">ნაშთი</span>
                                            <span class="font-bold text-lg text-rose-500 dark:text-rose-400">₾{{ number_format($product->balance, 2) }}</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('products.payment', $product) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                                თანხა (მაქს. ₾{{ number_format($product->balance, 2) }})
                                            </label>
                                            <input type="number" name="amount" step="0.01" min="0.01"
                                                   max="{{ $product->balance }}"
                                                   value="{{ $product->balance }}"
                                                   required
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        </div>
                                        <div>
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
                                        <div>
                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                                                შენიშვნა
                                            </label>
                                            <input type="text" name="note"
                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button"
                                                    onclick="document.getElementById('pay-product-modal-{{ $product->id }}').classList.add('hidden')"
                                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium
                                                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                გაუქმება
                                            </button>
                                            <button type="submit"
                                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                                           bg-emerald-500 hover:bg-emerald-600 transition-colors">
                                                გადახდა
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                პროდუქტი არ არის დამატებული.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Create Product Modal --}}
<div id="create-product-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">პროდუქტის დამატება</h3>
            <button type="button" onclick="document.getElementById('create-product-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('name') @if(old('_form') === 'create') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ფასი</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0.01" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('price') @if(old('_form') === 'create') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">კონტრაქტორი</label>
                <select name="contractor_id" required
                        class="w-full rounded-xl px-4 py-2.5 text-sm
                               bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    <option value="">არჩევა</option>
                    @foreach ($contractors as $contractor)
                        <option value="{{ $contractor->id }}" @selected(old('contractor_id') == $contractor->id)>{{ $contractor->name }}</option>
                    @endforeach
                </select>
                @error('contractor_id') @if(old('_form') === 'create') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-product-modal').classList.add('hidden')"
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

{{-- Edit Product Modal --}}
<div id="edit-product-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">პროდუქტის რედაქტირება</h3>
            <button type="button" onclick="document.getElementById('edit-product-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="edit-product-form" action="" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="edit">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                <input type="text" id="edit-product-name" name="name" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ფასი</label>
                <input type="number" id="edit-product-price" name="price" step="0.01" min="0.01" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">კონტრაქტორი</label>
                <select id="edit-product-contractor" name="contractor_id" required
                        class="w-full rounded-xl px-4 py-2.5 text-sm
                               bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    <option value="">არჩევა</option>
                    @foreach ($contractors as $contractor)
                        <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('edit-product-modal').classList.add('hidden')"
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
    function openEditProductModal(id, name, price, contractorId) {
        document.getElementById('edit-product-name').value           = name;
        document.getElementById('edit-product-price').value          = price;
        document.getElementById('edit-product-contractor').value     = contractorId;
        document.getElementById('edit-product-form').action          = '/products/' + id + '/update';
        document.getElementById('edit-product-modal').classList.remove('hidden');
    }

    @if($errors->any() && old('_form') === 'create')
        document.getElementById('create-product-modal').classList.remove('hidden');
    @endif
</script>

@endsection
