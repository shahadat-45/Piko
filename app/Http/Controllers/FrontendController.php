<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Country;
use App\Models\ExcitingOffers1;
use App\Models\ExcitingOffers2;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Inventory;
use App\Models\Newsletter;
use App\Models\OrderedProduct;
use App\Models\Products;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function welcome(){
        $banner = Banner::all();
        $offer = ExcitingOffers1::find(1);
        $offer2 = ExcitingOffers2::find(1);
        return view('themart.themart' , [
            'banners' =>  $banner,
            'offers' =>  $offer,
            'offers2' =>  $offer2,
        ]);
    }
    function dropzone(){
        return view('dropzone');
    }
    function product_details($slug){
        $product_info = Products::where('slug' , $slug)->get();
        $id = $product_info->first()->id;
        $product = Products::find($id);
        $color = Inventory::where('product_id' , $id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
        $size = Inventory::where('product_id' , $id)->groupBy('size_id')->selectRaw('count(*) as total, size_id')->get();
        $gallery = Gallery::where('product_id' , $id)->get();
        $reviews = OrderedProduct::where('product_id' , $id)->whereNotNull('review')->latest()->get();
        $total_star = OrderedProduct::where('product_id' , $id)->whereNotNull('review')->sum('star');
        return view('themart.product-details' , [
            'products' => $product,
            'colors' => $color,
            'galleries' => $gallery,
            'sizes' => $size,
            'reviews' => $reviews,
            'total_star' => $total_star,
        ]);
    }
    function get_size(Request $request){
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id' , $request->color_id)->get() ;
        foreach ($sizes as $size) {
          if ($size->rel_to_size->size == 'NA') {
            $str .= '<li>
                        <input class="size" checked id="sz'.$size->size_id.'" type="radio" name="size_id" value="'. $size->size_id .'">
                        <label for="sz'.$size->size_id.'">'. $size->rel_to_size->size .'</label>
                    </li>';
          }
          else {
            $str .= '<li>
                        <input class="size" id="sz'.$size->size_id.'" type="radio" name="size_id" value="'. $size->size_id .'">
                        <label for="sz'.$size->size_id.'">'. $size->rel_to_size->size .'</label>
                    </li>';
          }
        }
        echo $str;
    }
    function get_stock(Request $request){
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
        $str = '<span>Stock:</span>' . ' ' . $quantity . '';
        echo $str;
    }

    function checkout(){
        $countries = Country::all();
        return view('themart.checkout',[
            'countries' => $countries,
        ]);
    }
    function shop(){
        return view('themart.shop');
    }
    function about(){
        $data = About::find(1);
        return view('themart.about',[
            'data' => $data,
        ]);
    }
    function faq(){        
        $faqs = Faq::all();
        return view('themart.faq',[
            'faqs' => $faqs,
        ]);
    }
}
