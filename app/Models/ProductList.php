<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    use HasFactory;

    protected $guarded = [];

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function product(){
        return $this->belongsTo(Product::class);
    }

    function deliveryReceipt(){
        return $this->belongsTo(DeliveryReceipt::class, 'lastest_dr');
    }
}
