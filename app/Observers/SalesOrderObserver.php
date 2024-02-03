<?php

namespace App\Observers;

use App\Models\SalesOrder;

class SalesOrderObserver
{

    public function created(SalesOrder $salesOrder): void
    {
        $salesOrder->so_number = str_pad($salesOrder->id, 8, '0', STR_PAD_LEFT);
        $salesOrder->due_date = $salesOrder->effectivity_date->addDays($salesOrder->term); // add due date
        $salesOrder->save();
    }

    /**
     * Handle the SalesOrder "updated" event.
     */
    public function updated(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "deleted" event.
     */
    public function deleted(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "restored" event.
     */
    public function restored(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "force deleted" event.
     */
    public function forceDeleted(SalesOrder $salesOrder): void
    {
        //
    }
}
