<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DeliverItemPivot extends Pivot
{
    use HasFactory;

    protected $table = 'deliver_item';
}
