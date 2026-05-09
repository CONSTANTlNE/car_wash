<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WashQueue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WasherController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from') ?? today()->startOfMonth();
        $to = $request->date('to') ?? today();

        $tenantId = auth()->user()->tenant_id;

        $washers = User::role('washer')
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId), fn ($q) => $q->whereRaw('1 = 0'))
            ->withCount(['washQueues as washes_count' => fn ($q) => $q->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])])
            ->withSum(['washQueues as total_amount' => fn ($q) => $q->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])], 'wash_price')
            ->withSum(['washQueues as total_commission' => fn ($q) => $q->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])], 'washer_commission')
            ->orderByDesc('id')
            ->get();

        return view('pages.washers', compact('washers', 'from', 'to'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'commission' => ['required', 'numeric', 'min:0', 'max:100'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        $user->commission = $data['commission'];
        $user->mobile = $data['mobile'] ?? null;
        $user->save();

        $user->assignRole('washer');

        return redirect()->route('washer_dashboard');
    }

    public function updateName(Request $request, User $washer)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $washer->update(['name' => $data['name']]);

        return back();
    }

    public function toggleActive(User $washer)
    {
        $washer->update(['is_active' => ! $washer->is_active]);

        return back();
    }

    public function updateCommission(Request $request, User $washer)
    {
        $data = $request->validate([
            'commission' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $washer->update(['commission' => $data['commission']]);

        return back();
    }

    public function singleWasher(Request $request)
    {
        $washer = User::findOrFail($request->integer('washer_id'));
        $from = $request->date('from') ?? today()->startOfMonth();
        $to = $request->date('to') ?? today();

        $queues = WashQueue::with(['car', 'box'])
            ->where('user_id', $washer->id)
            ->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])
            ->latest()
            ->get();

        $stats = [
            'washes' => $queues->count(),
            'amount' => $queues->sum('wash_price'),
            'commission' => $queues->sum('washer_commission'),
        ];

        return view('pages.washer_single', compact('washer', 'queues', 'stats', 'from', 'to'));
    }
}
