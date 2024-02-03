<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function salesOrderSearch(Request $request){
        $keyword = $request->keyword;

        return Product::search($keyword)->get()
        ->map(function($product){
            return [
                "id"=> $product->id,
                'name' => $product->brand_name
            ];
        });
    }

    function select2(Request $request){
        $keyword = $request->keyword;

        return Product::search($keyword)
            ->get()
            ->map(function($product){
                return [
                    "id"=> $product->id,
                    'text' => $product->brand_name . " - " . $product->description
                ];
            });
    }

    function productDetailsSearch(Request $request){
        if(empty($request->keyword)) {
            return [];
        }

        return Product::where('description', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('brand_name', 'LIKE', '%' . $request->keyword . '%')
                ->with(['salesOrder'])
                ->limit(8)
                ->get()
                ->map(function($product) use ($request) {
                    return [
                        "id"=> $product->id,
                        'abbreviation' => $product->abbreviation,
                        'brand_name' => $product->brand_name,
                        'description' => $product->description,
                        'retail_price' => $product->retail_price,
                        'unit' => $product->unit,
                        'type' => $product->type,
                        'recent_sales_order' => $product->pricingPerCustomer($request->customer_id, $request->sales_order_id)
                                                ->get()
                                                ->map(function($q){
                                                    return [
                                                        'created_at' => Carbon::parse($q->created_at)->format('Y/m/d'),
                                                        'delivery_receipt_id' => $q->delivery_receipt_id,
                                                        'delivery_receipt_number' => $q->delivery_receipt_number,
                                                        'unit_price' => $q->unit_price,
                                                    ];
                                                })
                    ];
                });
    }
}
