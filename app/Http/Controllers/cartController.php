<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartController extends Controller
{
    function add_to_cart(Request $request , $product_id){
        Cart::insert([
            'customer_id' => Auth::guard('customer')->id(),
            'product_id' => $product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('cart_added' , 'Cart added successfully');
    }
    function delete_cart($id){
        Cart::find($id)->delete();
        return back();
    }
    function cart(Request $request , $customer_id){
        $coupon = $request->coupon;
        $err_msg = '';
        $amount = '';
        $type = '';
        if($coupon != ''){
            if ($coupon == Coupon::where('coupon_name' , $coupon)->exists()) {
                if (Coupon::where('coupon_name' , $coupon)->first()->validity < Carbon::now()) {
                    $err_msg = 'Expired Coupon';
                }
                else{
                    $amount = Coupon::where('coupon_name' , $coupon)->first()->amount ; 
                    $type = Coupon::where('coupon_name' , $coupon)->first()->coupon_type ; 
                }
            }
            else{
                $err_msg = 'Invalid Coupon';
            }
        }
        $cart_items = Cart::where('customer_id' , $customer_id)->get();
        return view('themart.product_cart' , [
            'carts' => $cart_items,
            'err_msg' => $err_msg,
            'amount' => $amount,
            'type' => $type,
        ]);
    }
    function update_cart(Request $request){
        foreach ($request->quantity as $cart_id => $cart) {
            Cart::find($cart_id)->update([
                'quantity' => $cart,
                'updated_at' => Carbon::now(),
            ]);
        }
        return back();        
    }
}
