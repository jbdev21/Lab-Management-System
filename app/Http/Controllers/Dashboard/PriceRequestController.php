<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PriceRequestStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\PriceRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class PriceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $priceRequests = PriceRequest::query()
                        ->with(['products','customer', 'user'])
                        ->withCount(['products', 'customer'])
                        ->latest('updated_at')
                        ->paginate();

        return view("dashboard.price_request.index", [
            'priceRequests' => $priceRequests,
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
        $priceRequest = new PriceRequest;
        $priceRequest->customer_id = $request->customer_id;
        $priceRequest->user_id = $request->user()->id;
        $priceRequest->note = $request->note;
        $priceRequest->status = PriceRequestStatusEnum::DRAFT;
        $priceRequest->save();

        flash()->success('Price request created!');
        return redirect()->route('dashboard.price-request.show', $priceRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(PriceRequest $priceRequest)
    {
        $priceRequest->load(['approvals', 'products'])->loadCount(['products', 'approvals']);
        return view('dashboard.price_request.show', [
            'priceRequest' => $priceRequest
        ]);
    }


    function updateStatus(Request $request, PriceRequest $priceRequest){
        $priceRequest->update(['status' => $request->status]);
        flash()->success('Sales Order Status Updated!');
        return back();
    }

    function addProduct(Request $request, PriceRequest $priceRequest){
        $product = Product::findOrFail($request->product_id);
        // $priceRequest->products()->detach($request->product_id);
        $priceRequest->products()->attach([$product->id => [
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'amount' => $request->amount,
        ]]);

        flash()->success('Price Request Updated!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceRequest $priceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceRequest $priceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceRequest $priceRequest)
    {
        flash()->success('Price Request deleted!');
        $priceRequest->delete();
        return back();
    }
}
