<?php

namespace App\Models;

use App\Contract\AttachmentContract;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customer extends Model implements AttachmentContract
{
    use HasFactory, HasAttachment, Searchable;

    protected $perPage = 30;

    function agent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    function addedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }

    function category(){
        return $this->belongsTo(Category::class);
    }

    function getVerifiedAttribute(){
        return $this->verified_at != null;
    }

}
