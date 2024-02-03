<?php

namespace App\Providers;

use App\Models\Approval;
use App\Models\Booking;
use App\Models\BookingProductPivot;
use App\Models\Leave;
use App\Models\Ledger;
use App\Models\PriceRequest;
use App\Models\ProductSalesOrderPivot;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Observers\ApprovalObserver;
use App\Observers\BookingObserver;
use App\Observers\BookingProductPivotObserver;
use App\Observers\LeaveObserver;
use App\Observers\LedgerObserver;
use App\Observers\PriceRequestObserver;
use App\Observers\ProductSalesOrderPivotObserver;
use App\Observers\PurchaseOrderObserver;
use App\Observers\SalesOrderObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
        \Spatie\Flash\Flash::levels([
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'error' => 'alert-danger',
        ]);

        Paginator::useBootstrapFive();

        PriceRequest::observe(PriceRequestObserver::class);
        SalesOrder::observe(SalesOrderObserver::class);
        PurchaseOrder::observe(PurchaseOrderObserver::class);
        ProductSalesOrderPivot::observe(ProductSalesOrderPivotObserver::class);
        BookingProductPivot::observe(BookingProductPivotObserver::class);
        Approval::observe(ApprovalObserver::class);
        Leave::observe(LeaveObserver::class);
        Ledger::observe(LedgerObserver::class);
        Booking::observe(BookingObserver::class);
    }
}
