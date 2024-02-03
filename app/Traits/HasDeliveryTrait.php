<?php

namespace App\Traits;

use App\Models\Delivery;
use App\Models\DeliveryMaterialPivot;
use App\Models\Material;

trait HasDeliveryTrait{

    public function deliveries(){
        return $this->morphMany(Delivery::class, 'deliverable_to')->with(['materials']);
    }

    public function deliveriesTo()
    {
        return $this->morphMany(Delivery::class, 'deliverable_to');
    }
    
    public function deliveriesFrom()
    {
        return $this->morphMany(Delivery::class, 'deliverable_from');
    }
}