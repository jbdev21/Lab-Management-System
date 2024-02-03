<?php
namespace App\Traits;

use App\Models\Category;

trait HasCategoryTrait
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}