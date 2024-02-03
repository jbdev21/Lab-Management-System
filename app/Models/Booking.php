<?php

namespace App\Models;

use App\Traits\HasApproval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, HasApproval;

    protected $guarded = [];

    function products(){
        return $this->belongsToMany(Product::class)
                ->using(BookingProductPivot::class)
                ->withPivot(['unit_price', 'quantity', 'discount', 'amount'])
                ->withTimestamps();
    }

    function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    function customer(){
        return $this->belongsTo(Customer::class);
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
