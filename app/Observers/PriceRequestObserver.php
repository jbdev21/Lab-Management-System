<?php

namespace App\Observers;

use App\Models\PriceRequest;

class PriceRequestObserver
{
    /**
     * Handle the PriceRequest "created" event.
     */
    public function created(PriceRequest $priceRequest): void
    {
        $priceRequest->pr_number = str_pad($priceRequest->id, 8, '0', STR_PAD_LEFT); // add due date
        $priceRequest->save();
    }

    /**
     * Handle the PriceRequest "updated" event.
     */
    public function updated(PriceRequest $priceRequest): void
    {
        //
    }

    /**
     * Handle the PriceRequest "deleted" event.
     */
    public function deleted(PriceRequest $priceRequest): void
    {
        //
    }

    /**
     * Handle the PriceRequest "restored" event.
     */
    public function restored(PriceRequest $priceRequest): void
    {
        //
    }

    /**
     * Handle the PriceRequest "force deleted" event.
     */
    public function forceDeleted(PriceRequest $priceRequest): void
    {
        //
    }
}
