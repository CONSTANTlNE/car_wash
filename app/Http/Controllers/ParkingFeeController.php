<?php

namespace App\Http\Controllers;

use App\Models\ParkingFee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ParkingFeeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'free_time' => ['nullable', 'integer', 'min:0'],
            'parking_price' => ['required', 'numeric', 'min:0'],
        ]);

        ParkingFee::create($data);

        return redirect()->route('parkings.index');
    }

    public function update(Request $request, ParkingFee $parkingFee): RedirectResponse
    {
        $data = $request->validate([
            'free_time' => ['nullable', 'integer', 'min:0'],
            'parking_price' => ['required', 'numeric', 'min:0'],
        ]);

        $parkingFee->update($data);

        return redirect()->route('parkings.index');
    }

    public function destroy(ParkingFee $parkingFee): RedirectResponse
    {
        $parkingFee->delete();

        return redirect()->route('parkings.index');
    }
}
