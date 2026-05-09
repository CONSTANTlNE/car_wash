<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In — CarWash Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body class="min-h-screen font-sans antialiased flex items-center justify-center
             bg-[var(--color-surface-light)] text-[var(--color-text-light)]
             dark:bg-[var(--color-surface-dark)] dark:text-[var(--color-text-dark)]">

    <div class="w-96 px-4">

        {{-- Logo --}}
        <div class="flex flex-col items-center mb-8">
            <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-[var(--color-brand-500)] text-white mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l1.5-4.5A2 2 0 018.4 7h7.2a2 2 0 011.9 1.5L19 13M5 13H3m16 0h-2M5 13v4a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-4"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)]">CarWash</h1>
            <p class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mt-1">Sign in to your account</p>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                    bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-7 shadow-sm">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 px-4 py-3">
                    <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session status --}}
            @if (session('status'))
                <div class="mb-5 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 px-4 py-3">
                    <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5 p-4">
                @csrf

                {{-- Email --}}
                <div class="p-4">
                    <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent
                                  @error('email') border-rose-400 dark:border-rose-600 @enderror"
                           placeholder="you@example.com" />
                </div>

                {{-- Password --}}
                <div class="p-4">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="text-sm font-medium">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-[var(--color-brand-500)] hover:text-[var(--color-brand-600)] dark:hover:text-[var(--color-brand-400)]">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent
                                  @error('password') border-rose-400 dark:border-rose-600 @enderror"
                           placeholder="••••••••" />
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2.5 p-4">
                    <input id="remember" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  accent-[var(--color-brand-500)]" />
                    <label for="remember" class="text-sm text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        Remember me
                    </label>
                </div>

                <div class="flex justyfy-center gap-2">

                    {{-- Submit --}}
                    <a href="{{route('register')}}" type="submit"
                            class="w-full rounded-xl px-4 py-2.5 text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)]
                               active:bg-[var(--color-brand-700)] transition-colors">
                        რეგისტრაცია
                    </a>
                    <button type="submit"
                       class="w-full rounded-xl px-4 py-2.5 text-sm font-semibold text-white
                               bg-[var(--color-brand-500)] hover:bg-[var(--color-brand-600)]
                               active:bg-[var(--color-brand-700)] transition-colors">
                        ავტორიზაცია
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
