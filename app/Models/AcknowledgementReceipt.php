<?php

namespace App\Models;

use App\Traits\HasApproval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class AcknowledgementReceipt extends Model
{
    use HasFactory, Searchable, HasApproval;

    const COLLECTED = "collected";
    const DRAFT = "draft";

    protected $guarded = [];

    protected $casts = [
        'amount' => 'double',
        'date_issued' => 'date'
    ];

    function getStatusColorAttribute(){
        return match ($this->status) {
            'draft' => 'secondary',
            'subject-for-approval' => 'warning',
            'collected' => 'success'
        };
    }


    public function payments()
    {
        return $this->hasMany(Payment::class, 'acknowledgement_receipt_id');
    }

    public function deliveryReceipt(){
        return $this->hasOneThrough(
            DeliveryReceipt::class, 
            Payment::class, 
            'acknowledgement_receipt_id',
            'id', 
            'id', 
            'delivery_receipt_id');
    }

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}
