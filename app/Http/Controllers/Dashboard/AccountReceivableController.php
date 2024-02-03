<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DeliveryReceipt;
use Illuminate\Http\Request;

class AccountReceivableController extends Controller
{
    function index(Request $request){

        $deliveryReceipts = DeliveryReceipt::orderBy("created_at","desc")
                    ->with(['salesOrder', 'salesOrder.customer', 'user', 'acknowledgementReceipts'])
                    ->where("balance", ">", 0)
                    ->when($request->q, function($q) use ($request) {
                        $q->where("dr_number", $request->q);
                    })
                    ->orderBy("due_date", 'DESC')
                    ->paginate(20);

        return view("dashboard.account_receivable.index", [
            'deliveryReceipts' => $deliveryReceipts
        ]);
    }
}
