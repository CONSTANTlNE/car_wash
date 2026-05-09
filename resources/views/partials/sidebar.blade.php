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

        @if(auth('web')->user()?->hasRole('manager') || auth('web')->user()?->hasRole('admin'))
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

            @php $tenantsActive = request()->routeIs('tenants'); @endphp
            <a href="{{ route('tenants') }}"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                    'bg-[var(--color-brand-500)] text-white' => $tenantsActive,
                    'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$tenantsActive,
                ])>

                <svg
                    @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $tenantsActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$tenantsActive])
                    xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                    <g fill="#0e0f0f">
                        <path
                            d="M59.88 46v2.5a2.5 2.5 0 0 0 2.33-3.408zm-39.76 0l-2.33-.908a2.5 2.5 0 0 0 2.33 3.408zm3.787-9.715l2.33.908zm32.186 0l-2.33.908zM59.88 43.5H20.119v5h39.762zm-38.303-8.123l-3.788 9.715l4.658 1.816l3.788-9.715zm9.782-6.686a10.5 10.5 0 0 0-9.782 6.686l4.658 1.816a5.5 5.5 0 0 1 5.124-3.502zm17.28 0H31.36v5h17.28zm9.782 6.686a10.5 10.5 0 0 0-9.783-6.686v5a5.5 5.5 0 0 1 5.125 3.502zm3.788 9.715l-3.788-9.715l-4.658 1.816l3.787 9.715z"/>
                        <path fill-rule="evenodd"
                              d="M17 66.424v2.947a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V66.5h-9q-.51 0-1-.076m36 .076v2.871a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-2.947q-.49.076-1 .076zm9.466-5.074A1.5 1.5 0 0 1 62 61.5h-8.612a.83.83 0 0 1 .445-.129h8.334q.158.001.299.055m-44.932 0a.8.8 0 0 1 .3-.055h8.333a.83.83 0 0 1 .445.129H18q-.246-.001-.466-.074"
                              clip-rule="evenodd"/>
                        <path fill-rule="evenodd"
                              d="M14 54a8 8 0 0 1 8-8h36a8 8 0 0 1 8 8v6a4 4 0 0 1-4 4H18a4 4 0 0 1-4-4zm7 1a3 3 0 1 1 6 0a3 3 0 0 1-6 0m35-3a3 3 0 1 1 0 6a3 3 0 0 1 0-6"
                              clip-rule="evenodd"/>
                        <path
                            d="M21.258 9.642a.815.815 0 0 1 1.485 0l.475 1.053q.55 1.215 1.27 2.338l1.354 2.114a4.127 4.127 0 0 1-1.884 6.034l-.182.077a4.6 4.6 0 0 1-3.552 0l-.182-.076a4.127 4.127 0 0 1-1.884-6.035l1.355-2.114q.72-1.124 1.269-2.338zm18 0a.815.815 0 0 1 1.484 0l.476 1.053q.55 1.215 1.27 2.338l1.354 2.114a4.127 4.127 0 0 1-1.884 6.034l-.182.077a4.6 4.6 0 0 1-3.552 0l-.182-.076a4.127 4.127 0 0 1-1.884-6.035l1.355-2.114q.72-1.124 1.269-2.338zm18 0a.815.815 0 0 1 1.484 0l.476 1.053q.55 1.215 1.27 2.338l1.354 2.114a4.127 4.127 0 0 1-1.884 6.034l-.182.077a4.6 4.6 0 0 1-3.552 0l-.182-.076a4.127 4.127 0 0 1-1.884-6.035l1.355-2.114q.72-1.124 1.269-2.338z"/>
                    </g>
                </svg>
                <span class="nav-label">სამრეცხაოები</span>
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


        @php $parkingsActive = request()->routeIs('parkings.*'); @endphp
        <a href="{{ route('parkings.index') }}"
            @class([
                'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                'bg-[var(--color-brand-500)] text-white' => $parkingsActive,
                'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$parkingsActive,
            ])>
            <svg
                @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $parkingsActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$parkingsActive])
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 10l1.5-4.5A2 2 0 018.4 4h7.2a2 2 0 011.9 1.5L19 10M5 10H3m16 0h-2M5 10v7a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-7M9 14h.01M15 14h.01"/>
            </svg>
            <span class="nav-label">პარკინგი</span>
        </a>

        @php $usersActive = request()->routeIs('users.*'); @endphp
        <a href="{{ route('users.index') }}"
            @class([
                'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                'bg-[var(--color-brand-500)] text-white' => $usersActive,
                'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$usersActive,
            ])>
            <svg
                @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $usersActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$usersActive])
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="nav-label">მომხმარებლები</span>
        </a>

        @php $contractorsActive = request()->routeIs('contractors.*'); @endphp
        <a href="{{ route('contractors.index') }}"
            @class([
                'nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors',
                'bg-[var(--color-brand-500)] text-white' => $contractorsActive,
                'text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30' => !$contractorsActive,
            ])>
            <svg
                @class(['nav-icon w-5 h-5 shrink-0', 'text-white' => $contractorsActive, 'text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]' => !$contractorsActive])
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8v-3a1 1 0 011-1h2a1 1 0 011 1v3m-4 0h4"/>
            </svg>
            <span class="nav-label">კონტრაქტორები</span>
        </a>

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
