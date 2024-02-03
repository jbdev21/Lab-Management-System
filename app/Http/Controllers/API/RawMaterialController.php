<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\RawMaterialUsagePivot;
use App\Models\Usage;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    function rawMaterialSearch(Request $request){
        $keyword = $request->keyword;

        return RawMaterial::search($keyword)->get()
        ->map(function($rawMaterial){
            return [
                'id' => $rawMaterial->id,
                'code' => $rawMaterial->code,
                'name' => $rawMaterial->name,
                'quantity' => $rawMaterial->quantity,
                'unit' => $rawMaterial->unit
            ];
        });
    }

    public function updateRawMaterialQuantity(Request $request)
    {
        $rawMaterialId = $request->input('raw_material_id');
        $newQuantity = $request->input('new_value');

        $usageId = $request->input('usage_id');

        $usage = Usage::find($usageId);

        if (!$usage) {
            return response()->json(['message' => 'Usage not found'], 404);
        }

        $usage->rawMaterials()->updateExistingPivot($rawMaterialId, ['quantity' => $newQuantity]);

        return response()->json(['message' => 'Quantity updated successfully']);
    }

    public function rawMaterialUsageDelete(Request $request)
    {
        $usageId = $request->input('usage_id');
        $rawMaterialId = $request->input('raw_material_id');

        Usage::find($usageId)->rawMaterials()->detach($rawMaterialId);

        return response()->json(['success' => true]);
    }
}
