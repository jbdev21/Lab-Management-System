<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DarkModeController extends Controller
{
    function update(Request $request){
        Cache::forget('dark-mode-' . $request->user()->id);
        Cache::rememberForever('dark-mode-' . $request->user()->id, function() use($request){
            return $request->darkmode ? 1 : 0;
        });
    }
}