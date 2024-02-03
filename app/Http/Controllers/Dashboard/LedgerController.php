<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Fund;
use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    function index(Request $request){
        $funds = Fund::all();
        $departments = Department::all();
        $ledgers = Ledger::query()
                    ->when($request->q, fn($q) => $q->where("particulars", "LIKE", "%" . $request->q . '%'))
                    ->when($request->type, fn($q) => $q->where("type", $request->type))
                    ->when($request->fund, fn($q) => $q->where("fund_id", $request->fund))
                    ->when($request->department, fn($q) => $q->where("department_id", $request->department))
                    ->with(['user', 'department', 'fund'])
                    ->latest()
                    ->paginate(30);

        return view("dashboard.ledger.index", [
            'ledgers' => $ledgers,
            'funds' => $funds,
            'departments' => $departments,
        ]);
    }
}
