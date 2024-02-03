<?php

use App\Http\Controllers\Dashboard\BankCheckHistoryController;
use App\Http\Controllers\Dashboard\AccountReceivableController;
use App\Http\Controllers\Dashboard\AcknowledgementReceiptController;
use App\Http\Controllers\Dashboard\AgentController;
use App\Http\Controllers\Dashboard\ApprovalController;
use App\Http\Controllers\Dashboard\AttachmentController;
use App\Http\Controllers\Dashboard\AttendanceController;
use App\Http\Controllers\Dashboard\BankCheckController;
use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\DarkModeController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DeductionController;
use App\Http\Controllers\Dashboard\DeductionEmployeeController;
use App\Http\Controllers\Dashboard\DeliverController;
use App\Http\Controllers\Dashboard\DeliveryReceiptController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\FundController;
use App\Http\Controllers\Dashboard\LeaveController;
use App\Http\Controllers\Dashboard\PayslipController;
use App\Http\Controllers\Dashboard\LedgerController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\PriceRequestController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProductListController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PurchaseOrderController;
use App\Http\Controllers\Dashboard\RawMaterialController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SalesOrderController;
use App\Http\Controllers\Dashboard\StockController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\UsageController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Middleware\DashboardUserMiddleware;
use App\Http\Middleware\MarkNotificationAsReadMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
        'middleware' => [
                'auth', 
                DashboardUserMiddleware::class,
                MarkNotificationAsReadMiddleware::class
            ],  
        'prefix' => 'dashboard', 
        'as' => 'dashboard.'
    ], 
    function(){
    Route::get('attachment/{attachment}/download', [AttachmentController::class, 'download'])->name("attachment.download");
    Route::resource('attachment', AttachmentController::class);
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('user/{id}/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/', [DashboardController::class, 'index'])->name("index");
    Route::resource('role', RoleController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('agent', AgentController::class);

    Route::resource('approval', ApprovalController::class);

    Route::resource('ledger', LedgerController::class);

    Route::post('sales-order/{sales_order}/update-status', [SalesOrderController::class, 'updateStatus'])->name("sales-order.update.status");
    Route::post('sales-order/add-product', [SalesOrderController::class, 'addProduct'])->name("sales-order.add.product");
    Route::delete('sales-order/remove-product', [SalesOrderController::class, 'removeProduct'])->name("sales-order.remove.product");
    Route::resource('sales-order', SalesOrderController::class);
    
    Route::post('price-request/{price_request}/update-status', [PriceRequestController::class, 'updateStatus'])->name("price-request.update.status");
    Route::post('price-request/{price_request}/add-product', [PriceRequestController::class, 'addProduct'])->name("price-request.add.product");
    Route::resource("price-request", PriceRequestController::class);
    Route::resource("delivery-receipt", DeliveryReceiptController::class);

    Route::post('customer/{customer}/upload-attachment', [CustomerController::class, 'addAttachment'])->name("customer.add.attachment");
    Route::post('customer/{customer}/verify', [CustomerController::class, 'verify'])->name('customer.verify');
    Route::resource('customer', CustomerController::class);
    Route::resource('product-list', ProductListController::class);

    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('raw-material', RawMaterialController::class);
    Route::resource('stock', StockController::class);

    Route::resource('purchase-order', PurchaseOrderController::class);
    Route::get('purchase-order-raw-material', [PurchaseOrderController::class, 'rawMaterialList'])->name("purchase.order.raw.material");
    Route::post('purchase-order/add-item', [PurchaseOrderController::class, 'addItem'])->name("purchase.order.add.item");
    Route::post('purchase-order/{purchase_order}/update-status', [PurchaseOrderController::class, 'updateStatus'])->name("purchase-order.update.status");
    Route::delete('purchase-orders/{purchase_order}/remove-item/{item}', [PurchaseOrderController::class, 'removeItem'])->name('purchase-order.remove-item');

    Route::resource('deliver', DeliverController::class);

    Route::resource('bank-check', BankCheckController::class);
    Route::resource('bank-check-history', BankCheckHistoryController::class);
    Route::resource('acknowledgement-receipt', AcknowledgementReceiptController::class);
    Route::get('account-receivable', [AccountReceivableController::class, 'index'])->name("account-receivable.index");
    Route::post('acknowledgement-receipt/{acknowledgement_receipt}/update-status', [AcknowledgementReceiptController::class, 'updateStatus'])->name("acknowledgement-receipt.update.status");
    Route::post('acknowledgement-receipt/add-payment', [AcknowledgementReceiptController::class, 'addPayment'])->name("acknowledgement.receipt.add.payment");
    Route::delete('acknowledgement-receipt/{acknowledgement-receipt-id}/delete-payment/{item}', [AcknowledgementReceiptController::class, 'deletePayment'])->name('acknowledgement.receipt.delete.payment');

    
    Route::resource('usage', UsageController::class);
    Route::post('usage/add-item', [UsageController::class, 'addItem'])->name("usage.add.item");
    Route::delete('usage/{usage}/rawMaterials/{rawMaterial}', [UsageController::class, 'deleteItem'])->name("usage.delete.item");
    Route::get('usage/deduct-quantity-rawmaterial/{usage}', [UsageController::class, 'deductQuantityRawMaterial'])->name("usage.deduct.quantity.rawMaterial");

    //HR Management
    Route::resource('employee', EmployeeController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::post('attendance/upload', [AttendanceController::class, 'upload'])->name('attendance.upload');
    Route::resource('deduction', DeductionController::class);
    Route::resource('deduction_employee', DeductionEmployeeController::class);
    Route::resource('payslip', PayslipController::class);
    Route::resource('leave', LeaveController::class);
    Route::post('payslip/invoice', [PayslipController::class, 'calculatePayslip'])->name('payslip.calculator');
    Route::delete('payslips/multiple-delete', [PayslipController::class, 'multipleDelete'])->name('payslip.multiple-delete');

    // Settings
    Route::resource('department', DepartmentController::class);
    Route::resource('fund', FundController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('supplier', SupplierController::class);

    
    Route::resource('booking', BookingController::class);

    Route::post('dark-mode/update', [DarkModeController::class, 'update']);
});
