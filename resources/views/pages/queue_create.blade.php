@extends('layout')


@section('queue_create')

<section class="pb-6">

    <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4 flex justify-between justify-center">
        Add Car
    </h2>

    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-6">
        <form class="space-y-6" action="{{route('queue_store')}}" method="post">
            @csrf
            <div class="flex justify-center gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Wash Type
                    </label>
                    <select name="wash_type" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                        <option value="">Select</option>
                        @foreach($wash_types as $washtype)
                            <option value="{{$washtype->id}}">{{$washtype->wash_type}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Car Type
                    </label>
                    <select name="car_type" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                        <option value="">Select</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="hatchback">Hatchback</option>
                        <option value="minivan">Minivan</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-center gap-4 mt-3" >
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Car Number
                    </label>
                    <input required type="text" name="car_number"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Owner Mobile
                    </label>
                    <input type="text" name="owner_mobile"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
            </div>

            <div class="flex justify-center gap-4 mt-3" >
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Wash Box
                    </label>
                    <select name="wash_box" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                        <option value="">Select</option>
                        @foreach($wash_boxes as $wash_box)
                            @php $isBusy = in_array($wash_box->id, $busyBoxIds); @endphp
                            <option value="{{ $wash_box->id }}" @disabled($isBusy)>
                                {{ $wash_box->box_number }}{{ $isBusy ? ' (busy)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Amount
                    </label>
                    <input type="number" placeholder="" min="1" max="500"
                           name="amount" required
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
            </div>

            <div class="flex justify-center gap-4 mt-3" >
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Washers
                    </label>
                    <select name="washer" required class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                        <option value="">Select</option>
                        @foreach($washers as $washer)
                            <option value="{{$washer->id}}">{{$washer->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    Comment
                </label>
                <textarea name="comment" rows="3"
                          class="w-full rounded-xl px-4 py-2.5 text-sm resize-none
                                 bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                 border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                 text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                 placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                 outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent"></textarea>
            </div>




            {{-- Actions --}}
            <div class="flex justify-center gap-4 mt-6">
                <a  href="{{route('queue_dashboard')}}"
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
                    Save order
                </button>
            </div>
        </form>
    </div>
</section>

@endsection
