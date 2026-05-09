<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\ParkingFee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParkingController extends Controller
{
    public function index(): View
    {
        $parkings = Parking::with('user')
            ->latest()->get();
        $parkingFees = ParkingFee::latest()->get();
        $users = User::orderBy('name')->get();

        return view('pages.parkings', compact('parkings', 'parkingFees', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'car_number' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i'],
        ]);

        Parking::create([
            'car_number' => $data['car_number'],
            'start_time' => $data['start_date'].' '.$data['start_time'],
            'user_id' => auth()->user()->id,
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        return redirect()->route('parkings.index');
    }

    public function update(Request $request, Parking $parking): RedirectResponse
    {
        $data = $request->validate([
            'car_number' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['nullable', 'date_format:Y-m-d'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'parking_fee_id' => ['nullable', 'exists:parking_fees,id'],
        ]);

        $startTime = $data['start_date'].' '.$data['start_time'];
        $endTime = ! empty($data['end_date']) && ! empty($data['end_time'])
            ? $data['end_date'].' '.$data['end_time']
            : null;

        $updateData = [
            'car_number' => $data['car_number'],
            'user_id' => $data['user_id'] ?? null,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];

        if ($endTime && ! empty($data['parking_fee_id'])) {
            $tariff = ParkingFee::find($data['parking_fee_id']);
            $this->applyTariff($updateData, $startTime, $endTime, $tariff);
        }

        $parking->update($updateData);

        return redirect()->route('parkings.index');
    }

    public function markExit(Request $request, Parking $parking): RedirectResponse
    {
        $data = $request->validate([
            'end_date' => ['required', 'date_format:Y-m-d'],
            'end_time' => ['required', 'date_format:H:i'],
            'parking_fee_id' => ['nullable', 'exists:parking_fees,id'],
        ]);

        $endTime = $data['end_date'].' '.$data['end_time'];

        $updateData = ['end_time' => $endTime];

        if (! empty($data['parking_fee_id'])) {
            $tariff = ParkingFee::find($data['parking_fee_id']);
            $this->applyTariff($updateData, $parking->start_time, $endTime, $tariff);
        }

        $parking->update($updateData);

        return redirect()->route('parkings.index');
    }

    public function destroy(Parking $parking): RedirectResponse
    {
        $parking->delete();

        return redirect()->route('parkings.index');
    }

    private function applyTariff(array &$data, mixed $startTime, string $endTime, ParkingFee $tariff): void
    {
        $minutes = Carbon::parse($startTime)->diffInMinutes(Carbon::parse($endTime));
        $billable = max(0, $minutes - ($tariff->free_time ?? 0));

        $data['duration'] = $minutes;
        $data['parking_rate'] = $tariff->parking_price;
        $data['parking_fee'] = $billable > 0 ? (int) ceil($billable / 60) * $tariff->parking_price : 0;
    }
}
