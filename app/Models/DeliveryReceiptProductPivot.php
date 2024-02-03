<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DeliveryReceiptProductPivot extends Pivot
{
    use HasFactory;

    protected $table = 'delivery_receipt_product';

    public $incrementing = true;


    function product(){
        return $this->belongsTo(Product::class);
    }

    function deliveryReceipt(){
        return $this->belongsTo(DeliveryReceipt::class);
    }
}
