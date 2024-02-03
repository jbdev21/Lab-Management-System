<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderRawMaterialPivot extends Model
{
    protected $table = 'purchase_order_raw_material';

    public $incrementing = true;

    function product(){
        return $this->belongsTo(Product::class);
    }

    function salesOrder(){
        return $this->belongsTo(SalesOrder::class);
    }
}
