<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function list($id){
        $user = User::findOrFail($id);
        return NotificationResource::collection($user->notifications()->paginate(8));
    }
}
