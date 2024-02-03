<?php 
namespace App\Traits;

use App\Models\Approval;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\User;

trait HasApproval{

    public function approvals(){
        return $this->morphMany(Approval::class, 'approvable')->latest();
    }

    
}