<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\SalesOrderStatusEnum;
use App\Enums\SalesOrderTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use Database\Factories\SalesOrderFactory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $salesOrders = SalesOrder::latest('effectivity_date')
                        ->with(['customer', 'agent'])
                        ->when($request->status, fn($q) => $q->where("status", $request->status))
                        ->latest()
                        ->paginate();
        
        $types = SalesOrderTypeEnum::cases();
        $statusTypes = SalesOrderStatusEnum::cases();

        return view("dashboard.sales_order.index", [
            "salesOrders"=> $salesOrders,
            "types"=> $types,
            "statusTypes"=> $statusTypes
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.sales_order.index");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => ['required'],
            'effectivity_date' => ['required', 'date'],
            'type' => ['required', Rule::in(SalesOrderTypeEnum::cases())],
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        $salesOrder = new SalesOrder;
        $salesOrder->customer_id = $customer->id;
        $salesOrder->agent_id = $customer->agent_id;
        $salesOrder->added_by = $request->user()->id;
        $salesOrder->effectivity_date = $request->effectivity_date;
        $salesOrder->term = $customer->terms;
        $salesOrder->type = $request->type;
        $salesOrder->save();
        flash()->success('Sales Order Created!');
        return redirect()->route('dashboard.sales-order.show', $salesOrder);
    }

    function addProduct(Request $request){
        $salesOrders = SalesOrder::findOrFail($request->sales_order_id);
        $product = Product::findOrFail($request->product_id);
        $salesOrders->products()->detach($request->product_id);
        $salesOrders->products()->attach([$product->id => [
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'amount' => $request->amount,
        ]]);

        flash()->success('Sales Order Updated!');
        return back();
    }

    function removeProduct(Request $request) {
        $salesOrders = SalesOrder::findOrFail($request->sales_order_id);
        $salesOrders->products()->detach($request->product_id);
        flash()->success('Sales Order Updated!');
        return back();
    }

    
    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load(['category', 'products', 'approvals', 'deliveryReceipts', 'deliveryReceipts.user'])
                ->loadCount(['products', 'approvals', 'deliveryReceipts']);

        return view("dashboard.sales_order.show", [
            "salesOrder"=> $salesOrder
        ]);
    }

    function updateStatus(Request $request, SalesOrder $salesOrder){
        $salesOrder->update(['status' => $request->status]);
        flash()->success('Sales Order Status Updated!');
        return back();
    }

// public function release(SalesOrder $salesOrder, Request $request){
//     $this->validate($request, [
//         'delivery_receipt_number' => ['required']
//     ]);

//     $salesOrder->update([
//         'delivery_receipt_date_time' => now(),
//         'delivery_receipt_number' => $request->delivery_receipt_number,
//         'delivery_receipt_user' => $request->user()->id,
//         'status' => 'released'
//     ]);

//     flash()->success('Sales Order Status Updated!');
//     return back();
// }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        //
    }
}
