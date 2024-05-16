<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Inventory;
use App\Models\OrderedProduct;
use App\Models\Orders;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    function order_confirm(Request $request){
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        $order_id = 'order'.'-'. random_int(100000,900000);
        if ($request->payment == 1) {
                Orders::insert([
                    'customer_id' => Auth::guard('customer')->id(),
                    'order_id' => $order_id,
                    'discount' => $request->discount,
                    'charge' => $request->charge,
                    'total' => $request->sub_total + $request->charge,
                    'created_at' => Carbon::now(), 
                ]);
                Billing::insert([
                    'customer_id' => Auth::guard('customer')->id(),
                    'order_id' => $order_id,
                    'bill_fname' => $request->bill_fname,
                    'bill_lname' => $request->bill_lname,
                    'bill_country' => $request->bill_country,
                    'bill_city' => $request->bill_city,
                    'bill_zip' => $request->bill_zip,
                    'bill_company' => $request->bill_company,
                    'bill_email' => $request->bill_email,
                    'bill_phone' => $request->bill_phone,
                    'bill_address' => $request->bill_address,
                    'notes' => $request->notes,
                    'created_at' => Carbon::now(),
                ]);
                if ($request->checkbox == 1) {
                    Shipping::insert([
                        'customer_id' => Auth::guard('customer')->id(),
                        'order_id' => $order_id,
                        'ship_fname' => $request->ship_fname,
                        'ship_lname' => $request->ship_lname,
                        'ship_country' => $request->ship_country,
                        'ship_city' => $request->ship_city,
                        'ship_zip' => $request->ship_zip,
                        'ship_company' => $request->ship_company,
                        'ship_email' => $request->ship_email,
                        'ship_phone' => $request->ship_phone,
                        'ship_address' => $request->ship_address,
                        'created_at' => Carbon::now(),
                    ]);
                }
            $carts = Cart::where('customer_id' , Auth::guard('customer')->id())->get();
                foreach ($carts as $cart) {
                    OrderedProduct::insert([
                        'customer_id' => Auth::guard('customer')->id(),
                        'product_id' => $cart->product_id,
                        'order_id' => $order_id,
                        'price' => $cart->rel_to_inventory->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->after_discount,
                        'color_id' => $cart->color_id,
                        'size_id' => $cart->size_id,
                        'quantity' => $cart->quantity,
                        'created_at' => Carbon::now(),
                ]);
                //reduce the quantity from inventory
                Inventory::where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->decrement('quantity' , $cart->quantity);
                //delete cart after order proccessed
                // Cart::find($cart->id)->delete();
                //Sending Mail --
                Mail::to($request->bill_email)->send(new InvoiceMail($order_id));
            }
            return redirect(url('/order_placed'));
        }
        elseif($request->payment == 2){
            $data = $request->all();
            return redirect('/pay')->with('data' , $data);
        }
        else{
            $data = $request->all();
            return redirect()->route('stripe')->with('data' , $data);
        }               
}
    function get_cities(Request $request){
        $str = '';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){            
            $str .= '<option value='. $city->id .'>'. $city->name .'</option>';
        }
        echo $str;
    }
    function order_placed(){
        return view('themart.order_placed');
    }
}
