@extends('layout')

@section('users')

<section class="pb-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
            მომხმარებლები
        </h2>
        <button type="button" onclick="document.getElementById('create-user-modal').classList.remove('hidden')"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-white
                       bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)] transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            მომხმარებლის დამატება
        </button>
    </div>

    {{-- ── Create User Modal ── --}}
    <div id="create-user-modal"
         class="{{ $errors->any() && old('_form') === 'create_user' ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         onclick="if(event.target===this) this.classList.add('hidden')">

        <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                    მომხმარებლის დამატება
                </h3>
                <button type="button" onclick="document.getElementById('create-user-modal').classList.add('hidden')"
                        class="flex items-center justify-center w-7 h-7 rounded-lg
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_form" value="create_user">

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    @error('name') @if(old('_form') === 'create_user') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ელ-ფოსტა</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    @error('email') @if(old('_form') === 'create_user') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">პაროლი</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                              outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                    @error('password') @if(old('_form') === 'create_user') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
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
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">როლი</label>
                    <select name="role" required
                            class="w-full rounded-xl px-4 py-2.5 text-sm
                               bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                        <option value="">— აირჩიეთ —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    @error('role') @if(old('_form') === 'create_user') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                </div>

                <div class="flex gap-2 pt-1">
                    <button type="button" onclick="document.getElementById('create-user-modal').classList.add('hidden')"
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
                        <th class="px-5 py-3">ელ-ფოსტა</th>
                        <th class="px-5 py-3">მობილური</th>
                        <th class="px-5 py-3">როლი</th>
                        <th class="px-5 py-3">სტატუსი</th>
                        <th class="px-5 py-3">მოქმედება</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                    @forelse ($users as $user)
                        <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-5 py-3 font-semibold">{{ $user->name }}</td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $user->email }}
                            </td>
                            <td class="px-5 py-3 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                {{ $user->mobile ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                @foreach($user->roles as $role)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                 bg-[var(--color-brand-50)] dark:bg-[var(--color-brand-900)]/30
                                                 text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)]">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                    <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                @if($user->is_active)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                        აქტიური
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400">
                                        არააქტიური
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-1.5">
                                    <button type="button"
                                            onclick="document.getElementById('edit-user-modal-{{ $user->id }}').classList.remove('hidden')"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20
                                                   hover:text-[var(--color-brand-500)] transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('მომხმარებელი წაიშლება?')">
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
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- ── Edit User Modal (per-row) ── --}}
                        <div id="edit-user-modal-{{ $user->id }}"
                             class="{{ $errors->any() && old('_form') === 'edit_user_'.$user->id ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                             onclick="if(event.target===this) this.classList.add('hidden')">

                            <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                        bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">

                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">
                                        მომხმარებლის რედაქტირება
                                    </h3>
                                    <button type="button"
                                            onclick="document.getElementById('edit-user-modal-{{ $user->id }}').classList.add('hidden')"
                                            class="flex items-center justify-center w-7 h-7 rounded-lg
                                                   text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                                                   hover:bg-[var(--color-border-light)] dark:hover:bg-[var(--color-border-dark)] transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="_form" value="edit_user_{{ $user->id }}">

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სახელი</label>
                                        <input type="text" name="name" required
                                               value="{{ old('name', $user->name) }}"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        @error('name') @if(old('_form') === 'edit_user_'.$user->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ელ-ფოსტა</label>
                                        <input type="email" name="email" required
                                               value="{{ old('email', $user->email) }}"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        @error('email') @if(old('_form') === 'edit_user_'.$user->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">პაროლი <span class="normal-case font-normal">(დასატოვებლად ცარიელი)</span></label>
                                        <input type="password" name="password"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                        @error('password') @if(old('_form') === 'edit_user_'.$user->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მობილური</label>
                                        <input type="text" name="mobile"
                                               value="{{ old('mobile', $user->mobile) }}"
                                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                                      bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                      border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                      text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                      outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">როლი</label>
                                        <select name="role" required
                                                class="w-full rounded-xl px-4 py-2.5 text-sm
                                                       bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                                       border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                                       text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                                       outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ old('role', $user->roles->first()?->name) === $role ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role') @if(old('_form') === 'edit_user_'.$user->id) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @endif @enderror
                                    </div>

                                    <div>
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="checkbox" name="is_active" value="1"
                                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                                   class="w-4 h-4 rounded accent-[var(--color-brand-500)]">
                                            <span class="text-sm text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">აქტიური</span>
                                        </label>
                                    </div>

                                    <div class="flex gap-2 pt-1">
                                        <button type="button"
                                                onclick="document.getElementById('edit-user-modal-{{ $user->id }}').classList.add('hidden')"
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
                            <td colspan="7" class="px-5 py-10 text-center text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                                მომხმარებელი არ არის დამატებული.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>



@endsection
