<?php

namespace App\Models;

use App\Traits\HasApproval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory, HasApproval;

    protected $casts = [
        'effectivity_date' => 'date',
        'due_date' => 'date',
        'delivery_receipt_date_time' => 'datetime',
    ];
    
    protected $guarded = [];

    function getStatusColorAttribute(){
        return match ($this->status) {
            'draft' => 'secondary',
            'subject-for-approval' => 'warning',
            'approved' => 'success',
            'full-released' => 'primary',
            'partial-released' => 'danger'
        };
    }

    function addedBy(){
        return $this->belongsTo(User::class, 'added_by');
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

    function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    function category(){
        return $this->belongsTo(Category::class);
    }

    function deliveryReceipts(){
        return $this->hasMany(DeliveryReceipt::class);
    }

    function products(){
        return $this->belongsToMany(Product::class)
                ->using(ProductSalesOrderPivot::class)
                ->withPivot(['unit_price', 'quantity', 'released_quantity', 'discount', 'amount'])
                ->withTimestamps();
    }
}
