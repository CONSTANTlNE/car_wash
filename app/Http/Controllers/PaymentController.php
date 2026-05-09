<?php

namespace App\Http\Controllers;

use App\Events\WashQueuePaid;
use App\Models\CarwashBox;
use App\Models\Parking;
use App\Models\Payment;
use App\Models\User;
use App\Models\WashQueue;
use App\Models\WashType;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {

        $queues = WashQueue::with(['car', 'box', 'washer'])
            ->whereDate('wash_date', today())
            ->orWhere('is_paid', false)
            ->latest()
            ->get();

        $parkings = Parking::where(function ($q) {
            $q->whereDate('created_at', today())->orWhere('is_paid', false);
        })
            ->latest()
            ->get();

        return view('pages.cashier', compact('queues', 'parkings'));
    }

    public function paymentHistory(Request $request)
    {
        $from = $request->date('from') ?? today()->startOfMonth();
        $to = $request->date('to') ?? today();
        $carNumber = $request->string('car_number')->trim()->value();
        $paymentMethod = $request->string('payment_method')->trim()->value();
        $washerId = $request->integer('washer_id') ?: null;
        $washTypeId = $request->integer('wash_type_id') ?: null;
        $boxId = $request->integer('box_id') ?: null;

        $payments = Payment::with(['washQueue.car', 'washQueue.box', 'washQueue.washer'])
            ->whereBetween('created_at', [$from->startOfDay(), $to->copy()->endOfDay()])
            ->when($carNumber, fn ($q) => $q->whereHas(
                'washQueue.car',
                fn ($q) => $q->where('car_number', 'ilike', "%{$carNumber}%")
            ))
            ->when($paymentMethod, fn ($q) => $q->where('payment_method', $paymentMethod))
            ->when($washerId, fn ($q) => $q->whereHas(
                'washQueue', fn ($q) => $q->where('user_id', $washerId)
            ))
            ->when($washTypeId, fn ($q) => $q->whereHas(
                'washQueue', fn ($q) => $q->where('wash_type_id', $washTypeId)
            ))
            ->when($boxId, fn ($q) => $q->whereHas(
                'washQueue', fn ($q) => $q->where('car_wash_box_id', $boxId)
            ))
            ->latest()
            ->get();

        $stats = [
            'total' => $payments->count(),
            'amount' => $payments->sum('amount'),
            'cash' => $payments->where('payment_method', 'cash')->sum('amount'),
            'bog' => $payments->where('payment_method', 'BOG_TERMINAL')->sum('amount'),
            'tbc' => $payments->where('payment_method', 'TBC_TERMINAL')->sum('amount'),
        ];

        $washers = User::role('washer')->orderBy('name')->get();
        $washTypes = WashType::orderBy('wash_type')->get();
        $boxes = CarwashBox::orderBy('box_number')->get();

        return view('pages.payment_history', compact(
            'payments', 'stats', 'from', 'to',
            'carNumber', 'paymentMethod', 'washerId', 'washTypeId', 'boxId',
            'washers', 'washTypes', 'boxes'
        ));
    }

    public function payment(Request $request, WashQueue $queue)
    {

        $data = $request->validate([
            'payment_method' => ['required', 'in:cash,BOG_TERMINAL,TBC_TERMINAL'],
        ]);

        $queue->update(['is_paid' => true]);

        Payment::create([
            'wash_queues_id' => $queue->id,
            'user_id' => auth()->user()->id,
            'amount' => $queue->wash_price,
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
