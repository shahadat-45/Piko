<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['quantity' , 'updated_at'];

    function rel_to_product(){
        return $this->belongsTo(Products::class , 'product_id');
    }
    function rel_to_inventory(){
        return $this->hasMany(Inventory::class , 'product_id' , 'product_id');
    }

}
