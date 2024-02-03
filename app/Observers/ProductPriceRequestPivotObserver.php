<?php

namespace App\Observers;

use App\Models\ProductPriceRequestPivot;

class ProductPriceRequestPivotObserver
{
    /**
     * Handle the ProductPriceRequestPivot "created" event.
     */
    public function created(ProductPriceRequestPivot $productPriceRequestPivot): void
    {
        $productPriceRequestPivot->load(['priceRequest']);
        $priceRequest = $productPriceRequestPivot->priceRequest;
        $priceRequest->computeNumbers();
    }

    /**
     * Handle the ProductPriceRequestPivot "updated" event.
     */
    public function updated(ProductPriceRequestPivot $productPriceRequestPivot): void
    {
        $productPriceRequestPivot->load(['priceRequest']);
        $priceRequest = $productPriceRequestPivot->priceRequest;
        $priceRequest->computeNumbers();
    }

    /**
     * Handle the ProductPriceRequestPivot "deleted" event.
     */
    public function deleted(ProductPriceRequestPivot $productPriceRequestPivot): void
    {
        $productPriceRequestPivot->load(['priceRequest']);
        $priceRequest = $productPriceRequestPivot->priceRequest;
        $priceRequest->computeNumbers();
    }

    /**
     * Handle the ProductPriceRequestPivot "restored" event.
     */
    public function restored(ProductPriceRequestPivot $productPriceRequestPivot): void
    {
        $productPriceRequestPivot->load(['priceRequest']);
        $priceRequest = $productPriceRequestPivot->priceRequest;
        $priceRequest->computeNumbers();
    }

    /**
     * Handle the ProductPriceRequestPivot "force deleted" event.
     */
    public function forceDeleted(ProductPriceRequestPivot $productPriceRequestPivot): void
    {
        $productPriceRequestPivot->load(['priceRequest']);
        $priceRequest = $productPriceRequestPivot->priceRequest;
        $priceRequest->computeNumbers();
    }
}
