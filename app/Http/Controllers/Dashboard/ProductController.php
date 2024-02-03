<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(['stocks' => function ($query) {
            $query->latest()->first();
        }])->paginate(30);

        return view('dashboard.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
            'description' => 'required|string',
            'unit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'retail_price' => 'required|numeric'
        ]);

        $product = Product::create($validatedData);

        flash('Product has been Created Successfully!', 'success');
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, Request $request)
    {
        $product->load(['stocks', 'stocks.user', 'deliveryReceipts']);

        return match ($request->tab) {
            default => $this->stockHistoryTab($product, $request),
            'delivery-receipts' => $this->deliveryReceiptTab($product, $request)
        };
    }

    function stockHistoryTab($product, $request){
        $stockHistory = $product->stocks()->with(['user'])->paginate();
        return view("dashboard.product.show.stock_history", [
            'stockHistory' => $stockHistory,
            'product' => $product
        ]);
    }

    function deliveryReceiptTab($product, $request){
        $deliveryReceipts = $product->deliveryReceipts()->paginate();
        return view("dashboard.product.show.delivery_receipt", [
            'deliveryReceipts' => $deliveryReceipts,
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('dashboard.product.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'brand_name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
            'description' => 'required|string',
            'unit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'retail_price' => 'required|numeric'
        ]);

        $product->update($validatedData);

        flash('Product has been Updated Successfully!', 'success');
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        flash('Product has been deleted', 'success');
        return redirect()->route('dashboard.product.index');
    }
}
