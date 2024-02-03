<?php

use App\Http\Controllers\API\AgentController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\DeliveryReceiptController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RawMaterialController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("notification/{id}/list", [NotificationController::class, 'list']);
Route::post('update-role-permission', [RoleController::class, 'updatePermission']);
Route::get('/customer/select2', [CustomerController::class, 'select2']);
Route::get('/supplier/select2', [SupplierController::class, 'select2']);
Route::get('/agent/select2', [AgentController::class, 'select2']);
Route::get('/product/select2', [ProductController::class, 'select2']);
Route::post('/product/sales-order/search', [ProductController::class, 'salesOrderSearch']);
Route::post('/product/sales-order/details/search', [ProductController::class, 'productDetailsSearch']);
Route::post('/raw-material/search', [RawMaterialController::class, 'rawMaterialSearch']);
Route::post('/raw-material/update', [RawMaterialController::class, 'updateRawMaterialQuantity'])->name('api.raw-material.update');
Route::delete('/raw-material/delete', [RawMaterialController::class, 'rawMaterialUsageDelete'])->name('api.raw-material.delete');
Route::post('/delivery-receipt/search', [DeliveryReceiptController::class, 'deliveryReceiptSearch']);
Route::post('/delivery-receipts/detail-search', [DeliveryReceiptController::class, 'deliveryReceiptDetailSearch']);
