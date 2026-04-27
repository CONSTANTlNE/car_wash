<?php

namespace App\Http\Controllers;

use App\Events\WashQueuePaid;
use App\Models\Payment;
use App\Models\WashQueue;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){

        $queues = WashQueue::with(['car', 'box', 'washer'])
            ->whereDate('wash_date', today())
            ->orWhere('is_paid', false)
            ->latest()
            ->get();

        return view('pages.cashier',compact('queues'));
    }

    public function paymentHistory(Request $request)
    {
        $from = $request->date('from') ?? today()->startOfMonth();
        $to        = $request->date('to')   ?? today();
        $carNumber = $request->string('car_number')->trim()->value();

        $payments = Payment::with(['washQueue.car', 'washQueue.box', 'washQueue.washer'])
            ->whereBetween('created_at', [$from->startOfDay(), $to->copy()->endOfDay()])
            ->when($carNumber, fn ($q) => $q->whereHas(
                'washQueue.car',
                fn ($q) => $q->where('car_number', 'ilike', "%{$carNumber}%")
            ))
            ->latest()
            ->get();

        $stats = [
            'total'  => $payments->count(),
            'amount' => $payments->sum('amount'),
        ];

        return view('pages.payment_history', compact('payments', 'stats', 'from', 'to', 'carNumber'));
    }

    public function payment(Request $request, WashQueue $queue){

        $data = $request->validate([
            'payment_method' => ['required', 'in:cash,BOG_TERMINAL,TBC_TERMINAL'],
        ]);

        $queue->update(['is_paid' => true]);

        Payment::create([
            'wash_queues_id' => $queue->id,
            'user_id'        => auth()->user()->id,
            'amount'         => $queue->wash_price,
            'payment_method' => $data['payment_method'],
        ]);

        WashQueuePaid::dispatch($queue, $data['payment_method']);

        return redirect()->back();
    }

    public function updatePayment(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:cash,BOG_TERMINAL,TBC_TERMINAL'],
        ]);

        $payment->update(['payment_method' => $data['payment_method']]);

        return redirect()->back();
    }
}
