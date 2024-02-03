<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deliver;
use App\Models\DeliveryReceipt;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deliveryReceipts = DeliveryReceipt::orderBy("created_at","desc")
                            ->with(['salesOrder', 'user', 'salesOrder', 'salesOrder.customer'])
                            ->latest()
                            ->paginate(20);

        return view("dashboard.delivery_receipt.index", [
            "deliveryReceipts" => $deliveryReceipts
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
        $this->validate($request, [
            'sales_order_id' => ['required_if:order_type,sale_order', 'exists:sales_orders,id'],
            'purchase_order_id' => ['required_if:order_type,purchase_order', 'exists:purchase_orders,id'],
            'dr_number' => ['required', 'unique:delivery_receipts,dr_number']
        ]);

        DB::beginTransaction();
        try {
            $salesOrder = SalesOrder::find($request->sales_order_id);
            $dr = DeliveryReceipt::create([
                'user_id' => $request->user()->id,
                'sales_order_id' => $request->sales_order_id,
                'dr_number' => $request->dr_number,
                'note' => $request->note,
                'term' => $salesOrder->term,
                'due_date' => now()->addDays($salesOrder->term)->format("Y-m-d")
            ]);

            $pivotData = $salesOrder->products->map(function($q){
                            return $q->pivot;
                        });
                      
            $amount = 0;

            foreach($request->products as $productId){
                $salesOrderPivotProduct = $pivotData->where('product_id', $productId)->first();
                $quantity = $request['product-' . $productId];
                $dr->products()->attach([
                    $productId => [
                        'unit_price' => $salesOrderPivotProduct->unit_price,
                        'quantity' => $quantity,
                        'discount' => $salesOrderPivotProduct->discount,
                        'amount' => $salesOrderPivotProduct->amount,
                    ]
                ]);

                $amount += $salesOrderPivotProduct->amount;

                //Increment released quantiy
                DB::table("product_sales_order")
                    ->where("product_id", $productId)   
                    ->where("sales_order_id", $salesOrder->id)
                    ->increment('released_quantity', $quantity);   
            }

            // update it percentage
            $salesOrderQuanity = $salesOrder->products->sum("pivot.quantity");
            $deliveryReceiptQuanity = $dr->products->sum("pivot.quantity");

            if($salesOrderQuanity >= $deliveryReceiptQuanity) {
                $percentage = ($deliveryReceiptQuanity * 100) / $salesOrderQuanity;
            } else{
                $percentage = 100;
            }

            $dr->update([
                'percentage' => $percentage,
                'amount' => $amount,
                'balance' => $amount,
            ]);

            if($salesOrder->deliveryReceipts->sum("percentage") == 100){
                $salesOrder->update(['status' => 'full-released']);
            }else{
                $salesOrder->update(['status' => 'partial-released']);
            }

            flash()->success('Delivery Receipt added!');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error($e->getMessage());
            // flash()->error('System in saving the item. Please retry the process');
        }
        
        return back();        
    }
    
    /**
     * Display the specified resource.
     */
    public function show(DeliveryReceipt $deliveryReceipt, Request $request)
    {
        $deliveryReceipt->load(['salesOrder', 'salesOrder.customer', 'products']);

        return match ($request->tab) {
            default => $this->productsTab($deliveryReceipt, $request),
            'acknowledgement-receipt' => $this->acknowledgementReceiptsTab($deliveryReceipt, $request)
        };
    }

    function productsTab(DeliveryReceipt $deliveryReceipt, Request $request){
        $products = $deliveryReceipt->products;
        return view("dashboard.delivery_receipt.show.products", [
            'deliveryReceipt' => $deliveryReceipt,
            'products' => $products
        ]);
    }
    function acknowledgementReceiptsTab(DeliveryReceipt $deliveryReceipt, Request $request){
        $acknowledgementReceipts = $deliveryReceipt->acknowledgementReceipts()->with(['customer', 'user'])->latest()->paginate(20);
        return view("dashboard.delivery_receipt.show.acknowledgement_receipt", [
            'deliveryReceipt' => $deliveryReceipt,
            'acknowledgementReceipts' => $acknowledgementReceipts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryReceipt $deliveryReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryReceipt $deliveryReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryReceipt $deliveryReceipt)
    {
        //
    }
}
