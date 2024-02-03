<?php

use App\Http\Controllers\Agent\AttachmentController;
use App\Http\Controllers\Agent\BookingController;
use App\Http\Controllers\Agent\CustomerController;
use App\Http\Controllers\Agent\DashboardController;
use App\Http\Middleware\AgentOnlyMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', AgentOnlyMiddleware::class],  'prefix' => 'agent', 'as' => 'agent.'], function(){
    Route::get('/', [DashboardController::class, 'index'])->name("index");
    Route::get('attachment/{attachment}/download', [AttachmentController::class, 'download'])->name("attachment.download");
    Route::resource('attachment', AttachmentController::class);
    
    Route::post('customer/{customer}/upload-attachment', [CustomerController::class, 'addAttachment'])->name("customer.add.attachment");
    Route::resource("customer", CustomerController::class);

    Route::get("booking/{booking}/products", [BookingController::class, 'listProduct'])->name("booking.list.product");
    Route::get("booking/{booking}/add-products", [BookingController::class, 'addProductForm'])->name("booking.add.product.form");
    Route::post("booking/{booking}/add-products", [BookingController::class, 'addProduct'])->name("booking.add.product");
    Route::delete("booking/{booking}/remove-products", [BookingController::class, 'removeProduct'])->name("booking.remove.product");
    Route::post("booking/{booking}/update-status", [BookingController::class, 'updateStatus'])->name("booking.update.status");
    
    Route::resource("booking", BookingController::class);
});
