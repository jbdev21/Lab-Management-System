<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\BankCheck;
use App\Models\Fund;
use Illuminate\Http\Request;

class BankCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $bankChecks = BankCheck::query()
                ->with([
                    'bankCheckable', 
                    'bankCheckable.deliveryReceipt',
                    'bankCheckable.deliveryReceipt.salesOrder',
                    'bankCheckable.deliveryReceipt.salesOrder.customer',
                    'bankCheckable.acknowledgementReceipt',
                    'lastestBankCheckHistory'
                ])
                ->latest()
                ->when($request->status, function($q) use ($request){
                    $q->where("status", $request->status);
                })
                ->when($request->q, function($q) use ($request){
                    $q->where("number", "like", '%' . $request->q . '%')
                        ->orWhere("bank", "like", '%' . $request->q . '%');
                })
                ->when($request->date_from, function($q) use ($request){
                        $q->where("check_date", ">=", $request->date_from)->when($request->date_to, fn($q) => $q->where("check_date", "<=", $request->date_to));
                    }, 
                    fn($e) => $e->where("check_date", ">=", now()->subWeek(2)->format("Y-m-d"))
                )
                ->paginate(20);

        return view("dashboard.bank_check.index", [
            'bankChecks' => $bankChecks
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BankCheck $bankCheck)
    {
        $funds = Fund::all();
        $bankCheck->load([
            'bankCheckHistories',
            'bankCheckHistories.user',
            'bankCheckable', 
            'bankCheckable.deliveryReceipt',
            'bankCheckable.deliveryReceipt.salesOrder',
            'bankCheckable.deliveryReceipt.salesOrder.customer',
            'bankCheckable.acknowledgementReceipt',
            'fund'
        ]);
        return view("dashboard.bank_check.show", [
            'bankCheck' => $bankCheck,
            'funds' => $funds
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankCheck $bankCheck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankCheck $bankCheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankCheck $bankCheck)
    {
        //
    }
}
