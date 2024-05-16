<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('coupons.coupon' , [
            'coupons' => $coupons,
        ]);
    }
    function coupon_store(Request $request){
        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'coupon_type' => $request->coupon_type,
            'amount' => $request->amount,
            'validity' => $request->validity,
            'unique_id' => $request->coupon_type . uniqid() . $request->amount . $request->validity,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success' , 'Coupon added successfully');
    }
    function coupon_delete($id){
        Coupon::find($id)->delete();
        return back()->with('cpn_dlt' , 'Coupon deleted successfully');
    }
    
}
