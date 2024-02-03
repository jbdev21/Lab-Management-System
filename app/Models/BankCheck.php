<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'bank',
        'check_date',
        'amount',
        'status',
        'note',
        'bankCheckable_id',
        'bankCheckable_type',
    ];

    protected $casts = [
        'check_date' => 'date',
        'date_deposit' => 'date',
    ];

    public function bankCheckable()
    {
        return $this->morphTo(__FUNCTION__, 'bankCheckable_type', 'bankCheckable_id');
    }

    public function bankCheckHistories(){
        return $this->hasMany(BankCheckHistory::class)->latest();
    }
    public function lastestBankCheckHistory(){
        return $this->hasOne(BankCheckHistory::class)->latest();
    }

    public function fund(){
        return $this->belongsTo(Fund::class);
    }

}
