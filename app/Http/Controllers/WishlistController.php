<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    function wishlist(){
        $wishlist = Wishlist::where('customer_id' , Auth::guard('customer')->id())->get();
        return view('themart.wishlist',[
            'wishlist' => $wishlist,
        ]);
    }
    function add_to_wishlist($id){
        Wishlist::insert([
            'customer_id' => Auth::guard('customer')->id(),
            'product_id' => $id,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }
    function delete_wishlist($id){
        Wishlist::where('product_id' , $id)->where('customer_id' , Auth::guard('customer')->id())->delete();
        return back();
    }
}
