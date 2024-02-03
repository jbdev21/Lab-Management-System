<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    function index(){
        $user = Auth::user();
        return view('dashboard.profile.index', compact('user'));
    }

    function update(Request $request){
        $this->validate($request, [
            'name' => ['required']
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

    
        if ($request->hasFile('thumbnail')) {
            $user->removeThumbnail();
            $user->updateThumbnailImage($request->thumbnail);
        }

        return back()->with('success', 'Your Account has been updated!');
    }
}
