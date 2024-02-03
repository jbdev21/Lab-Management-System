<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RawMaterialUsagePivot extends Pivot
{
    protected $table = 'raw_material_usage';

    public $incrementing = true;

    function rawMaterial(){
        return $this->belongsTo(RawMaterial::class);
    }

    function usage(){
        return $this->belongsTo(Usage::class);
    }
}
