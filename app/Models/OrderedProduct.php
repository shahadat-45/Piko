<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    use HasFactory;

    function rel_to_product(){
        return $this->belongsTo(Products::class , 'product_id');
    }
    function rel_to_customer(){
        return $this->belongsTo(Customer::class , 'customer_id');
    }
    
}
