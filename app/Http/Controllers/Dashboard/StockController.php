<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        $stocks = Stock::select(
                            'stocks.product_id',
                            'products.brand_name',
                            'products.unit',
                            DB::raw('MAX(stocks.batch_code) as latest_batch_code'),
                            DB::raw('SUM(stocks.quantity) as total_quantity'),
                            DB::raw("DATE_FORMAT(MAX(stocks.created_at), '%Y-%m-%d') as latest_created_at")  
                        )
                        ->groupBy('stocks.product_id', 'products.brand_name', 'products.unit')
                        ->orderBy('latest_batch_code', 'DESC')
                        ->join('products', 'stocks.product_id', '=', 'products.id')
                        ->paginate(30);
   

        return view('dashboard.stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::select('id', 'brand_name', 'abbreviation')->get();

        return view('dashboard.stock.create', [
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'manufacture_date' => 'required|date',
            'expiration_date' => 'required|date',
            'quantity' => 'required|integer',
            'batch_code' => 'required|string',
        ]);
            
        $exists = Stock::where([
            'product_id'=> $request->product_id,
            'batch_code'=> $request->batch_code,
            'manufacture_date'=> $request->manufacture_date,
            'expiration_date'=> $request->expiration_date,
        ])->first();   
        
        if($exists){
            $exists->increment('quantity', $request->quantity);
        }else{
            Stock::create($validatedData);
        }
    
        flash('Stock has been registered successfully!', 'success');
        return redirect()->route('dashboard.stock.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'add_quantity' => 'nullable|integer|min:1',
            'deduct_quantity' => 'nullable|integer|min:1',
            'manufacture_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'quantity' => 'nullable|integer|min:1',
        ]);
    
        if ($request->has('add_quantity')) {
            $addStock = $request->add_quantity;
            $stock->quantity += $addStock;
            $stock->save();
    
            flash('Quantity added successfully', 'success');
            return back();
        } elseif ($request->has('deduct_quantity')) {
            $deductStock = $request->deduct_quantity;
    
            if ($stock->quantity >= $deductStock) {
                $stock->quantity -= $deductStock;
                $stock->save();
                
                flash('Quantity deducted successfully', 'success');
                return back();
            } else {
                flash('Insufficient quantity to deduct!', 'warning');
                return back();
            }
        } elseif ($request->has('manufacture_date')) {
            $stock->manufacture_date = $request->manufacture_date;
            $stock->expiration_date = $request->expiration_date;
            $stock->quantity = $request->quantity;
            
            $stock->save();

            flash('Stock details updated successfully', 'success');
            return back();
        }
    
        flash('Invalid Request!', 'warning');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        flash('Stock has been deleted!', 'success');
        return redirect()->route('dashboard.stock.index');
    }
}
