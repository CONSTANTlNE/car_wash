<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        CarType::create($data);

        return redirect()->route('tenants');
    }

    public function update(Request $request, CarType $carType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $carType->update($data);

        return redirect()->route('tenants');
    }

    public function destroy(CarType $carType): RedirectResponse
    {
        $carType->delete();

        return redirect()->route('tenants');
    }
}
