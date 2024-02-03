<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function select2(Request $request){
        return Customer::where('business_name', 'LIKE', '%' . $request->searchTerm . '%')
                ->take(8)
                ->get()
                ->map(function($q){
                    return [
                        'id' => $q->id,
                        'text' => $q->business_name,
                    ];
                });
    }
}
