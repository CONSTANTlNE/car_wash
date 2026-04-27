@extends('layout')


@section('boxes_dashboard2')

{{-- STAT CARDS --}}
<section>
    <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4">
        Today at a glance
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

        <div class="card rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Total Washes</span>
                <div class="w-9 h-9 rounded-xl bg-[var(--color-brand-100)] dark:bg-[var(--color-brand-900)]/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[var(--color-brand-600)] dark:text-[var(--color-brand-400)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l1.5-4.5A2 2 0 018.4 7h7.2a2 2 0 011.9 1.5L19 13M5 13H3m16 0h-2M5 13v4a1 1 0 001 1h1a1 1 0 001-1v-1h8v1a1 1 0 001 1h1a1 1 0 001-1v-4"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold">142</p>
            <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                +12% vs yesterday
            </p>
        </div>

        <div class="card rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Revenue</span>
                <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold">$4,820</p>
            <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                +8.3% this week
            </p>
        </div>

        <div class="card rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Active Bays</span>
                <div class="w-9 h-9 rounded-xl bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold">6 / 8</p>
            <div class="mt-2 w-full bg-[var(--color-border-light)] dark:bg-[var(--color-border-dark)] rounded-full h-1.5">
                <div class="bg-sky-500 h-1.5 rounded-full" style="width:75%"></div>
            </div>
        </div>

        <div class="card rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Queue</span>
                <div class="w-9 h-9 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold">11</p>
            <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mt-1">~18 min avg wait</p>
        </div>
    </div>
</section>

