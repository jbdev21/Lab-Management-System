<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const PENDING = "pending";
    const COLLECTED = "collected";
    const PARTIAL = "partial";

    protected $guarded = [];

    protected $casts = [
        'amount' => 'double',
    ];

    public function bankChecks()
    {
        return $this->morphMany(BankCheck::class, 'bankCheckable');
    }


    public function acknowledgementReceipt()
    {
        return $this->belongsTo(AcknowledgementReceipt::class, 'acknowledgement_receipt_id');
    }

    public function deliveryReceipt()
    {
        return $this->belongsTo(DeliveryReceipt::class, 'delivery_receipt_id');
    }

}
