@extends('layout')

@section('queue_edit')

<section class="pb-6">

    <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4">
        რედაქტირება #{{ $queue->id }}
    </h2>

    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-6">
        <form class="space-y-6" action="{{ route('queue_update', $queue) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 px-4 py-3">
                    <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php $selectClass = 'w-full rounded-xl px-4 py-2.5 text-sm bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent'; @endphp
            @php $inputClass  = $selectClass . ' placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]'; @endphp

            {{-- Row 1: Wash Type + Car Type --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">რეცხცის ტიპი</label>
                    <select name="wash_type" required class="{{ $selectClass }}">
                        <option value="">არჩევა</option>
                        @foreach ($wash_types as $washtype)
                            <option value="{{ $washtype->id }}" @selected(old('wash_type', $queue->wash_type_id) == $washtype->id)>
                                {{ $washtype->wash_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    @php $currentCarTypeId = old('car_type', optional($carTypes->firstWhere('name', $queue->car?->car_type))->id); @endphp
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მანქანის ტიპი</label>
                    <select name="car_type" required class="{{ $selectClass }}">
                        <option value="">არჩევა</option>
                        @foreach ($carTypes as $ct)
                            <option value="{{ $ct->id }}" @selected($currentCarTypeId == $ct->id)>
                                {{ $ct->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 2: Car Number + Owner Mobile --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მანქანის ნომერი</label>
                    <input type="text" name="car_number" required
                           value="{{ old('car_number', $queue->car?->car_number) }}"
                           class="{{ $inputClass }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მფლობელის მობილური</label>
                    <input type="text" name="owner_mobile"
                           value="{{ old('owner_mobile', $queue->car?->owner_mobile) }}"
                           class="{{ $inputClass }}" />
                </div>
            </div>

            {{-- Row 3: Wash Box + Amount --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">ბოქსი</label>
                    <select name="wash_box" required class="{{ $selectClass }}">
                        <option value="">არჩევა</option>
                        @foreach ($wash_boxes as $wash_box)
                            @php $isBusy = in_array($wash_box->id, $busyBoxIds); @endphp
                            <option value="{{ $wash_box->id }}"
                                    @selected(old('wash_box', $queue->car_wash_box_id) == $wash_box->id)
                                    @disabled($isBusy)>
                                {{ $wash_box->box_number }}{{ $isBusy ? ' (busy)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">თანხა</label>
                    <input type="number" name="amount" required min="1" max="500"
                           value="{{ old('amount', $queue->wash_price) }}"
                           class="{{ $inputClass }}" />
                </div>
            </div>

            {{-- Row 4: Washer + Status --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">მრეცხავი</label>
                    <select name="washer" required class="{{ $selectClass }}">
                        <option value="">არჩევა</option>
                        @foreach ($washers as $washer)
                            <option value="{{ $washer->id }}" @selected(old('washer', $queue->user_id) == $washer->id)>
                                {{ $washer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">სტატუსი</label>
                    <select name="status" required class="{{ $selectClass }}">
                        @foreach (['pending', 'in_progress', 'done', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $queue->status) === $status)>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Comment --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">კომენტარი</label>
                <textarea name="comment" rows="3"
                          class="w-full rounded-xl px-4 py-2.5 text-sm resize-none
                                 bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                 border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                 text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                 placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                 outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">{{ old('comment', $queue->comment) }}</textarea>
            </div>

            {{-- Photo --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    ფოტო
                </label>
                @php $existingPhoto = $queue->getFirstMedia('car_photos'); @endphp
                @if ($existingPhoto)
                    <img id="photo-preview" src="{{ $existingPhoto->getUrl() }}" alt="car photo"
                         class="mb-3 rounded-xl max-h-48 object-cover border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                @else
                    <img id="photo-preview" src="" alt="preview"
                         class="hidden mb-3 rounded-xl max-h-48 object-cover border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                @endif
                <input id="car-photo-input" type="file" name="car_photo" accept="image/*" capture="environment" class="hidden">
                <div class="flex items-center gap-3">
                    <button type="button"
                            onclick="document.getElementById('car-photo-input').click()"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   hover:bg-[var(--color-surface-light)] dark:hover:bg-[var(--color-surface-dark)]
                                   transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $existingPhoto ? 'ფოტოს შეცვლა' : 'ფოტოს გადაღება' }}
                    </button>
                    <span id="photo-name" class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] hidden"></span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-center gap-4 mt-6">
                <a href="{{ route('queue_dashboard') }}"
                   class="px-4 py-2.5 rounded-xl text-sm font-medium
                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                          hover:bg-[var(--color-surface-light)] dark:hover:bg-[var(--color-surface-dark)]
                          transition-colors">
                    გაუქმება
                </a>
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)]
                               active:bg-[var(--color-brand-700)] transition-colors">
                    განახლება
                </button>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    (function () {
        const photoInput   = document.getElementById('car-photo-input');
        const photoPreview = document.getElementById('photo-preview');
        const photoName    = document.getElementById('photo-name');

        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) { return; }
            photoName.textContent = file.name;
            photoName.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = (e) => {
                photoPreview.src = e.target.result;
                photoPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    })();
</script>
@endpush

@endsection
