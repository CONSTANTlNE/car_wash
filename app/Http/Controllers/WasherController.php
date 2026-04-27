<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WashQueue;
use Illuminate\Http\Request;

class WasherController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from') ?? today()->startOfMonth();
        $to   = $request->date('to')   ?? today();

        $washers = User::role('washer')
            ->withCount(['washQueues as washes_count' => fn ($q) => $q->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])])
            ->withSum(['washQueues as total_amount' => fn ($q) => $q->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])], 'wash_price')
            ->withSum(['washQueues as total_commission' => fn ($q) => $q->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])], 'washer_commission')
           ->where('is_active', true)
            ->get();

        return view('pages.washers', compact('washers', 'from', 'to'));
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
        $to   = $request->date('to')   ?? today();

        $queues = WashQueue::with(['car', 'box'])
            ->where('user_id', $washer->id)
            ->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])
            ->latest()
            ->get();

        $stats = [
            'washes'     => $queues->count(),
            'amount'     => $queues->sum('wash_price'),
            'commission' => $queues->sum('washer_commission'),
        ];

        return view('pages.washer_single', compact('washer', 'queues', 'stats', 'from', 'to'));
    }
}
