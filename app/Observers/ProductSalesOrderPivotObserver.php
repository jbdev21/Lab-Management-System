<?php

namespace App\Observers;

use App\Models\ProductSalesOrderPivot;

class ProductSalesOrderPivotObserver
{
    /**
     * Handle the ProductSalesOrderPivot "created" event.
     */
    public function created(ProductSalesOrderPivot $productSalesOrderPivot): void
    {
        $productSalesOrderPivot->load(['salesOrder']);
        $salesOrder = $productSalesOrderPivot->salesOrder;
        $salesOrder->computeNumbers();
    }

    /**
     * Handle the ProductSalesOrderPivot "updated" event.
     */
    public function updated(ProductSalesOrderPivot $productSalesOrderPivot): void
    {
        $productSalesOrderPivot->load(['salesOrder']);
        $salesOrder = $productSalesOrderPivot->salesOrder;
        $salesOrder->computeNumbers();
    }

    /**
     * Handle the ProductSalesOrderPivot "deleted" event.
     */
    public function deleted(ProductSalesOrderPivot $productSalesOrderPivot): void
    {
        $productSalesOrderPivot->load(['salesOrder']);
        $salesOrder = $productSalesOrderPivot->salesOrder;
        $salesOrder->computeNumbers();
    }

    /**
     * Handle the ProductSalesOrderPivot "restored" event.
     */
    public function restored(ProductSalesOrderPivot $productSalesOrderPivot): void
    {
        $productSalesOrderPivot->load(['salesOrder']);
        $salesOrder = $productSalesOrderPivot->salesOrder;
        $salesOrder->computeNumbers();
    }

    /**
     * Handle the ProductSalesOrderPivot "force deleted" event.
     */
    public function forceDeleted(ProductSalesOrderPivot $productSalesOrderPivot): void
    {
        $productSalesOrderPivot->load(['salesOrder']);
        $salesOrder = $productSalesOrderPivot->salesOrder;
        $salesOrder->computeNumbers();
    }
}
