<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookingProductPivot extends Pivot
{
    use HasFactory;

    protected $table = 'booking_product';

    public $incrementing = true;


    function product(){
        return $this->belongsTo(Product::class);
    }

    function booking(){
        return $this->belongsTo(Booking::class);
    }
}
