<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliver extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function purchaseOrderItems()
    {
        return $this->belongsToMany(PurchaseOrderItem::class, 'deliver_item')
            ->using(DeliverItemPivot::class)
            ->withPivot('quantity', 'amount')
            ->withTimestamps();
    }

    function user(){
        return $this->belongsTo(User::class);
    }

}
