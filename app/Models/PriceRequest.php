<?php

namespace App\Models;

use App\Traits\HasApproval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRequest extends Model
{
    use HasFactory, HasApproval;

    protected $guarded = [];

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }

    function products(){
        return $this->belongsToMany(Product::class)
                ->using(ProductPriceRequestPivot::class)
                ->withPivot(['unit_price', 'quantity', 'discount', 'amount'])
                ->withTimestamps();
    }

    function computeNumbers(){
        $this->amount = 0;
        $discount = 0;
        $amount = 0;

        foreach($this->products as $product) {
            $amount += $product->pivot->amount;
            $discount += $product->pivot->discount;
        }

        $this->net = $amount - $discount;
        $this->amount = $amount;
        $this->discount = $discount;
        $this->save();
    }
}
