<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['sub_category_name', 'updated_at'] , $softDelete = true;
    function rel_to_category(){
        return $this->belongsTo(Category::class, 'category_id') ;
    }
}
