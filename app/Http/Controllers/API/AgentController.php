<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    function select2(Request $request){
        return User::where('name', 'LIKE', '%' . $request->searchTerm . '%')
                ->where("is_agent", 1)
                ->take(8)
                ->get()
                ->map(function($q){
                    return [
                        'id' => $q->id,
                        'text' => $q->name,
                    ];
                });
    }
}
