<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    function rel_to_ctg(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    function rel_to_subctg(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    function rel_to_brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
