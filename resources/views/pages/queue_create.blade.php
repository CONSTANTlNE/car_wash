@extends('layout')


@section('queue_create')

    <section class="pb-6">

        <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4 flex justify-between justify-center">
            მანქანის დამატება
        </h2>

        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-6">
            <form class="space-y-6" action="{{route('queue_store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-center flex-wrap gap-4">
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            რეცხვის ტიპი
                        </label>
                        <select id="wash-type-select" name="wash_type" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                            <option value="">არჩევა</option>
                            @foreach($wash_types as $washtype)
                                <option value="{{$washtype->id}}">{{$washtype->wash_type}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            მანქანის ტიპი
                        </label>
                        <select id="car-type-select" name="car_type" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                            <option value="">არჩევა</option>
                            @foreach($carTypes as $ct)
                                <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            კონტრაქტორი
                        </label>
                        <select name="contractor"  class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                            <option value="">არჩევა</option>
                            @foreach($contractors as $contractor)
                                <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-3">
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            მანქანის ნომერი
                        </label>
                        <input required type="text" name="car_number"
                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent"/>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            მფლობელის მობილური
                        </label>
                        <input type="text" name="owner_mobile"
                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent"/>
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-3">
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            ბოქსის #
                        </label>
                        <select id="box-select" name="wash_box" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                            <option value="">არჩევა</option>
                            @foreach($wash_boxes as $wash_box)
                                @php $isBusy = in_array($wash_box->id, $busyBoxIds); @endphp
                                <option value="{{ $wash_box->id }}"
                                    data-washer-id="{{ $wash_box->user_id ?? '' }}"
                                    @selected(request('box') == $wash_box->id)
                                    @disabled($isBusy)>
                                    {{ $wash_box->box_number }}{{ $isBusy ? ' (busy)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            თანხა
                        </label>
                        <input type="number" id="amount-input" placeholder="" min="1" max="500"
                               name="amount" required
                               class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent"/>
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-3">
                    <div>
                        <label
                            class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                            მრეცხავები
                        </label>
                        <select id="washer-select" name="washer" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                            <option value="">არჩევა</option>
                            @foreach($washers as $washer)
                                <option value="{{$washer->id}}">{{$washer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div>
                    <label
                        class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        კომენტარი
                    </label>
                    <textarea name="comment" rows="3"
                              class="w-full rounded-xl px-4 py-2.5 text-sm resize-none
                                 bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                 border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                 text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                 placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                 outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent"></textarea>
                </div>


                {{-- Photo --}}
                <div>
                    <input id="car-photo-input" type="file" name="car_photo" accept="image/*" capture="environment" required class="hidden">
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" id="take-photo-btn"
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
                            ფოტოს გადაღება
                        </button>
                        <span id="photo-name" class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] hidden"></span>
                    </div>
                    <img id="photo-preview" src="" alt="preview" class="hidden mt-3 rounded-xl max-h-48 object-cover border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                </div>

                {{-- Actions --}}
                <div class="flex justify-center gap-4 mt-6">
                    <a href="{{route('queue_dashboard')}}"
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
                        დამატება
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

    (function () {
        const boxSelect      = document.getElementById('box-select');
        const washerSelect   = document.getElementById('washer-select');
        const washTypeSelect = document.getElementById('wash-type-select');
        const carTypeSelect  = document.getElementById('car-type-select');
        const amountInput    = document.getElementById('amount-input');

        const prices = @json($washPrices);

        function syncWasher() {
            const selected = boxSelect.options[boxSelect.selectedIndex];
            const washerId = selected ? selected.dataset.washerId : '';
            if (washerId) {
                washerSelect.value = washerId;
            }
        }

        function syncPrice() {
            const carTypeId  = carTypeSelect.value;
            const washTypeId = washTypeSelect.value;
            if (!carTypeId || !washTypeId) {
                return;
            }
            const key   = carTypeId + '_' + washTypeId;
            const price = prices[key];
            if (price !== undefined) {
                amountInput.value = price;
            }
        }

        boxSelect.addEventListener('change', syncWasher);
        carTypeSelect.addEventListener('change', syncPrice);
        washTypeSelect.addEventListener('change', syncPrice);

        if (boxSelect.value) {
            syncWasher();
        }
    })();
</script>
@endpush

@endsection
