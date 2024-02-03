<?php
namespace App\Traits;

use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HasImage{

    public function images(){
        return $this->morphMany(ImageModel::class, 'imagable');
    }

    public function getThumbnailAttribute(){
        $key = $this->id . "_thumbnail";
        return Cache::rememberForever($key, function(){
            $thumbnail = $this->images()->where('type', 'thumbnail')->first();
            if($thumbnail){
                return str_replace('%5C', '/', Storage::url($thumbnail->path));
            }
    
            return  "/images/male-placeholder.png";
        });
    }
    
    public function removeThumbnail(){
        $thumbnail = $this->images()->where('type', 'thumbnail')->first();
        if($thumbnail){
            $thumbnail->delete();
        }
    }

    
    public function updateThumbnailImage($requestImage){
        $disk = config("filesystems.default");

        //generates a unique filename for it using hashName()
        $filename = $requestImage->hashName();

        // Resize the image to a maximum width of 150 pixels, this is form Intervention Image library
        $img = Image::make($requestImage->getRealPath())->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Upload the resized image to disk
        $path = 'images/' . $filename;
        Storage::disk($disk)->put($path, $img->stream()->__toString());

        $image = new ImageModel;
        $image->file_name = $requestImage->getClientOriginalName();
        $image->path = $path;
        $image->type = 'thumbnail';
        $image->file_size = Storage::disk($disk)->size($path);
        $image->imagable()->associate($this);
        $image->save();

        $key = $this->id . "_thumbnail";
        Cache::forget($key);

        return $image;
    }
    
    public function addImage($file, $type = 'thumbnail', $disk = null){
        $disk = $disk ?? config("filesystems.default");
        $image = new ImageModel;
        $image->file_name = $file->getClientOriginalName();
        $image->path = $file->store('images', $disk);
        $image->type = $type;
        $image->file_size = $file->getSize();
        $image->imagable()->associate($this);
        $image->save();
        return $image;
    }

    // public function resize(){
    //     $thumbnail = $this->thumbnail();
    //     if($thumbnail){
    //         resizeImage($thumbnail->path, 250, 250);
    //     }
    // }


}