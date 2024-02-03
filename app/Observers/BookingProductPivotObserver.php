<?php

namespace App\Observers;

use App\Models\BookingProductPivot;

class BookingProductPivotObserver
{
    /**
     * Handle the BookingProductPivot "created" event.
     */
    public function created(BookingProductPivot $bookingProductPivot): void
    {
        $bookingProductPivot->load(['booking']);
        $booking = $bookingProductPivot->booking;
        $booking->computeNumbers();
    }

    /**
     * Handle the BookingProductPivot "updated" event.
     */
    public function updated(BookingProductPivot $bookingProductPivot): void
    {
        //
    }

    /**
     * Handle the BookingProductPivot "deleted" event.
     */
    public function deleted(BookingProductPivot $bookingProductPivot): void
    {
        //
    }

    /**
     * Handle the BookingProductPivot "restored" event.
     */
    public function restored(BookingProductPivot $bookingProductPivot): void
    {
        //
    }

    /**
     * Handle the BookingProductPivot "force deleted" event.
     */
    public function forceDeleted(BookingProductPivot $bookingProductPivot): void
    {
        //
    }
}
