<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WashPrice;
use App\Models\WashType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        $tenants = auth()->user()->tenants;
        $users = User::orderBy('name')->get();
        $carTypes = CarType::orderBy('name')->get();
        $washTypes = WashType::orderBy('wash_type')->get();
        $washPrices = WashPrice::all()->keyBy(fn ($p) => $p->car_type_id.'_'.$p->wash_type_id);

        return view('pages.tenants', compact('tenants', 'users', 'carTypes', 'washTypes', 'washPrices'));
    }

    public function store(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user = auth()->user();

        $tenant = Tenant::create(
            [
                'company_name' => $data['company_name'],
                'mobile' => $data['mobile'],
                'address' => $data['address'],
                'user_id' => $user->id,
                'main_user_id' => $user->id,
            ]
        );

        $user->tenant_id = $tenant->id;
        $user->save();

        return redirect()->route('tenants');
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $tenant->update($data);

        return redirect()->route('tenants');
    }

    public function switchTenant(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
        ]);

        $user = auth()->user();

        abort_unless(
            $user->tenants()->where('id', $data['tenant_id'])->exists(),
            403
        );

        $user->tenant_id = $data['tenant_id'];
        $user->save();

        return redirect()->back();
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->delete();

        return redirect()->route('tenants');
    }
}
