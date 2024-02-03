<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductList;
use Illuminate\Http\Request;

class ProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            "product_id" => "required",
            "customer_id" => "required",
            "price" => "required",
        ]);

        ProductList::create([
            "product_id"=> $request->product_id,
            "customer_id"=> $request->customer_id,
            "price"=> $request->price,
        ]);

        flash()->success("Product list added succesfully!");
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(ProductList $productList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductList $productList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductList $productList)
    {
        $this->validate($request, [
            "price" => "required",
        ]);

        $productList->update([
            "price"=> $request->price,
        ]);

        flash()->success("Product list updated succesfully!");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductList $productList)
    {
        $productList->delete();
        flash()->success("Product List deleted!");
        return back();
    }
}
