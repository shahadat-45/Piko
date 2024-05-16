<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Mail\InvoiceMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\OrderedProduct;
use App\Models\Orders;
use App\Models\Shipping;
use App\Models\Sslorders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {        
        $data = session('data');

        $total = $data['discount'] ? ($data['sub_total'] + $data['charge']) - $data['discount'] : $data['sub_total'] + $data['charge'] ;
        $post_data = array();
        $post_data['total_amount'] = $total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";        

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $data['bill_fname'] . '' . $data['bill_lname'],
                'email' => $data['bill_email'],
                'phone' => $data['bill_phone'],
                'amount' => $data['sub_total'] + $data['charge'],
                'status' => 'Pending',
                'address' => $data['bill_address'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                //order table
                'discount' => $data['discount'] ?? null,
                'charge' => $data['charge'],
                'customer_id' => $data['customer_id'],
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
                'checkbox' => $data['checkbox'] ?? null,
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

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "sslorders"
        # In sslorders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $data = Sslorders::where('transaction_id', $tran_id)->first();

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
            'total' => $data->amount,
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

        // $sslc = new SslCommerzNotification();

        // #Check order status in order tabel against the transaction id or order id.
        // $order_details = DB::table('sslorders')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'amount')->first();

        // if ($order_details->status == 'Pending') {
        //     $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        //     if ($validation) {
        //         /*
        //         That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
        //         in order table as Processing or Complete.
        //         Here you can also sent sms or email for successfull transaction to customer
        //         */
        //         $update_product = DB::table('sslorders')
        //             ->where('transaction_id', $tran_id)
        //             ->update(['status' => 'Processing']);

        //         echo "<br >Transaction is successfully Completed";
        //     }
        // } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
        //     /*
        //      That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
        //      */
        //     echo "Transaction is successfully Completed";
        // } else {
        //     #That means something wrong happened. You can redirect customer to your product page.
        //     echo "Invalid Transaction";
        // }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('sslorders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
