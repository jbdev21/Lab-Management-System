<?php

namespace App\Models;

use App\Traits\HasApproval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PurchaseOrder extends Model
{
    use HasFactory, Searchable, HasApproval;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'double',
        'discount' => 'double',
        'freight' => 'double',
        'net' => 'double',
        'effectivity_date' => 'date',
        'due_date' => 'date',
    ];


    function getStatusColorAttribute(){
        return match ($this->status) {
            'draft' => 'secondary',
            'subject-for-approval' => 'warning',
            'partial-received' => 'danger',
            'full-received' => 'success'
        };
    }
    
    public function getTotalAttribute()
    {
        return $this->purchaseOrderItems->sum('subtotal');
    }

    function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    function category(){
        return $this->belongsTo(Category::class);
    }

    function deliveryReceipts(){
        return $this->hasMany(Deliver::class);
    }
}
