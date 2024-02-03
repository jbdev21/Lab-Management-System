<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSalesOrderPivot extends Pivot
{
    protected $table = 'product_sales_order';

    public $incrementing = true;

    function product(){
        return $this->belongsTo(Product::class);
    }

    function salesOrder(){
        return $this->belongsTo(SalesOrder::class);
    }
}
