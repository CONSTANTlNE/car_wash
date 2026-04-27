@extends('layout')

@section('queue_edit')

<section class="pb-6">

    <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4">
        Edit Order #{{ $queue->id }}
    </h2>

    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-6">
        <form class="space-y-6" action="{{ route('queue_update', $queue) }}" method="POST">
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
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Wash Type</label>
                    <select name="wash_type" required class="{{ $selectClass }}">
                        <option value="">Select</option>
                        @foreach ($wash_types as $washtype)
                            <option value="{{ $washtype->id }}" @selected(old('wash_type', $queue->wash_type_id) == $washtype->id)>
                                {{ $washtype->wash_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Car Type</label>
                    <select name="car_type" required class="{{ $selectClass }}">
                        <option value="">Select</option>
                        @foreach (['sedan', 'suv', 'hatchback', 'minivan'] as $type)
                            <option value="{{ $type }}" @selected(old('car_type', $queue->car?->car_type) === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 2: Car Number + Owner Mobile --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Car Number</label>
                    <input type="text" name="car_number" required
                           value="{{ old('car_number', $queue->car?->car_number) }}"
                           class="{{ $inputClass }}" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Owner Mobile</label>
                    <input type="text" name="owner_mobile"
                           value="{{ old('owner_mobile', $queue->car?->owner_mobile) }}"
                           class="{{ $inputClass }}" />
                </div>
            </div>

            {{-- Row 3: Wash Box + Amount --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Wash Box</label>
                    <select name="wash_box" required class="{{ $selectClass }}">
                        <option value="">Select</option>
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
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Amount</label>
                    <input type="number" name="amount" required min="1" max="500"
                           value="{{ old('amount', $queue->wash_price) }}"
                           class="{{ $inputClass }}" />
                </div>
            </div>

            {{-- Row 4: Washer + Status --}}
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Washer</label>
                    <select name="washer" required class="{{ $selectClass }}">
                        <option value="">Select</option>
                        @foreach ($washers as $washer)
                            <option value="{{ $washer->id }}" @selected(old('washer', $queue->user_id) == $washer->id)>
                                {{ $washer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Status</label>
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
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">Comment</label>
                <textarea name="comment" rows="3"
                          class="w-full rounded-xl px-4 py-2.5 text-sm resize-none
                                 bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                 border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                 text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                 placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                 outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">{{ old('comment', $queue->comment) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex justify-center gap-4 mt-6">
                <a href="{{ route('queue_dashboard') }}"
                   class="px-4 py-2.5 rounded-xl text-sm font-medium
                          border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                          text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                          hover:bg-[var(--color-surface-light)] dark:hover:bg-[var(--color-surface-dark)]
                          transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)]
                               active:bg-[var(--color-brand-700)] transition-colors">
                    Update Order
                </button>
            </div>
        </form>
    </div>
</section>

@endsection
