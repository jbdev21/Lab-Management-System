<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\RawMaterialUsagePivot;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Usage::with('user');

        $usages = $query
                    ->latest()
                    ->paginate(30);

        return view('dashboard.usage.index', [
            'usages' => $usages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date|unique:usages,date',
            'note' => 'nullable|string',
        ]);
    
        $usage = new Usage();
        $usage->date = $validatedData['date'];
        $usage->note = $validatedData['note'];
        $usage->is_submitted = false;
        $usage->user_id = auth()->id();
    
        $usage->save();

        flash('Usage date has been saved successfully!', 'success');
        return redirect()->route('dashboard.usage.show', $usage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Usage $usage)
    {

        $rawMaterials = session('raw_materials', []);

        return view("dashboard.usage.show", [
            "usage" => $usage,
            "rawMaterials" => $rawMaterials,
        ]);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'usage_id' => 'required|integer',
            'raw_material_id' => 'required|integer',
            'quantity' => 'required|numeric',
        ]);
    
        $usage_id = $request->input('usage_id');
        $raw_material_id = $request->input('raw_material_id');
        $quantity = $request->input('quantity');
    
        $existingPivot = RawMaterialUsagePivot::where('usage_id', $usage_id)
            ->where('raw_material_id', $raw_material_id)
            ->first();
    
        if ($existingPivot) {
            $existingPivot->quantity += $quantity;
            $existingPivot->save();

            flash($existingPivot->rawMaterial?->name.' quantity has been updated!', 'success');
            return back();
        } else {
            $pivot = new RawMaterialUsagePivot();
            $pivot->usage_id = $usage_id;
            $pivot->raw_material_id = $raw_material_id;
            $pivot->quantity = $quantity;
            $pivot->save();

            flash('Raw Material item has been saved successfully!', 'success');
            return back();
        }
    }


    public function deductQuantityRawMaterial(Usage $usage)
    {
        if (!$usage) {
            flash('Usage ID not found', 'warning');
            return redirect()->back();
        }

        $items = $usage->rawMaterials;

        $errors = false;
        $failedRawMaterials = [];

        foreach ($items as $item) {
            $quantityToDeduct = $item->pivot->quantity;
            $rawMaterial = RawMaterial::find($item->id);

            if (!$rawMaterial || $rawMaterial->quantity < $quantityToDeduct) {
                $errors = true;
                $failedRawMaterials[] = $rawMaterial->code;
                break;
            }
        }

        if ($errors) {
            $failedDetails = [];
            foreach ($failedRawMaterials as $code) {
                $rawMaterial = RawMaterial::where('code', $code)->first();
                $failedDetails[] = $rawMaterial->code . ' (Stock: ' . $rawMaterial->quantity . ', Quanity to Deduct: ' . $quantityToDeduct . ')';
            }

            flash('Deduction failed for the following Raw Materials: ' . implode(', ', $failedDetails), 'warning');
            return redirect()->back();
        }

        foreach ($items as $item) {
            $quantityToDeduct = $item->pivot->quantity;
            $rawMaterial = RawMaterial::find($item->id);

            $rawMaterial->quantity -= $quantityToDeduct;
            $rawMaterial->save();
        }

        $usage->is_submitted = true;
        $usage->save();

        flash('Raw Material quantities deducted successfully', 'success');
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usage $usage)
    {
        $validatedData = $request->validate([
            'date' => ['required','date', Rule::unique('usages', 'date')->ignore($usage->id)],
            'note' => ['nullable', 'string'],
        ]);

        $usage->update($validatedData);

        flash('Usage has been Updated Successfully!', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usage $usage)
    {
        $usage->delete();

        flash('Usage has been deleted', 'success');
        return back();
    }
}
