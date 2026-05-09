@extends('layout')

@section('contractors')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            კონტრაქტორები
        </h2>
        <button type="button" onclick="document.getElementById('create-contractor-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            კონტრაქტორის დამატება
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
                        <th class="px-5 py-3">სახელი</th>
                        <th class="px-5 py-3">მობილური</th>
                        <th class="px-5 py-3">ელ-ფოსტა</th>
                        <th class="px-5 py-3">ტიპი</th>
                        <th class="px-5 py-3">მოქმედება</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($contractors as $contractor)
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-5 py-3 font-semibold">{{ $contractor->name }}</td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $contractor->mobile ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $contractor->email ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @if ($contractor->is_insurance)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                     bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400">
                                            სადაზღვევო
                                        </span>
                                    @endif
                                    @if ($contractor->is_supplier)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                     bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-400">
                                            მომწოდებელი
                                        </span>
                                    @endif
                                    @if ($contractor->is_agreement)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                     bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">
                                            ხელშეკრულება
                                        </span>
                                    @endif
                                    @if (!$contractor->is_insurance && !$contractor->is_supplier && !$contractor->is_agreement)
                                        <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-1.5">
                                    @php
                                        $type = $contractor->is_insurance ? 'is_insurance'
                                              : ($contractor->is_supplier  ? 'is_supplier'
                                              : ($contractor->is_agreement ? 'is_agreement' : ''));
                                    @endphp
                                    <button type="button"
                                            onclick="openEditContractorModal({{ $contractor->id }}, '{{ addslashes($contractor->name) }}', '{{ addslashes($contractor->mobile ?? '') }}', '{{ addslashes($contractor->email ?? '') }}', '{{ $type }}')"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                   hover:text-[var(--color-brand-500)] transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('contractors.destroy', $contractor) }}" method="POST"
                                          onsubmit="return confirm('კონტრაქტორი წაიშლება?')">
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
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                კონტრაქტორი არ არის დამატებული.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

{{-- ── Create Contractor Modal ── --}}
<div id="create-contractor-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                კონტრაქტორის დამატება
            </h3>
            <button type="button" onclick="document.getElementById('create-contractor-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('contractors.store') }}" method="POST" class="space-y-4">
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
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მობილური</label>
                <input type="text" name="mobile" value="{{ old('mobile') }}"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ელ-ფოსტა</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('email') @if(old('_form') === 'create') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="space-y-2.5 pt-1">
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">ტიპი</label>
                @foreach([['is_insurance', 'სადაზღვევო'], ['is_supplier', 'მომწოდებელი'], ['is_agreement', 'ხელშეკრულება']] as [$value, $label])
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="radio" name="type" value="{{ $value }}" required
                               @checked(old('type') === $value)
                               class="w-4 h-4 accent-[var(--color-brand-500)]">
                        <span class="text-sm text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $label }}</span>
                    </label>
                @endforeach
                @error('type') @if(old('_form') === 'create') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('create-contractor-modal').classList.add('hidden')"
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

{{-- ── Edit Contractor Modal ── --}}
<div id="edit-contractor-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                კონტრაქტორის რედაქტირება
            </h3>
            <button type="button" onclick="document.getElementById('edit-contractor-modal').classList.add('hidden')"
                    class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="edit-contractor-form" action="" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_form" value="edit">
            <input type="hidden" id="edit-contractor-id" name="contractor_id" value="">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                <input type="text" id="edit-name" name="name" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('name') @if(old('_form') === 'edit') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მობილური</label>
                <input type="text" id="edit-mobile" name="mobile"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ელ-ფოსტა</label>
                <input type="email" id="edit-email" name="email"
                       class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                @error('email') @if(old('_form') === 'edit') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="space-y-2.5 pt-1">
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">ტიპი</label>
                @foreach([['is_insurance', 'სადაზღვევო'], ['is_supplier', 'მომწოდებელი'], ['is_agreement', 'ხელშეკრულება']] as [$value, $label])
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="radio" name="type" value="{{ $value }}" required
                               class="w-4 h-4 accent-[var(--color-brand-500)] edit-type-radio">
                        <span class="text-sm text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">{{ $label }}</span>
                    </label>
                @endforeach
                @error('type') @if(old('_form') === 'edit') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
            </div>

            <div class="flex gap-2 pt-1">
                <button type="button" onclick="document.getElementById('edit-contractor-modal').classList.add('hidden')"
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
    function setEditRadio(value) {
        document.querySelectorAll('.edit-type-radio').forEach(r => { r.checked = r.value === value; });
    }

    function openEditContractorModal(id, name, mobile, email, type) {
        document.getElementById('edit-name').value   = name;
        document.getElementById('edit-mobile').value = mobile;
        document.getElementById('edit-email').value  = email;
        setEditRadio(type);
        document.getElementById('edit-contractor-id').value    = id;
        document.getElementById('edit-contractor-form').action = '/contractors/' + id + '/update';
        document.getElementById('edit-contractor-modal').classList.remove('hidden');
    }

    @if($errors->any() && old('_form') === 'create')
        document.getElementById('create-contractor-modal').classList.remove('hidden');
    @elseif($errors->any() && old('_form') === 'edit')
        document.getElementById('edit-name').value   = '{{ addslashes(old('name')) }}';
        document.getElementById('edit-mobile').value = '{{ addslashes(old('mobile')) }}';
        document.getElementById('edit-email').value  = '{{ addslashes(old('email')) }}';
        setEditRadio('{{ old('type') }}');
        document.getElementById('edit-contractor-form').action = '/contractors/{{ old('contractor_id') }}/update';
        document.getElementById('edit-contractor-modal').classList.remove('hidden');
    @endif
</script>

@endsection
