<?php

namespace App\Http\Controllers;

use App\Models\WashPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WashPriceController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'car_type_id' => ['required', 'exists:car_types,id'],
            'wash_type_id' => ['required', 'exists:wash_types,id'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        WashPrice::create($data);

        return redirect()->route('tenants');
    }

    public function update(Request $request, WashPrice $washPrice): RedirectResponse
    {
        $data = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $washPrice->update($data);

        return redirect()->route('tenants');
    }

    public function destroy(WashPrice $washPrice): RedirectResponse
    {
        $washPrice->delete();

        return redirect()->route('tenants');
    }
}
