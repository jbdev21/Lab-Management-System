<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', fn() => view('welcome'));

include "dashboard.php";
include "agent.php";

Route::get("try-websocket", function(){
    $user = App\Models\User::find(1);
    $customer = App\Models\Customer::first();

    $user->notify(
    new App\Notifications\Dashboard\NewCustomerNotification($customer)
    );

});