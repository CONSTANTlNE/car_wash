<header class="sticky top-0 z-20 flex items-center gap-3 h-16 px-4 md:px-5
                        border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                        bg-[var(--color-card-light)]/90 dark:bg-[var(--color-card-dark)]/90
                        backdrop-blur-md">

    {{-- ★ Unified sidebar toggle (all screen sizes) --}}
    <button id="sidebar-toggle-header"
            class="flex items-center justify-center w-9 h-9 rounded-xl shrink-0
                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:border-[var(--color-brand-400)] hover:text-[var(--color-brand-500)]
                           dark:hover:border-[var(--color-brand-600)]"
            aria-label="Toggle sidebar">
        {{-- Panel / sidebar icon --}}
        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <path stroke-linecap="round" d="M9 3v18"/>
        </svg>
    </button>

    {{-- Page title --}}
    <div class="flex-1 min-w-0">
        <h1 class="text-base font-semibold truncate">Overview</h1>
        <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] hidden sm:block">
            Thursday, 24 April 2026
        </p>
    </div>

    {{-- Search --}}
    <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl
                         bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                         border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                         text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                         w-52 focus-within:ring-2 focus-within:ring-[var(--color-brand-400)]">
        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
        </svg>
        <input type="search" placeholder="Search…"
               class="bg-transparent outline-none w-full text-[var(--color-text-light)] dark:text-[var(--color-text-dark)] placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]" />
    </div>

    {{-- Theme toggle --}}
    <button id="theme-toggle"
            class="flex items-center justify-center w-9 h-9 rounded-xl
                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:border-[var(--color-brand-400)] hover:text-[var(--color-brand-500)]"
            aria-label="Toggle theme">
        <svg id="icon-sun" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
        </svg>
        <svg id="icon-moon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
    </button>

    {{-- Notifications --}}
    <button class="relative flex items-center justify-center w-9 h-9 rounded-xl
                           border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                           text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]
                           hover:border-[var(--color-brand-400)] hover:text-[var(--color-brand-500)]">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[var(--color-brand-500)]"></span>
    </button>

    {{-- ★ User avatar + dropdown --}}
    <div class="relative" id="user-menu-wrapper">
        <button id="user-menu-btn"
                class="flex items-center gap-2 rounded-xl px-2 py-1
                               hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/30"
                aria-haspopup="true" aria-expanded="false">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[var(--color-brand-400)] to-[var(--color-brand-700)] flex items-center justify-center text-white text-xs font-bold shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#0e0f0f" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/></svg>
            </div>
            <span class="hidden sm:block text-sm font-medium"> {{auth('web')->user()->name }}</span>
            <svg id="user-chevron" class="hidden sm:block w-3.5 h-3.5 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Dropdown panel --}}
        <div id="user-dropdown"
             class="hidden absolute right-0 top-full mt-2 w-56 rounded-2xl shadow-xl z-50
                            border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                            bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)]">

            {{-- User info --}}
            <div class="px-4 py-3 border-b border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                <p class="text-sm font-semibold"> {{auth('web')->user()->name }}</p>
                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mt-0.5">
                   {{auth('web')->user()->email }}
                </p>
                <span class="inline-block mt-1.5 text-[10px] font-semibold uppercase tracking-wider
                                     bg-[var(--color-brand-100)] dark:bg-[var(--color-brand-900)]/40
                                     text-[var(--color-brand-700)] dark:text-[var(--color-brand-400)]
                                     px-2 py-0.5 rounded-full">
                            Admin
                        </span>
            </div>

            {{-- Menu items --}}
            <div class="py-1.5">
                <a href="#" class="dropdown-item flex items-center gap-3 px-4 py-2.5 text-sm
                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                           hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20">
                    <svg class="w-4 h-4 text-[var(--color-text-light)] dark:text-[var(--color-muted-dark)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <a href="#" class="dropdown-item flex items-center gap-3 px-4 py-2.5 text-sm
                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                           hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20">
                    <svg class="w-4 h-4 text-[var(--color-text-light)] dark:text-[var(--color-muted-dark)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                <a href="#" class="dropdown-item flex items-center gap-3 px-4 py-2.5 text-sm
                                           text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                           hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/20">
                    <svg class="w-4 h-4 text-[var(--color-text-light)] dark:text-[var(--color-muted-dark)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Help &amp; Support
                </a>
            </div>

            <div class="border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] py-1.5">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                <button  class="dropdown-item flex items-center gap-3 px-4 py-2.5 text-sm font-medium
                                           text-rose-600 dark:text-rose-400
                                           hover:bg-rose-50 dark:hover:bg-rose-900/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log out
                </button>
                </form>
            </div>
        </div>
    </div>
</header>
