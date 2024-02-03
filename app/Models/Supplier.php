<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Supplier extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'address',
        'terms'
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }
}
