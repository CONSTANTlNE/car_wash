<?php

namespace App\Http\Controllers;

use App\Models\CarwashBox;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarwashBoxController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'box_number' => ['required', 'string', 'max:255', Rule::unique('carwash_boxes', 'box_number')],
        ]);

        CarwashBox::create($data);

        return redirect()->route('queue_dashboard');
    }

    public function update(Request $request, CarwashBox $box): RedirectResponse
    {
        $data = $request->validate([
            'box_number' => ['required', 'string', 'max:255', Rule::unique('carwash_boxes', 'box_number')->ignore($box->id)],
        ]);

        $box->update($data);

        return redirect()->route('queue_dashboard');
    }

    public function assignWasher(Request $request, CarwashBox $box): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $box->update(['user_id' => $data['user_id'] ?: null]);

        return redirect()->route('queue_dashboard');
    }

    public function destroy(CarwashBox $box): RedirectResponse
    {
        $box->delete();

        return redirect()->route('queue_dashboard');
    }
}
