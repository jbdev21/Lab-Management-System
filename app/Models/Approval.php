<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Approval extends Model
{
    use HasFactory;


    function approvable(): MorphTo
    {
        return $this->morphTo();
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}
