<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractorController extends Controller
{
    public function index(): View
    {
        $query = Contractor::where('tenant_id', auth()->user()->tenant_id);

        $contractors = $query->paginate(20);

        return view('pages.contractors', compact('contractors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'type' => ['required', 'in:is_insurance,is_supplier,is_agreement'],
        ]);

        Contractor::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'] ?? null,
            'email' => $data['email'] ?? null,
            'is_insurance' => $data['type'] === 'is_insurance',
            'is_supplier' => $data['type'] === 'is_supplier',
            'is_agreement' => $data['type'] === 'is_agreement',
        ]);

        return redirect()->route('contractors.index');
    }

    public function update(Request $request, Contractor $contractor): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'type' => ['required', 'in:is_insurance,is_supplier,is_agreement'],
        ]);

        $contractor->update([
            'name' => $data['name'],
            'mobile' => $data['mobile'] ?? null,
            'email' => $data['email'] ?? null,
            'is_insurance' => $data['type'] === 'is_insurance',
            'is_supplier' => $data['type'] === 'is_supplier',
            'is_agreement' => $data['type'] === 'is_agreement',
        ]);

        return redirect()->route('contractors.index');
    }

    public function destroy(Contractor $contractor): RedirectResponse
    {
        $contractor->delete();

        return redirect()->route('contractors.index');
    }
}
