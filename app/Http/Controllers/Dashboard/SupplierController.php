<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $query = Supplier::search($query);
        $suppliers = $query->paginate(30);

        return view('dashboard.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboard.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'terms' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        flash('Supplier created successfully!', 'success');
        return redirect()->route('dashboard.supplier.index');
    }

    public function show(Supplier $supplier)
    {
        return view('dashboard.supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('dashboard.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'terms' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        flash('Supplier updated successfully!', 'success');
        return redirect()->route('dashboard.supplier.index');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        flash('Supplier deleted successfully!', 'success');
        return redirect()->route('dashboard.supplier.index');
    }

    
}