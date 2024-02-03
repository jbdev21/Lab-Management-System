<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceipt extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date'
    ];

    function salesOrder(){
        return $this->belongsTo(SalesOrder::class);
    }

    function aging(){
        if($this->due_date >= now()){
            return 0;
        }
        $age = $this->due_date?->diffindays(now());
        return $age ?? 0;
    }

    function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }

    function products(){
        return $this->belongsToMany(Product::class)
                ->using(DeliveryReceiptProductPivot::class)
                ->withPivot(['unit_price', 'quantity', 'discount', 'amount'])
                ->withTimestamps();
    }
    
    function user(){
        return $this->belongsTo(User::class);
    }

    public function acknowledgementReceipts()
    {
        return $this->belongsToMany(AcknowledgementReceipt::class, 'payments')
            ->withTimestamps();
    }

    public function bankChecks()
    {
        return $this->morphMany(BankCheck::class, 'bankCheckable');
    }

}
