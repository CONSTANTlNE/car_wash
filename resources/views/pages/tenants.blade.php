@extends('layout')

@section('tenants')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            სამრეცხაოები
        </h2>
        <button type="button" onclick="document.getElementById('create-tenant-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            სამრეცხაოს დამატება
        </button>
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
                        <th class="px-5 py-3">კომპანია</th>
                        <th class="px-5 py-3">მობილური</th>
                        <th class="px-5 py-3">მისამართი</th>
                        <th class="px-5 py-3">მოქმედება</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($tenants as $tenant)
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-5 py-3 font-semibold">{{ $tenant->company_name }}</td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $tenant->mobile }}
                            </td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $tenant->address ?? '—' }}
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-1.5">
                                    <button type="button"
                                            onclick="document.getElementById('edit-tenant-modal-{{ $tenant->id }}').classList.remove('hidden')"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                   hover:text-[var(--color-brand-500)] transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST"
                                          onsubmit="return confirm('სამრეცხაო წაიშლება?')">
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

                        {{-- ── Edit Tenant Modal (per-row) ── --}}
                        <div id="edit-tenant-modal-{{ $tenant->id }}"
                             class="{{ $errors->any() && old('_form') === 'edit_tenant_'.$tenant->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                             onclick="if(event.target===this) this.classList.add('hidden')">

                            <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                        bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                        სამრეცხაოს რედაქტირება
                                    </h3>
                                    <button type="button"
                                            onclick="document.getElementById('edit-tenant-modal-{{ $tenant->id }}').classList.add('hidden')"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <form action="{{ route('tenants.update', $tenant) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="_form" value="edit_tenant_{{ $tenant->id }}">

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">კომპანია</label>
                                        <input type="text" name="company_name" required
                                               value="{{ old('company_name', $tenant->company_name) }}"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        @error('company_name') @if(old('_form') === 'edit_tenant_'.$tenant->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მობილური</label>
                                        <input type="text" name="mobile" required
                                               value="{{ old('mobile', $tenant->mobile) }}"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        @error('mobile') @if(old('_form') === 'edit_tenant_'.$tenant->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მისამართი</label>
                                        <input type="text" name="address"
                                               value="{{ old('address', $tenant->address) }}"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                    </div>


                                    <div class="flex gap-2 pt-1">
                                        <button type="button"
                                                onclick="document.getElementById('edit-tenant-modal-{{ $tenant->id }}').classList.add('hidden')"
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

                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                სამრეცხაო არ არის დამატებული.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

{{-- ── Car Types Section ── --}}
<section class="pb-6 mt-8">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            მანქანის ტიპები
        </h2>
        <button type="button" onclick="document.getElementById('create-cartype-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            ტიპის დამატება
        </button>
    </div>

    @if($carTypes->isEmpty())
        <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">მანქანის ტიპი არ არის დამატებული.</p>
    @else
        <div class="flex flex-wrap gap-3">
            @foreach($carTypes as $ct)
                <div class="flex items-center gap-2 px-4 py-2 rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]">
                    <span class="text-sm font-medium text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $ct->name }}</span>
                    <button type="button"
                            onclick="document.getElementById('edit-cartype-modal-{{ $ct->id }}').classList.remove('hidden')"
                            class="flex items-center justify-center w-6 h-6 rounded-lg
                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                   hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                   hover:text-[var(--color-brand-500)] transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <form action="{{ route('car-types.destroy', $ct) }}" method="POST"
                          onsubmit="return confirm('{{ $ct->name }} წაიშლება?')">
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

                {{-- Edit CarType Modal --}}
                <div id="edit-cartype-modal-{{ $ct->id }}"
                     class="{{ $errors->any() && old('_form') === 'edit_cartype_'.$ct->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                     onclick="if(event.target===this) this.classList.add('hidden')">

                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                ტიპის რედაქტირება
                            </h3>
                            <button type="button"
                                    onclick="document.getElementById('edit-cartype-modal-{{ $ct->id }}').classList.add('hidden')"
                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('car-types.update', $ct) }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="_form" value="edit_cartype_{{ $ct->id }}">

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                                <input type="text" name="name" required
                                       value="{{ old('name', $ct->name) }}"
                                       class="w-full rounded-xl px-4 py-2.5 text-sm
                                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                @error('name') @if(old('_form') === 'edit_cartype_'.$ct->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                            </div>

                            <div class="flex gap-2 pt-1">
                                <button type="button"
                                        onclick="document.getElementById('edit-cartype-modal-{{ $ct->id }}').classList.add('hidden')"
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
    @endif

</section>

{{-- ── Create CarType Modal ── --}}
<div id="create-cartype-modal"
     class="{{ $errors->any() && old('_form') === 'create_cartype' ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                ტიპის დამატება
            </h3>
            <button type="button" onclick="document.getElementById('create-cartype-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('car-types.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create_cartype">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('name') @if(old('_form') === 'create_cartype') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-cartype-modal').classList.add('hidden')"
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

{{-- ── Wash Types Section ── --}}
<section class="pb-6 mt-8">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            რეცხვის ტიპები
        </h2>
        <button type="button" onclick="document.getElementById('create-washtype-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            ტიპის დამატება
        </button>
    </div>

    @if($washTypes->isEmpty())
        <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">რეცხვის ტიპი არ არის დამატებული.</p>
    @else
        <div class="flex flex-wrap gap-3">
            @foreach($washTypes as $wt)
                <div class="flex items-center gap-2 px-4 py-2 rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]">
                    <span class="text-sm font-medium text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $wt->wash_type }}</span>
                    @if(!$wt->is_active)
                        <span class="text-[10px] font-semibold uppercase tracking-wider px-1.5 py-0.5 rounded-lg
                                     bg-rose-50 dark:bg-rose-900/20 text-rose-500">
                            არააქტიური
                        </span>
                    @endif
                    <button type="button"
                            onclick="document.getElementById('edit-washtype-modal-{{ $wt->id }}').classList.remove('hidden')"
                            class="flex items-center justify-center w-6 h-6 rounded-lg
                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                   hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                   hover:text-[var(--color-brand-500)] transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <form action="{{ route('wash-types.destroy', $wt) }}" method="POST"
                          onsubmit="return confirm('{{ $wt->wash_type }} წაიშლება?')">
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

                {{-- Edit WashType Modal --}}
                <div id="edit-washtype-modal-{{ $wt->id }}"
                     class="{{ $errors->any() && old('_form') === 'edit_washtype_'.$wt->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                     onclick="if(event.target===this) this.classList.add('hidden')">

                    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                ტიპის რედაქტირება
                            </h3>
                            <button type="button"
                                    onclick="document.getElementById('edit-washtype-modal-{{ $wt->id }}').classList.add('hidden')"
                                    class="flex items-center justify-center w-7 h-7 rounded-lg
                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('wash-types.update', $wt) }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="_form" value="edit_washtype_{{ $wt->id }}">

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                                <input type="text" name="wash_type" required
                                       value="{{ old('wash_type', $wt->wash_type) }}"
                                       class="w-full rounded-xl px-4 py-2.5 text-sm
                                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                @error('wash_type') @if(old('_form') === 'edit_washtype_'.$wt->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" id="is_active_edit_{{ $wt->id }}" value="1"
                                       {{ old('is_active', $wt->is_active) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-[var(--color-brand-500)]">
                                <label for="is_active_edit_{{ $wt->id }}"
                                       class="text-sm text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                    აქტიური
                                </label>
                            </div>

                            <div class="flex gap-2 pt-1">
                                <button type="button"
                                        onclick="document.getElementById('edit-washtype-modal-{{ $wt->id }}').classList.add('hidden')"
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
    @endif

</section>

{{-- ── Wash Prices Section ── --}}
<section class="pb-6 mt-8">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            ფასები
        </h2>
    </div>

    @if($carTypes->isEmpty() || $washTypes->isEmpty())
        <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            ფასების დასამატებლად საჭიროა მანქანის ტიპი და რეცხვის ტიპი.
        </p>
    @else
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-left text-[10px] uppercase tracking-widest
                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                            <th class="px-5 py-3">რეცხვის ტიპი</th>
                            @foreach($carTypes as $ct)
                                <th class="px-5 py-3">{{ $ct->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                        @foreach($washTypes as $wt)
                            <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                                <td class="px-5 py-3 font-medium text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                    {{ $wt->wash_type }}
                                </td>
                                @foreach($carTypes as $ct)
                                    @php $price = $washPrices[$ct->id.'_'.$wt->id] ?? null; @endphp
                                    <td class="px-5 py-3">
                                        @if($price)
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                                    {{ number_format($price->price, 2) }}
                                                </span>
                                                <button type="button"
                                                        onclick="document.getElementById('edit-price-modal-{{ $price->id }}').classList.remove('hidden')"
                                                        class="flex items-center justify-center w-6 h-6 rounded-lg
                                                               text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                               hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                               hover:text-[var(--color-brand-500)] transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('wash-prices.destroy', $price) }}" method="POST"
                                                      onsubmit="return confirm('ფასი წაიშლება?')">
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

                                            {{-- Edit Price Modal --}}
                                            <div id="edit-price-modal-{{ $price->id }}"
                                                 class="{{ $errors->any() && old('_form') === 'edit_price_'.$price->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                                 onclick="if(event.target===this) this.classList.add('hidden')">

                                                <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                                    <div class="flex items-center justify-between mb-5">
                                                        <div>
                                                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                                                ფასის რედაქტირება
                                                            </h3>
                                                            <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mt-0.5">
                                                                {{ $ct->name }} · {{ $wt->wash_type }}
                                                            </p>
                                                        </div>
                                                        <button type="button"
                                                                onclick="document.getElementById('edit-price-modal-{{ $price->id }}').classList.add('hidden')"
                                                                class="flex items-center justify-center w-7 h-7 rounded-lg
                                                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                                       hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('wash-prices.update', $price) }}" method="POST" class="space-y-4">
                                                        @csrf
                                                        <input type="hidden" name="_form" value="edit_price_{{ $price->id }}">

                                                        <div>
                                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ფასი</label>
                                                            <input type="number" name="price" step="0.01" min="0" required
                                                                   value="{{ old('price', $price->price) }}"
                                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                            @error('price') @if(old('_form') === 'edit_price_'.$price->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                                        </div>

                                                        <div class="flex gap-2 pt-1">
                                                            <button type="button"
                                                                    onclick="document.getElementById('edit-price-modal-{{ $price->id }}').classList.add('hidden')"
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
                                        @else
                                            <button type="button"
                                                    onclick="document.getElementById('create-price-modal-{{ $ct->id }}-{{ $wt->id }}').classList.remove('hidden')"
                                                    class="flex items-center justify-center w-6 h-6 rounded-lg
                                                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                           hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                           hover:text-[var(--color-brand-500)] transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>

                                            {{-- Create Price Modal for this cell --}}
                                            <div id="create-price-modal-{{ $ct->id }}-{{ $wt->id }}"
                                                 class="{{ $errors->any() && old('_form') === 'create_price_'.$ct->id.'_'.$wt->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                                 onclick="if(event.target===this) this.classList.add('hidden')">

                                                <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                                    <div class="flex items-center justify-between mb-5">
                                                        <div>
                                                            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                                                ფასის დამატება
                                                            </h3>
                                                            <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mt-0.5">
                                                                {{ $ct->name }} · {{ $wt->wash_type }}
                                                            </p>
                                                        </div>
                                                        <button type="button"
                                                                onclick="document.getElementById('create-price-modal-{{ $ct->id }}-{{ $wt->id }}').classList.add('hidden')"
                                                                class="flex items-center justify-center w-7 h-7 rounded-lg
                                                                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                                       hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('wash-prices.store') }}" method="POST" class="space-y-4">
                                                        @csrf
                                                        <input type="hidden" name="_form" value="create_price_{{ $ct->id }}_{{ $wt->id }}">
                                                        <input type="hidden" name="car_type_id" value="{{ $ct->id }}">
                                                        <input type="hidden" name="wash_type_id" value="{{ $wt->id }}">

                                                        <div>
                                                            <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ფასი</label>
                                                            <input type="number" name="price" step="0.01" min="0" required
                                                                   value="{{ old('price') }}"
                                                                   class="w-full rounded-xl px-4 py-2.5 text-sm
                                                                          bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                                          outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                                            @error('price') @if(old('_form') === 'create_price_'.$ct->id.'_'.$wt->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                                        </div>

                                                        <div class="flex gap-2 pt-1">
                                                            <button type="button"
                                                                    onclick="document.getElementById('create-price-modal-{{ $ct->id }}-{{ $wt->id }}').classList.add('hidden')"
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
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</section>

{{-- ── Create WashType Modal ── --}}
<div id="create-washtype-modal"
     class="{{ $errors->any() && old('_form') === 'create_washtype' ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                რეცხვის ტიპის დამატება
            </h3>
            <button type="button" onclick="document.getElementById('create-washtype-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('wash-types.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create_washtype">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                <input type="text" name="wash_type" value="{{ old('wash_type') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('wash_type') @if(old('_form') === 'create_washtype') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active_create" value="1" checked
                       class="w-4 h-4 rounded accent-[var(--color-brand-500)]">
                <label for="is_active_create"
                       class="text-sm text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                    აქტიური
                </label>
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-washtype-modal').classList.add('hidden')"
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

{{-- ── Create Tenant Modal ── --}}
<div id="create-tenant-modal"
     class="{{ $errors->any() && old('_form') === 'create_tenant' ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                სამრეცხაოს დამატება
            </h3>
            <button type="button" onclick="document.getElementById('create-tenant-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('tenants.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="create_tenant">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">კომპანია</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('company_name') @if(old('_form') === 'create_tenant') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მობილური</label>
                <input type="text" name="mobile" value="{{ old('mobile') }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('mobile') @if(old('_form') === 'create_tenant') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მისამართი</label>
                <input type="text" name="address" value="{{ old('address') }}"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>



            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-tenant-modal').classList.add('hidden')"
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

@endsection
