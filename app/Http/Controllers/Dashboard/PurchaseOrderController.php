<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PurchaseOrderTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $purchaseOrders = PurchaseOrder::latest('effectivity_date')
                            ->whereType('Others')
                            ->with(['supplier', 'purchaseOrderItems'])
                            ->orderBy('po_number', 'DESC')
                            ->paginate(30);

                        $othersType = PurchaseOrderTypeEnum::OTHERS;

                        return view("dashboard.purchase_order.index", [
                            "purchaseOrders" => $purchaseOrders,
                            "othersType" => $othersType
                        ]);
    }

    public function rawMaterialList(Request $request)
    {

        $purchaseOrders = PurchaseOrder::latest('effectivity_date')
                            ->whereType('Raw Material')
                            ->with(['supplier', 'purchaseOrderItems'])
                            ->orderBy('po_number', 'DESC')
                            ->paginate(30);

                        $rawMaterialType = PurchaseOrderTypeEnum::RAW_MATERIAL;

                        return view("dashboard.purchase_order.raw_mat_list", [
                            "purchaseOrders" => $purchaseOrders,
                            "rawMaterialType" => $rawMaterialType
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
        // dd($request->all());
        $this->validate($request, [
            'supplier_id' => ['required'],
            'effectivity_date' => ['required', 'date'],
            'type' => ['required', Rule::in(PurchaseOrderTypeEnum::cases())],
        ]);

        $supplier = Supplier::findOrFail($request->supplier_id);

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->supplier_id = $supplier->id;
        $purchaseOrder->effectivity_date = $request->effectivity_date;
        $purchaseOrder->term = $supplier->terms;
        $purchaseOrder->type = $request->type;
        $purchaseOrder->save();

        flash()->success('Purchase Order Created!');
        return redirect()->route('dashboard.purchase-order.show', $purchaseOrder);
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $funds = Fund::all();
       $purchaseOrder->load(['category', 'approvals', 'deliveryReceipts', 'deliveryReceipts.user', 'purchaseOrderItems', 'purchaseOrderItems.purchasable'])->loadCount(['purchaseOrderItems', 'approvals', 'deliveryReceipts']);
        
        return view("dashboard.purchase_order.show", [
            "purchaseOrder"=> $purchaseOrder,
            'funds' => $funds
        ]);
    }

    function updateStatus(Request $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => $request->status]);
        flash()->success('Purchase Order Status Updated!');
        return back();
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'raw_material_id' => [
                'required_if:purchaseOrder.type,Raw Material',
                'numeric',
                'exists:raw_materials,id',
            ],
            'purchase_order_id' => ['required', 'numeric', 'exists:purchase_orders,id'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0'],
            'particular' => ['nullable', 'string'],
        ]);
    
        $purchaseOrder = PurchaseOrder::find($request->input('purchase_order_id'));
    
        if ($purchaseOrder->type == "Raw Material") {
            $rawMaterial = RawMaterial::find($request->input('raw_material_id'));
    
            $item = new PurchaseOrderItem([
                'purchase_order_id' => $request->input('purchase_order_id'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'subtotal' => $request->input('amount')
            ]);
    
            $rawMaterial->purchaseOrderItems()->save($item);
        } elseif($purchaseOrder->type == "Others") {
            $item = new PurchaseOrderItem([
                'purchase_order_id' => $request->input('purchase_order_id'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'subtotal' => $request->input('amount'),
                'particular' => $request->input('particular'),
            ]);
    
            $item->save();
        }
    
        flash()->success('Purchase Order Updated!');
        return back();
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'purchase_order_id' => ['required', 'numeric', 'exists:purchase_orders,id'],
            'item_id' => ['required', 'numeric', 'exists:purchase_order_items,id'],
        ]);
    
        $purchaseOrder = PurchaseOrder::find($request->input('purchase_order_id'));
    
        if ($purchaseOrder && $purchaseOrder->status == "draft") {
            $item = PurchaseOrderItem::find($request->input('item_id'));
    
            if ($item) {
                $item->delete();
    
                flash()->success('Item deleted successfully!');
            } else {
                flash()->error('Item not found!');
            }
        } else {
            flash()->error('Invalid purchase order or status not allowed for deletion!');
        }
    
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
