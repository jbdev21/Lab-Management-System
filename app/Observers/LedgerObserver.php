<?php

namespace App\Observers;

use App\Models\Fund;
use App\Models\Ledger;

class LedgerObserver
{
    /**
     * Handle the Ledger "created" event.
     */
    public function created(Ledger $ledger): void
    {
        if ($ledger->fund) {
            $fund = Fund::find($ledger->fund_id);
    
            // Check ledger type and update fund amount accordingly
            if ($ledger->type === 'debit') {
                $fund->decrement("amount", $ledger->amount);
            } elseif ($ledger->type === 'credit') {
                $fund->increment("amount", $ledger->amount);
            }
        }
    }

    /**
     * Handle the Ledger "updated" event.
     */
    public function updated(Ledger $ledger): void
    {
        //
    }

    /**
     * Handle the Ledger "deleted" event.
     */
    public function deleted(Ledger $ledger): void
    {
        if ($ledger->fund) {
            $fund = Fund::find($ledger->fund_id);
    
            // Check ledger type and update fund amount accordingly
            if ($ledger->type === 'debit') {
                $fund->increment("amount", $ledger->amount);
            } elseif ($ledger->type === 'credit') {
                $fund->decrement("amount", $ledger->amount);
            }
        }
    }

    /**
     * Handle the Ledger "restored" event.
     */
    public function restored(Ledger $ledger): void
    {
        //
    }

    /**
     * Handle the Ledger "force deleted" event.
     */
    public function forceDeleted(Ledger $ledger): void
    {
        //
    }
}
