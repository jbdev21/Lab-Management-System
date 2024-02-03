<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deliver;
use App\Models\Ledger;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delivers = Deliver::with(['user', 'purchaseOrder', 'purchaseOrderItems'])
                    ->orderBy("created_at", "desc")
                    ->paginate(10);

        return view("dashboard.deliver.index", [
            "delivers" => $delivers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'reference' => 'required|unique:delivers,reference',
            'note' => 'nullable|string',
            'items' => 'required|array',
        ]);
    
        DB::beginTransaction();
    
        try {
            $purchaseOrder = PurchaseOrder::find($request->input('purchase_order_id'));
            $deliver = Deliver::create([
                'purchase_order_id' => $request->input('purchase_order_id'),
                'user_id' => $request->user()->id,
                'reference' => $request->input('reference'),
                'note' => $request->input('note'),
                'amount' => 0.0,
            ]);
    
            // Handle pivot data
            $items = $request->input('items');
            $totalQuantity = 0;
            $totalAmount = 0.0;
            
            foreach ($items as $itemId) {
                $quantity = $request->input('quantity-' . $itemId);
                $amount = $request->input('amount-' . $itemId);
    
                $purchaseOrderItem = PurchaseOrderItem::find($itemId);
    
                if (!$purchaseOrderItem) {
                    throw new \Exception('Purchase Order Item not found');
                }
    
                $totalQuantity += $quantity;
                $totalAmount += $amount;
    
                // Increment received_quantity
                $purchaseOrderItem->increment('received_quantity', $quantity);

                // Increment RawMaterial quantity
                $rawMaterial = $purchaseOrderItem->purchasable;
                if($rawMaterial){
                    $rawMaterial->increment('quantity', $quantity);
                }
    
                $deliver->purchaseOrderItems()->attach($purchaseOrderItem, compact('quantity', 'amount'));
            }
    
            $purchaseOrderQuantity = $purchaseOrder->purchaseOrderItems->sum("quantity");
            $percentage = ($purchaseOrderQuantity > 0) ? ($totalQuantity * 100) / $purchaseOrderQuantity : 0;

            $deliver->update([
                'percentage' => $percentage,
                'amount' => $totalAmount,
            ]);

            //per item status update
            $deliver->status = ($purchaseOrder->deliveryReceipts->sum("percentage") === 100) ? 'full-received' : 'partial-received';
            $deliver->save();

            $totalAmount = $deliver->purchaseOrderItems->sum(function ($item) {
                return $item->pivot->amount ?? 0;
            });

            //deliver status update
            if ($purchaseOrder->deliveryReceipts->sum("percentage") == 100) {
                $purchaseOrder->update(['status' => 'full-received']);
                
                Ledger::create([
                    'fund_id' => $request->fund_id,
                    'user_id' => $request->user()->id,
                    'department_id' => $request->user()->department_id,
                    'particulars' => 'Purchase Order- <a href="' . route('dashboard.deliver.show', $deliver->id) . '">DR No.' . " [" .  $deliver->reference . "]</a> fully received payment.",
                    'amount' => $totalAmount,
                    'type' => 'credit',
                ]); 
                
            } else {
                $purchaseOrder->update(['status' => 'partial-received']);
                Ledger::create([
                    'fund_id' => $request->fund_id,
                    'user_id' => $request->user()->id,
                    'department_id' => $request->user()->department_id,
                    'particulars' => 'Purchase Order- <a href="' . route('dashboard.deliver.show', $deliver->id) . '">DR No.' . " [" .  $deliver->reference . "]</a> partially received payment.",
                    'amount' => $totalAmount,
                    'type' => 'credit',
                ]); 
            }            

            DB::commit();
    
            flash()->success('Delivery receipt created successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
    
            flash()->error('Error creating delivery receipt. ' . $e->getMessage());
            return redirect()->back();
        }
    }
    

    public function show(Deliver $deliver)
    {
        $deliver->load(['user', 'purchaseOrder', 'purchaseOrderItems.purchasable']);
    
        return view("dashboard.deliver.show", [
            "deliver" => $deliver
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deliver $deliver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deliver $deliver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deliver $deliver)
    {
        //
    }
}
