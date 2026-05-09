<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\ProductPayment;
use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();
        $contractorId = $request->integer('contractor_id') ?: null;
        $status = $request->string('status')->trim()->value();
        $from = $request->date('from') ?? today()->startOfMonth();
        $to = $request->date('to') ?? today();

        $products = Products::with(['contractor', 'payments'])
            ->whereBetween('created_at', [$from->startOfDay(), $to->copy()->endOfDay()])
            ->when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%"))
            ->when($contractorId, fn ($q) => $q->where('contractor_id', $contractorId))
            ->latest()
            ->get()
            ->when($status === 'unpaid', fn ($c) => $c->filter(fn ($p) => $p->amount_paid == 0))
            ->when($status === 'partial', fn ($c) => $c->filter(fn ($p) => $p->amount_paid > 0 && ! $p->is_fully_paid))
            ->when($status === 'paid', fn ($c) => $c->filter(fn ($p) => $p->is_fully_paid));

        $contractors = Contractor::where('is_active', true)->where('is_supplier', true)->orderBy('name')->get();

        return view('pages.products', compact('products', 'contractors', 'search', 'contractorId', 'status', 'from', 'to'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'contractor_id' => ['required', 'exists:contractors,id'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        Products::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'contractor_id' => $data['contractor_id'],
            'payment_method' => 'pending',
            'user_id' => auth()->id(),
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        return redirect()->route('products.index');
    }

    public function update(Request $request, Products $product): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'contractor_id' => ['required', 'exists:contractors,id'],
        ]);

        $product->update($data);

        return redirect()->route('products.index');
    }

    public function destroy(Products $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    public function pay(Request $request, Products $product): RedirectResponse
    {
        $product->load('payments');

        $remaining = $product->balance;

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:'.$remaining],
            'payment_method' => ['required', 'in:cash,BOG_TERMINAL,TBC_TERMINAL'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        ProductPayment::create([
            'product_id' => $product->id,
            'tenant_id' => auth()->user()->tenant_id,
            'user_id' => auth()->id(),
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'note' => $data['note'] ?? null,
        ]);

        return redirect()->route('products.index');
    }
}
