<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>CarWash Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body id="app-body"
      class="min-h-screen font-sans antialiased
             bg-[var(--color-surface-light)] text-[var(--color-text-light)]
             dark:bg-[var(--color-surface-dark)] dark:text-[var(--color-text-dark)]">

<div class="flex h-screen overflow-hidden">

    {{-- ════════════ SIDEBAR ════════════ --}}
    @include('partials.sidebar')

    {{-- Mobile backdrop --}}
    <div id="sidebar-backdrop"
         class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm hidden md:hidden"
         aria-hidden="true"></div>

    {{-- ════════════ MAIN COLUMN ════════════ --}}
    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

        {{-- ── FIXED HEADER ── --}}
        @include('partials.header')

        {{-- ── SCROLLABLE CONTENT ── --}}
        <main class="flex-1 overflow-y-auto px-4 md:px-6 py-6 space-y-8">

            @yield('contractors')
            @yield('parkings')
            @yield('boxes_dashboard')
            @yield('boxes_dashboard2')
            @yield('queue_create')
            @yield('queue_edit')
            @yield('washers')
            @yield('washer_single')
            @yield('cashier')
            @yield('washes_history')
            @yield('payment_history')
            @yield('tenants')
            @yield('users')

        </main>
    </div>
</div>
<audio id="successSound" src="{{asset('notification.mp3')}}" preload="auto"></audio>

{{-- Payment notification popup --}}
<div id="payment-notification"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-xs rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] shadow-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40
                        flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Payment Received</p>
                <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Transaction complete</p>
            </div>
        </div>
        <div class="space-y-1.5 mb-5 text-sm rounded-xl bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)] p-4">
            <div class="flex justify-between">
                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Car</span>
                <span id="pn-car" class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Wash</span>
                <span id="pn-wash" class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Method</span>
                <span id="pn-method" class="text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]"></span>
            </div>
            <div class="flex justify-between pt-2 mt-1 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                <span class="font-semibold text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]">Amount</span>
                <span id="pn-amount" class="font-bold text-lg text-emerald-600 dark:text-emerald-400"></span>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('payment-notification').classList.add('hidden')"
                class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                       bg-emerald-500 hover:bg-emerald-600 transition-colors">
            OK
        </button>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        if (!window.Echo) return;
        window.Echo.channel('wash-queues')
            .listen('WashQueueCreated', function (e) {
                window.dispatchEvent(new CustomEvent('wash-queue-created', { detail: e }));
            })
            .listen('WashQueuePaid', function (e) {
                window.dispatchEvent(new CustomEvent('wash-queue-paid', { detail: e }));

                const methodLabels = { cash: 'Cash', BOG_TERMINAL: 'BOG Terminal', TBC_TERMINAL: 'TBC Terminal' };
                document.getElementById('pn-car').textContent    = e.car_number ?? '—';
                document.getElementById('pn-wash').textContent   = e.wash_type ?? '—';
                document.getElementById('pn-method').textContent = methodLabels[e.payment_method] ?? e.payment_method;
                document.getElementById('pn-amount').textContent = '₾' + Number(e.wash_price).toFixed(2);
                document.getElementById('payment-notification').classList.remove('hidden');
            });
    });
</script>
@stack('scripts')
</body>
</html>
