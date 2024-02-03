<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BankCheck;
use App\Models\BankCheckHistory;
use App\Models\Fund;
use App\Models\Ledger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankCheckHistoryController extends Controller
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
            'bank_check_id' => ['required', 'exists:bank_checks,id'],
            'status' => ['required'],
            'deposit_date' => ['required', 'date']
        ]);

        DB::beginTransaction();
        
        try {
            $bankCheck = BankCheck::find($request->bank_check_id);

            $bankHistory = BankCheckHistory::create([
                'bank_check_id'=> $request->bank_check_id,
                'status'=> $request->status,
                'reason'=> $request->reason,
                'deposit_date'=> $request->deposit_date,
                'user_id'=> $request->user()->id,
            ]);
    
            if($request->status == BankCheckHistory::CLEARED){
                // update the fund id in the bank check history
                $bankHistory->update(['fund_id' => $request->fund_id]);

                // add a ledger information
                Ledger::create([
                    'fund_id' => $request->fund_id,
                    'user_id' => $request->user()->id,
                    'department_id' => $request->user()->department_id,
                    'particulars' => $bankCheck->bank . " [" . $bankCheck->nummber . "] deposit cleared",
                    'amount' => $bankCheck->amount,
                    'type' => 'credit',
                ]); // fund is updated in the observer (LedgerObserver class)

                // update the DR of its bank check  
                $deliveryReceipt = $bankCheck->bankCheckable?->deliveryReceipt;
                if($deliveryReceipt){
                    $deliveryReceipt->decrement('balance', $bankCheck->amount);
                }
            }

            $bankCheck->update(['status' => $request->status]);
    
            flash()->success("Bank check history added!");

            DB::commit();
        } catch (Exception $e){
            flash()->warning($e->getMessage());
            DB::rollBack();
        }
        
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(BankCheckHistory $bankCheckHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankCheckHistory $bankCheckHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankCheckHistory $bankCheckHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankCheckHistory $bankCheckHistory)
    {
        $bankCheckHistory->delete();
        flash()->success("Bank check history deleted!");
        return back();
    }
}
