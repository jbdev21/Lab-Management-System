<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchasable()
    {
        return $this->morphTo();
    }

    function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
