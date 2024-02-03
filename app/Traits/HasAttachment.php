<?php 
namespace App\Traits;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\User;

trait HasAttachment{

    public function attachments(){
        return $this->morphMany(Attachment::class, 'attachable')->latest();
    }

    
}