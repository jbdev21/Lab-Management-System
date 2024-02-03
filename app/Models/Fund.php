<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    const TYPES = [
        'bank', 'e-wallet', 'volt', 'others'
    ];

    function ledgers(){
        return $this->hasMany(Ledger::class);
    }
}