{{-- SERVICES BREAKDOWN --}}
<section>
    <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4">
        Services breakdown
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
        @php
            $services = [
                ['name'=>'Basic Wash',    'count'=>58, 'pct'=>41, 'bar'=>'bg-[var(--color-brand-500)]'],
                ['name'=>'Full Detail',   'count'=>34, 'pct'=>24, 'bar'=>'bg-amber-500'],
                ['name'=>'Interior Only', 'count'=>27, 'pct'=>19, 'bar'=>'bg-sky-500'],
                ['name'=>'Premium Wax',   'count'=>14, 'pct'=>10, 'bar'=>'bg-violet-500'],
                ['name'=>'Engine Clean',  'count'=>5,  'pct'=>4,  'bar'=>'bg-rose-500'],
                ['name'=>'Tire Shine',    'count'=>4,  'pct'=>3,  'bar'=>'bg-emerald-500'],
                ['name'=>'Odor Removal',  'count'=>0,  'pct'=>0,  'bar'=>'bg-slate-400'],
                ['name'=>'Fleet Wash',    'count'=>0,  'pct'=>0,  'bar'=>'bg-slate-400'],
            ];
        @endphp
        @foreach($services as $s)
            <div class="rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)] hover:shadow-md transition-all">
                <p class="text-sm font-medium mb-3">{{ $s['name'] }}</p>
                <div class="flex items-end justify-between">
                    <span class="text-2xl font-bold">{{ $s['count'] }}</span>
                    <span class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $s['pct'] }}%</span>
                </div>
                <div class="mt-3 w-full bg-[var(--color-border-light)] dark:bg-[var(--color-border-dark)] rounded-full h-1.5">
                    <div class="{{ $s['bar'] }} h-1.5 rounded-full" style="width:{{ $s['pct'] }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- BOTTOM ROW --}}
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-6">

    {{-- Recent Orders --}}
    <div class="lg:col-span-2 rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-sm">Recent Orders</h3>
            <a href="#" class="text-xs text-[var(--color-brand-500)] hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto -mx-1">
            <table class="w-full text-sm">
                <thead>
                <tr class="text-left text-[10px] uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                    <th class="pb-3 px-1">Customer</th>
                    <th class="pb-3 px-1">Service</th>
                    <th class="pb-3 px-1">Bay</th>
                    <th class="pb-3 px-1">Status</th>
                    <th class="pb-3 px-1 text-right">Amount</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border-light)] dark:divide-[var(--color-border-dark)]">
                @php
                    $orders = [
                        ['name'=>'Sarah M.',  'service'=>'Full Detail',   'bay'=>'B2','status'=>'In Progress','amt'=>'$89','dot'=>'bg-amber-400'],
                        ['name'=>'Tom B.',    'service'=>'Basic Wash',    'bay'=>'B1','status'=>'Done',       'amt'=>'$19','dot'=>'bg-emerald-400'],
                        ['name'=>'Liu W.',    'service'=>'Premium Wax',   'bay'=>'B5','status'=>'Done',       'amt'=>'$59','dot'=>'bg-emerald-400'],
                        ['name'=>'Ahmed R.',  'service'=>'Engine Clean',  'bay'=>'B3','status'=>'Queued',     'amt'=>'$45','dot'=>'bg-sky-400'],
                        ['name'=>'Priya K.',  'service'=>'Interior Only', 'bay'=>'B4','status'=>'In Progress','amt'=>'$39','dot'=>'bg-amber-400'],
                        ['name'=>'Carlos D.', 'service'=>'Tire Shine',    'bay'=>'B6','status'=>'Queued',     'amt'=>'$15','dot'=>'bg-sky-400'],
                    ];
                @endphp
                @foreach($orders as $o)
                    <tr class="hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                        <td class="py-3 px-1 font-medium">{{ $o['name'] }}</td>
                        <td class="py-3 px-1 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $o['service'] }}</td>
                        <td class="py-3 px-1 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $o['bay'] }}</td>
                        <td class="py-3 px-1">
                                        <span class="inline-flex items-center gap-1.5 text-xs">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $o['dot'] }}"></span>
                                            {{ $o['status'] }}
                                        </span>
                        </td>
                        <td class="py-3 px-1 text-right font-semibold">{{ $o['amt'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Staff on Duty --}}
    <div class="rounded-2xl p-5 bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-sm">Staff on Duty</h3>
            <span class="text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full">5 active</span>
        </div>
        <ul class="space-y-3">
            @php
                $staff = [
                    ['init'=>'MJ','name'=>'Marcus J.',  'role'=>'Bay Lead',     'status'=>'Busy',  'grad'=>'from-orange-400 to-red-500'],
                    ['init'=>'AL','name'=>'Anika L.',   'role'=>'Detail Spec.', 'status'=>'Free',  'grad'=>'from-amber-400 to-orange-500'],
                    ['init'=>'RK','name'=>'Raj K.',     'role'=>'Cashier',      'status'=>'Free',  'grad'=>'from-sky-400 to-blue-500'],
                    ['init'=>'FB','name'=>'Fatima B.',  'role'=>'Bay Tech',     'status'=>'Busy',  'grad'=>'from-violet-400 to-purple-500'],
                    ['init'=>'DL','name'=>'Dylan L.',   'role'=>'Bay Tech',     'status'=>'Break', 'grad'=>'from-teal-400 to-emerald-500'],
                ];
                $sc = ['Busy'=>'text-amber-600 dark:text-amber-400','Free'=>'text-emerald-600 dark:text-emerald-400','Break'=>'text-slate-500 dark:text-slate-400'];
            @endphp
            @foreach($staff as $p)
                <li class="flex items-center gap-3 p-2 rounded-xl hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10 transition-colors">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $p['grad'] }} flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ $p['init'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ $p['name'] }}</p>
                        <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">{{ $p['role'] }}</p>
                    </div>
                    <span class="text-xs font-medium {{ $sc[$p['status']] }}">{{ $p['status'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</section>
{{-- FORM EXAMPLES --}}
<section class="pb-6">
    <h2 class="text-sm font-semibold uppercase tracking-widest text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-4">
        Form elements
    </h2>

    <div class="rounded-2xl border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                bg-[var(--color-card-light)] dark:bg-[var(--color-card-dark)] p-6">

        <form class="space-y-6">

            {{-- Row 1: Text + Email --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Full name
                    </label>
                    <input type="text" placeholder="Marcus Johnson"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Email
                    </label>
                    <input type="email" placeholder="marcus@carwash.com"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
            </div>

            {{-- Row 2: Password + Number --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Password
                    </label>
                    <input type="password" placeholder="••••••••"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Bay capacity
                    </label>
                    <input type="number" placeholder="8" min="1" max="20"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
            </div>

            {{-- Row 3: Select + Date --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Service type
                    </label>
                    <select class="w-full rounded-xl px-4 py-2.5 text-sm
                                   bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                   border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                   text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                   outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent">
                        <option value="">Select a service…</option>
                        <option>Basic Wash</option>
                        <option>Full Detail</option>
                        <option>Interior Only</option>
                        <option>Premium Wax</option>
                        <option>Engine Clean</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                        Scheduled date
                    </label>
                    <input type="date"
                           class="w-full rounded-xl px-4 py-2.5 text-sm
                                  bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                  border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                  text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                  outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent" />
                </div>
            </div>

            {{-- Textarea --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    Notes
                </label>
                <textarea rows="3" placeholder="Additional instructions for this order…"
                          class="w-full rounded-xl px-4 py-2.5 text-sm resize-none
                                 bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                                 border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                                 text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                                 placeholder:text-[var(--color-muted-light)] dark:placeholder:text-[var(--color-muted-dark)]
                                 outline-none focus:ring-2 focus:ring-[var(--color-brand-400)] focus:border-transparent"></textarea>
            </div>

            {{-- Range --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">
                        Discount
                    </label>
                    <span class="text-xs font-semibold text-[var(--color-brand-500)]">20%</span>
                </div>
                <input type="range" min="0" max="100" value="20"
                       class="w-full h-1.5 rounded-full appearance-none cursor-pointer accent-[var(--color-brand-500)]
                              bg-[var(--color-border-light)] dark:bg-[var(--color-border-dark)]" />
            </div>

            {{-- Radio group --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-2">
                    Priority
                </label>
                <div class="flex flex-wrap gap-3">
                    @foreach (['Low', 'Normal', 'High', 'Urgent'] as $priority)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="priority" value="{{ $priority }}"
                                   @if($priority === 'Normal') checked @endif
                                   class="accent-[var(--color-brand-500)]" />
                            <span class="text-sm">{{ $priority }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Checkboxes --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-2">
                    Notify via
                </label>
                <div class="flex flex-wrap gap-4">
                    @foreach (['Email', 'SMS', 'Push notification'] as $channel)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 rounded accent-[var(--color-brand-500)]" checked />
                            <span class="text-sm">{{ $channel }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Toggle --}}
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Active bay</p>
                    <p class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Accept new orders to this bay</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked />
                    <div class="w-10 h-6 rounded-full bg-[var(--color-border-light)] dark:bg-[var(--color-border-dark)]
                                peer-checked:bg-[var(--color-brand-500)]
                                after:content-[''] after:absolute after:top-1 after:left-1
                                after:w-4 after:h-4 after:rounded-full after:bg-white
                                after:transition-all peer-checked:after:translate-x-4
                                transition-colors"></div>
                </label>
            </div>

            {{-- File upload --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)] mb-1.5">
                    Attachment
                </label>
                <label class="flex flex-col items-center justify-center w-full h-24 rounded-xl cursor-pointer
                              border-2 border-dashed border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                              bg-[var(--color-surface-light)] dark:bg-[var(--color-surface-dark)]
                              hover:border-[var(--color-brand-400)] hover:bg-[var(--color-brand-50)] dark:hover:bg-[var(--color-brand-900)]/10
                              transition-colors">
                    <svg class="w-5 h-5 mb-1 text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span class="text-xs text-[var(--color-muted-light)] dark:text-[var(--color-muted-dark)]">Click to upload or drag & drop</span>
                    <input type="file" class="hidden" />
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]">
                <button type="button"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium
                               border border-[var(--color-border-light)] dark:border-[var(--color-border-dark)]
                               text-[var(--color-text-light)] dark:text-[var(--color-text-dark)]
                               hover:bg-[var(--color-surface-light)] dark:hover:bg-[var(--color-surface-dark)]
                               transition-colors">
                    Cancel
                </button>
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
