<?php

namespace App\Http\Controllers;

use App\Models\WashType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WashTypeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'wash_type' => ['required', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        WashType::create($data);

        return redirect()->route('tenants');
    }

    public function update(Request $request, WashType $washType): RedirectResponse
    {
        $data = $request->validate([
            'wash_type' => ['required', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $washType->update($data);

        return redirect()->route('tenants');
    }

    public function destroy(WashType $washType): RedirectResponse
    {
        $washType->delete();

        return redirect()->route('tenants');
    }
}
