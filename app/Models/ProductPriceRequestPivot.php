<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductPriceRequestPivot extends Pivot
{
    protected $table = 'product_price_request';

    function priceRequest(){
        return $this->belongsTo(PriceRequest::class);
    }
    
    function product(){
        return $this->belongsTo(Product::class);
    }
}
