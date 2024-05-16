<?php
    
namespace App\Http\Controllers;

use App\Models\stripeOrders;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use App\Mail\InvoiceMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\OrderedProduct;
use App\Models\Orders;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Session;
use Stripe;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data = session('data');
        $id = stripeOrders::insertGetId([
            //order table
            'customer_id' => $data['customer_id'],
            'discount' => $data['discount'] ?? null,
            'charge' => $data['charge'],
            'total' => $data['sub_total'] + $data['charge'] - $data['discount'] ?? 0 ,
            //billing table
            'bill_fname' => $data['bill_fname'],
            'bill_lname' => $data['bill_lname'] ?? null,
            'bill_email' => $data['bill_email'],
            'bill_country' => $data['bill_country'],
            'bill_city' => $data['bill_city'],
            'bill_zip' => $data['bill_zip'],
            'bill_phone' => $data['bill_phone'],
            'bill_company' => $data['bill_company'] ?? null,
            'bill_address' => $data['bill_address'] ?? null,
            'notes' => $data['notes'] ?? null,
            //shipping table
            'checkbox' => $data['checkbox'] ?? 0 ,
            'ship_fname' => $data['ship_fname'] ?? null,
            'ship_lname' => $data['ship_lname'] ?? null,
            'ship_email' => $data['ship_email'] ?? null,
            'ship_country' => $data['ship_country'] ?? null,
            'ship_city' => $data['ship_city'] ?? null,
            'ship_zip' => $data['ship_zip'] ?? null,
            'ship_phone' => $data['ship_phone'] ?? null,
            'ship_company' => $data['ship_company'] ?? null,
            'ship_address' => $data['ship_address'] ?? null,
        ]);

        $total = $data['sub_total'] + $data['charge'] - $data['discount'] ?? 0 ;
        return view('customer.stripe',[
            'id' => $id,
            'total'  => $total,
        ]);
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request , $id)
    {
        $data = stripeOrders::find($id);
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => 100 * $data->total,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);

        $order_id = 'order'.'-'. random_int(100000,900000);
        Billing::insert([
            'customer_id' => $data->customer_id,
            'order_id' => $order_id,
            'bill_fname' => $data->bill_fname,
            'bill_lname' => $data->bill_lname,
            'bill_country' => $data->bill_country,
            'bill_city' => $data->bill_city,
            'bill_zip' => $data->bill_zip,
            'bill_company' => $data->bill_company,
            'bill_email' => $data->bill_email,
            'bill_phone' => $data->bill_phone,
            'bill_address' => $data->bill_address,
            'notes' => $data->notes,
            'created_at' => Carbon::now(),
        ]);
        if ($data->checkbox == 1) {
            Shipping::insert([
                'customer_id' => $data->customer_id,
                'order_id' => $order_id,
                'ship_fname' => $data->ship_fname,
                'ship_lname' => $data->ship_lname,
                'ship_country' => $data->ship_country,
                'ship_city' => $data->ship_city,
                'ship_zip' => $data->ship_zip,
                'ship_company' => $data->ship_company,
                'ship_email' => $data->ship_email,
                'ship_phone' => $data->ship_phone,
                'ship_address' => $data->ship_address,
                'created_at' => Carbon::now(),
            ]);
        }        
        Orders::insert([
            'customer_id' => $data->customer_id,
            'order_id' => $order_id,
            'discount' => $data->discount,
            'charge' => $data->charge,
            'total' => $data->total,
            'created_at' => Carbon::now(), 
        ]);        

        $carts = Cart::where('customer_id' , $data->customer_id)->get();
        foreach ($carts as $cart) {
            OrderedProduct::insert([
                'customer_id' => $data->customer_id,
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
        }
        //Sending Mail --
        // Mail::to($request->bill_email)->send(new InvoiceMail($order_id));

        return redirect(url('/order_placed'));
    }
}
