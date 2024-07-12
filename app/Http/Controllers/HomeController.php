<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Gallery;
use App\Models\OrderedProduct;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function dashboard () {
        return view('backend.dashboard');
    }
    function logout () {
        Auth::logout();
        return redirect('/login');
    }
    function invoice(){
        return view('customer.Invoice');
    }
    function deals_of_the_day(){
        $products = Products::whereNotIn('product_type', [0])->get();
        $gallery = Gallery::all();
        return view('the_mart_control.deals_of_the_day', [
            'products' => $products,
            'gallery' => $gallery,
        ]);
    }
    function product_deals(Request $request){
        $id = $request->show;
        if (Products::find($id)->product_type == 1) {
            Products::find($id)->update([
                'product_type' => 2,
            ]);
        }else{
            Products::find($id)->update([
                'product_type' => 1,
            ]);
        }
        return back();
    }
    public function getMonthlySales()
    {
        $salesData = Orders::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'total' => $item->total,
                ];
            });

        return response()->json($salesData);
    }
}
