<aside id="sidebar"
       class="flex flex-col w-64 shrink-0 h-full z-40 overflow-hidden
                  bg-[var(--color-card-light)] border-r border-[var(--color-border-light)]
                  dark:bg-[var(--color-card-dark)] dark:border-[var(--color-border-dark)]
                  max-md:fixed max-md:left-0 max-md:w-64">

    {{-- Logo row --}}
    <div
        class="flex items-center gap-3 px-4 py-5 border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
        <div
            class="flex items-center justify-center w-9 h-9 rounded-xl bg-[var(--color-brand-500)] text-white shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l1.5-4.5A2 2 0 018.4 7h7.2a2 2 0 011.9 1.5L19 13M5 13H3m16 0h-2M5 13v4a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-4"/>
            </svg>
        </div>
        <span
            class="sidebar-logo-text font-bold text-lg tracking-tight text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)]">
            CarWash
        </span>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
{{--        <p class="sidebar-section-label px-2 mb-2 text-[10px] font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">--}}
{{--            Main
    </p>--}}

        @if(auth('web')->user()?->hasRole('manager') || auth('admin')->user()?->hasRole('admin'))
            @php $dashActive = request()->routeIs('queue_dashboard'); @endphp
            <a href="{{ route('queue_dashboard') }}"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                    'bg-[var(--color-brand-500)] text-white' => $dashActive,
                    'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$dashActive,
                ])>
                <svg
                    @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $dashActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$dashActive])
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9"/>
                </svg>
                <span class="nav-label">მთავარი</span>
            </a>



            @php $washerActive = request()->routeIs('washer_dashboard', 'washer.single'); @endphp
            <a href="{{ route('washer_dashboard') }}"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                    'bg-[var(--color-brand-500)] text-white' => $washerActive,
                    'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$washerActive,
                ])>
                <svg
                    @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $washerActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$washerActive])
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="nav-label">მრეცხავები</span>
            </a>

            @php $historyActive = request()->routeIs('washes_history'); @endphp
            <a href="{{ route('washes_history') }}"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                    'bg-[var(--color-brand-500)] text-white' => $historyActive,
                    'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$historyActive,
                ])>
                <svg
                    @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $historyActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$historyActive])
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 14l2 2 4-4"/>
                </svg>
                <span class="nav-label">რეცხვის ისტორია</span>
            </a>
        @endif


            @php $washerActive = request()->routeIs('payment_dashboard'); @endphp
            <a href="{{ route('payment_dashboard') }}"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                    'bg-[var(--color-brand-500)] text-white' => $washerActive,
                    'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$washerActive,
                ])>
                <span class="p-1">₾</span>
                <span class="nav-label">გადახდები</span>
            </a>
            @php $historyActive = request()->routeIs('payment.history'); @endphp
            <a href="{{ route('payment.history') }}"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                    'bg-[var(--color-brand-500)] text-white' => $historyActive,
                    'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$historyActive,
                ])>
                <svg
                    @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $historyActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$historyActive])
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 14l2 2 4-4"/>
                </svg>
                <span class="nav-label">გადახდები ისტორია</span>
            </a>



        {{--        <p class="sidebar-section-label px-2 mt-5 mb-2 text-[10px] font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">System</p>--}}


    </nav>

    {{-- Collapse toggle — desktop only --}}
    <button id="sidebar-toggle-desktop"
            class="hidden md:flex items-center justify-center w-full h-12 border-t
                       border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                       text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                       hover:text-[var(--color-brand-500)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20"
            aria-label="Toggle sidebar">
        <svg id="sidebar-footer-icon" class="w-5 h-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
</aside>
