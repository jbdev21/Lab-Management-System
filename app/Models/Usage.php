<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Usage extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'date',
        'user_id',
        'note',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function rawMaterials()
    {
        return $this->belongsToMany(RawMaterial::class)
            ->using(RawMaterialUsagePivot::class)
            ->withPivot(['quantity']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
