<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class RawMaterial extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'code',
        'name',
        'quantity',
        'unit',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }

    public function purchaseOrderItems()
    {
        return $this->morphMany(PurchaseOrderItem::class, 'purchasable');
    }
}
