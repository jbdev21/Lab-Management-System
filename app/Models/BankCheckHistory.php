<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCheckHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CLEARED = "cleared";

    protected $casts = [
        'deposit_date' => 'date'
    ];

    function user(){
        return $this->belongsTo(User::class);
    }

    function bankCheck(){
        return $this->belongsTo(BankCheck::class);
    }
}
