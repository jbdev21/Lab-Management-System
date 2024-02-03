<?php

namespace App\Traits;

use App\Models\Delivery;
use App\Models\DeliveryMaterialPivot;
use App\Models\Document;
use App\Models\Material;

trait HasDocumentTrait{

    public function documents(){
        return $this->morphMany(Document::class, 'documentable');
    }

}