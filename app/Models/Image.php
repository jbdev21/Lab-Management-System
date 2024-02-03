<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function imagable()
    {
        return $this->morphTo();
    } 




    function resize($width = 250, $height = 250, $isAspectRatio = true){
        $realPath = Storage::disk('public')->path($this->path);
        $img = ImageIntervention::make($realPath); // should be absolute path of the file
        $img->resize($width, $height, function ($constraint) use ($isAspectRatio) {
            if($isAspectRatio){
                $constraint->aspectRatio();
            }
        });
    
        return $this;
    }
}
