<?php

namespace App\Http\Controllers;

use App\Events\WashQueueCreated;
use App\Models\Car;
use App\Models\CarType;
use App\Models\CarwashBox;
use App\Models\Contractor;
use App\Models\User;
use App\Models\WashPrice;
use App\Models\WashQueue;
use App\Models\WashType;
use Illuminate\Http\Request;

class WashQueueController extends Controller
{
    public function history(Request $request)
    {
        $from = $request->date('from') ?? today()->startOfMonth();
        $to = $request->date('to') ?? today();

        $queues = WashQueue::with(['car', 'box', 'washer'])
            ->whereBetween('wash_date', [$from->toDateString(), $to->toDateString()])
            ->latest()
            ->get();

        $stats = [
            'total' => $queues->count(),
            'amount' => $queues->sum('wash_price'),
            'commission' => $queues->sum('washer_commission'),
        ];

        return view('pages.washes_history', compact('queues', 'stats', 'from', 'to'));
    }

    public function index()
    {
        $queues = WashQueue::with(['car', 'box', 'washer'])
            ->whereDate('wash_date', today())
            ->orWhere('status', 'pending')
            ->orWhere('is_paid', false)
            ->orderBy('id', 'asc')
            ->latest()
            ->get();

        $boxes = CarwashBox::with(['washer', 'washQueues' => fn ($q) => $q
            ->with(['car', 'washer'])
            ->whereDate('wash_date', today())
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->limit(1),
        ])->orderBy('id')->get();

        $washers = User::role('washer')->where('is_active', true)->orderBy('name')->get();

        return view('pages.boxes_dashboard', compact('queues', 'boxes', 'washers'));
    }

    public function create()
    {
        $wash_types = WashType::all();
        $wash_boxes = CarwashBox::with('washer')->get();
        $washers = User::role('washer')->where('is_active', true)->orderBy('name')->get();
        $carTypes = CarType::orderBy('name')->get();
        $busyBoxIds = $this->busyBoxIds();
        $contractors = Contractor::where('is_active', true)
            ->where(function ($q) {
                $q->where('is_insurance', true)
                    ->orWhere('is_agreement', true);
            })
            ->get();

        $washPrices = WashPrice::all()
            ->mapWithKeys(fn ($p) => [$p->car_type_id.'_'.$p->wash_type_id => $p->price]);

        return view('pages.queue_create', compact('wash_types', 'wash_boxes', 'washers', 'carTypes', 'busyBoxIds', 'contractors', 'washPrices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wash_type' => ['required', 'exists:wash_types,id'],
            'car_type' => ['required', 'exists:car_types,id'],
            'car_number' => ['required', 'string', 'max:20'],
            'owner_mobile' => ['nullable', 'string', 'max:20'],
            'wash_box' => ['required', 'exists:carwash_boxes,id'],
            'amount' => ['required', 'numeric', 'min:1', 'max:500'],
            'washer' => ['required', 'exists:users,id'],
            'comment' => ['nullable', 'string', 'max:500'],
            'contractor_id' => ['nullable', 'exists:contractors,id'],
            'car_photo' => ['nullable', 'image', 'max:10240'],
        ]);

        $carType = CarType::find($data['car_type']);

        $car = Car::firstOrCreate(
            ['car_number' => $data['car_number']],
            [
                'car_type' => $carType->name,
                'tenant_id' => auth()->user()->tenant_id,
                'owner_mobile' => $data['owner_mobile'] ?? null,
            ]
        );

        $washType = WashType::find($data['wash_type']);
        $washer = User::find($data['washer']);

        $queue = WashQueue::create([
            'car_id' => $car->id,
            'car_wash_box_id' => $data['wash_box'],
            'user_id' => $data['washer'],
            'wash_type_id' => $washType->id,
            'wash_type' => $washType->wash_type,
            'wash_price' => $data['amount'],
            'wash_date' => now()->toDateString(),
            'comment' => $data['comment'] ?? null,
            'contractor_id' => $data['contractor_id'] ?? null,
            'washer_commission' => $data['amount'] * ($washer->commission / 100),
        ]);

        if ($request->hasFile('car_photo')) {
            $queue->addMediaFromRequest('car_photo')->toMediaCollection('car_photos');
        }

        WashQueueCreated::dispatch($queue);

        return redirect()->route('queue_dashboard');
    }

    public function edit(WashQueue $queue)
    {
        $queue->load('car');
        $wash_types = WashType::all();
        $wash_boxes = CarwashBox::all();
        $washers = User::role('washer')->get();
        $carTypes = CarType::orderBy('name')->get();
        $busyBoxIds = $this->busyBoxIds(excludeQueue: $queue->id);

        return view('pages.queue_edit', compact('queue', 'wash_types', 'wash_boxes', 'washers', 'carTypes', 'busyBoxIds'));
    }

    public function update(Request $request, WashQueue $queue)
    {
        $data = $request->validate([
            'wash_type' => ['required', 'exists:wash_types,id'],
            'car_type' => ['required', 'exists:car_types,id'],
            'car_number' => ['required', 'string', 'max:20'],
            'owner_mobile' => ['nullable', 'string', 'max:20'],
            'wash_box' => ['required', 'exists:carwash_boxes,id'],
            'amount' => ['required', 'numeric', 'min:1', 'max:500'],
            'washer' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:pending,in_progress,done,cancelled'],
            'comment' => ['nullable', 'string', 'max:500'],
            'car_photo' => ['nullable', 'image', 'max:10240'],
        ]);

        $carType = CarType::find($data['car_type']);

        $car = Car::firstOrCreate(
            ['car_number' => $data['car_number']],
            [
                'car_type' => $carType->name,
                'owner_mobile' => $data['owner_mobile'] ?? null,
            ]
        );

        $car->update([
            'car_type' => $carType->name,
            'owner_mobile' => $data['owner_mobile'] ?? $car->owner_mobile,
        ]);

        $washType = WashType::find($data['wash_type']);
        $washer = User::find($data['washer']);

        $queue->update([
            'car_id' => $car->id,
            'car_wash_box_id' => $data['wash_box'],
            'user_id' => $data['washer'],
            'wash_type_id' => $washType->id,
            'wash_type' => $washType->wash_type,
            'wash_price' => $data['amount'],
            'status' => $data['status'],
            'comment' => $data['comment'] ?? null,
            'washer_commission' => $data['amount'] * ($washer->commission / 100),
        ]);

        if ($request->hasFile('car_photo')) {
            $queue->clearMediaCollection('car_photos');
            $queue->addMediaFromRequest('car_photo')->toMediaCollection('car_photos');
        }

        return redirect()->route('queue_dashboard');
    }

    public function markWashed(WashQueue $queue)
    {
        if ($queue->status === 'pending') {
            $queue->update(['status' => 'done']);
        }

        return redirect()->route('queue_dashboard');
    }

    public function unmarkWashed(WashQueue $queue)
    {
        if ($queue->status === 'done') {
            $queue->update(['status' => 'pending']);
        }

        return redirect()->route('queue_dashboard');
    }

    public function destroy(WashQueue $queue)
    {
        $queue->delete();

        return redirect()->back();
    }

    private function busyBoxIds(?int $excludeQueue = null): array
    {
        return WashQueue::whereDate('wash_date', today())
            ->whereIn('status', ['pending', 'in_progress'])
            ->when($excludeQueue, fn ($q) => $q->where('id', '!=', $excludeQueue))
            ->pluck('car_wash_box_id')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
