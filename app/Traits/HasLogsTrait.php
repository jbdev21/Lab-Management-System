<?php
namespace App\Traits;

use App\Models\Image as ImageModel;
use App\Models\Log;
use Illuminate\Support\Facades\Storage;

trait HasLogsTrait{

    public function logs(){
        return $this->morphMany(Log::class, 'loggable');
    }


    function addLog($description, $type = null){
        $log = new Log;
        $log->description = $description;

        if($type){
            $log->type = $type;
        }

        $this->logs()->save($log);
        
        return $this;
    }

}