<?php

namespace App\Http\Controllers;

use App\Models\OrderedProduct;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function orders(){
        $orders = Orders::latest()->get();
        return view('orders.orders' , [
            'orders' => $orders,
        ]);
    }
    function status_change(Request $request , $id){
        Orders::find($id)->update([
            'status' => $request->status,
        ]);
        return back();
    }
    function review_store(Request $request , $id){
        OrderedProduct::where('customer_id' , Auth::guard('customer')->id())->where('product_id' , $id)->update([
            'review' => $request->comment,
            'star' => $request->stars,
        ]);
        return back();
    }
}
