<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        $rawMaterialsQuery = RawMaterial::search($query);

        $rawMaterials = $rawMaterialsQuery->paginate(30);

        return view('dashboard.raw_material.index', compact('rawMaterials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:raw_materials',
            'name' => 'required',
            'quantity' => 'required|numeric',
            'unit' => 'required',
        ]);

        $rawMaterial = new RawMaterial;
        $rawMaterial->fill($validatedData);

        $rawMaterial->save();

        flash('Raw material has been saved successfully!', 'success');
        return redirect()->route('dashboard.raw-material.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterial $rawMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterial $rawMaterial)
    {
        return view('dashboard.raw_material.edit', [
            'rawMaterial' => $rawMaterial
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $validatedData = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'quantity' => 'required|numeric',
            'unit' => 'required',
        ]);

        $rawMaterial->update($validatedData);

        flash('Raw Material has been Updated Successfully!', 'success');
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();

        flash('Raw Material has been deleted', 'success');
        return redirect()->route('dashboard.raw-material.index');
    }
}
