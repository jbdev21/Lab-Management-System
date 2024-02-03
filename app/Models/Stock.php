<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Stock extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'product_id',
        'batch_code',
        'manufacture_date',
        'expiration_date',
        'quantity',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'manufacture_date' => 'date'
    ];

    public function toSearchableArray()
    {
        $this->load('product');

        $array = $this->toArray();

        if ($this->product) {
            $array['product_name'] = $this->product->name;
            $array['product_abbreviation'] = $this->product->abbreviation;
        }

        // Calculate stock status
        $now = now();
        $expirationDate = \Carbon\Carbon::parse($this->expiration_date);

        if ($expirationDate->isPast()) {
            $array['stock_status'] = 'expired';
        } elseif ($expirationDate->diffInMonths($now) <= 6) {
            $array['stock_status'] = 'near_expire';
        } else {
            $array['stock_status'] = 'good_condition';
        }

        return $array;
    }

    function getStatusAttribute(){
        if ($this->expiration_date->isPast()) {
            $status = 'expired_disposed';
        } elseif ($this->expiration_date->diffInMonths(now()) <= 6) {
            $status = 'near_expire';
        } else {
            $status = 'good_condition';
        }

        return $status;
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($stock) {
            $stock->user_id = Auth::id();

            // $stock->batch_code = $stock->generateUniqueBatchCode($stock->product->abbreviation);
        });
    }

    // private function generateUniqueBatchCode($abbreviation)
    // {
    //     $sequentialNumber = static::where('batch_code', 'like', "$abbreviation-%")
    //         ->max('batch_code');

    //     $sequentialNumber = (int) substr($sequentialNumber, strlen($abbreviation) + 1) + 1;

    //     $formattedSequentialNumber = str_pad($sequentialNumber, 7, '0', STR_PAD_LEFT);

    //     return "$abbreviation-$formattedSequentialNumber";
    // }


}
