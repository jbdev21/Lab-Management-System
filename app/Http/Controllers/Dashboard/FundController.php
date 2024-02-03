<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Http\Request;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Fund::TYPES;
        $funds = Fund::paginate(20);

        return view("dashboard.funds.index", [
            'funds' => $funds,
            'types' => $types,
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
            'type' => ['required'],
            'name' => ['required'],
            'account_name' => ['required'],
            'reference' => ['required', 'unique:funds,reference'],
            'amount' => ['required']
        ]);

        $fund = new Fund;
        $fund->type = $request->type;
        $fund->name = $request->name;
        $fund->account_name = $request->account_name;
        $fund->reference = $request->reference;
        $fund->amount = $request->amount;
        $fund->details = $request->details;
        $fund->save();

        flash()->success("Fund item added!");
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Fund $fund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund)
    {
        $types = Fund::TYPES;
        return view("dashboard.funds.edit", [
            'types' => $types,
            'fund' => $fund
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fund $fund)
    {
        $this->validate($request, [
            'type' => ['required'],
            'name' => ['required'],
            'account_name' => ['required'],
            'reference' => ['required', 'unique:funds,reference,' . $fund->id]
        ]);

        $fund->type = $request->type;
        $fund->name = $request->name;
        $fund->account_name = $request->account_name;
        $fund->reference = $request->reference;
        $fund->details = $request->details;
        $fund->save();

        flash()->success("Fund item updated!");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund)
    {
        if($fund->ledgers()->count()){
            flash()->warning("You cannot delete this fund because there is a record attached to this item in the ledger");
            return back();
        }

        $fund->delete();
        return back();
    }
}
