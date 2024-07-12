<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\ContactMassage;
use App\Models\Country;
use App\Models\ExcitingOffers1;
use App\Models\ExcitingOffers2;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Inventory;
use App\Models\Newsletter;
use App\Models\OrderedProduct;
use App\Models\Products;
use App\Models\Size;
use App\Models\Tags;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class FrontendController extends Controller
{
    function welcome(){
        $banner = Banner::all();
        $offer = ExcitingOffers1::find(1);
        $offer2 = ExcitingOffers2::find(1);
        $product = Products::where('product_type', 1)->latest()->take(3)->get();
        $deals_of_the_day = Products::where('product_type', 2)->latest()->take(2)->get();
        $trendingProducts = Products::select('products.*')
            ->join('ordered_products', 'products.id', '=', 'ordered_products.product_id')
            // ->where('ordered_products.created_at', '>=', now()->subDays(7)) // Adjust timeframe as needed
            ->groupBy('products.id')
            ->orderByRaw('SUM(ordered_products.quantity) DESC')
            ->selectRaw('count(ordered_products.quantity) as total') // I made it.
            ->limit(3)
            ->get();
        $top_rated = Products::select('products.*')
            ->join('ordered_products', 'products.id', '=', 'ordered_products.product_id')
            ->groupBy('products.id')
            ->orderByRaw('SUM(ordered_products.star) DESC')
            ->limit(3)
            ->get();
        return view('themart.themart' , [
            'banners' =>  $banner,
            'offers' =>  $offer,
            'offers2' =>  $offer2,
            'products' =>  $product,
            'trendingProducts' =>  $trendingProducts,
            'deals_of_the_day' =>  $deals_of_the_day,
            'top_rated' =>  $top_rated,
        ]);
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

        $all = Cookie::get('recent_view');
        if(!$all){
            $all = '[]';
        }
        $all_info = json_decode($all , true);
        $all_info = Arr::prepend($all_info , $id);
        $recent_product = json_encode($all_info);
        Cookie::queue('recent_view' , $recent_product , 100);

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
    function get_price(Request $request){
        $price = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->after_discount;
        echo '$' . $price;
    }
    function old_price(Request $request){
        $price = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->new_price;
        echo '$' . $price;
    }
    function checkout(){
        $countries = Country::all();
        return view('themart.checkout',[
            'countries' => $countries,
        ]);
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
    function shop(Request $request){
        $categories = Category::all();
        $data = $request->all();
        $colors = Color::all();
        $sizes = Size::all();
        $tags = Tags::all()->take(9);

        $based = 'created_at';
        $type = 'DESC';

        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $based = 'product_name';
                $type = 'ASC';
            }
            else if($data['sort'] == 2){
                $based = 'product_name';
                $type = 'DESC';
            }
        }
        
        $products = Products::where('product_type', 1)->where(function ($q) use ($data) {

        $min = 1;
        $max = Inventory::max('new_price');

        if (!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined') {
            $q->where(function ($q) use ($data){
                $q->where('product_name', 'like', '%' . $data['q'] . '%');
                $q->orWhere('long_desp', 'like', '%' . $data['q'] . '%');
            });
        }
        if(!empty($data['ctd']) && $data['ctd'] != '' && $data['ctd'] != 'undefined'){
            $q->where(function ($q) use ($data) {
                $q->where('category_id' , $data['ctd']);
            });
        }
        if(!empty($data['col']) && $data['col'] != '' && $data['col'] != 'undefined' || !empty($data['size']) && $data['size'] != '' && $data['size'] != 'undefined'){
            $q->whereHas('rel_to_inventory' , function ($q) use ($data) {
                if(!empty($data['col']) && $data['col'] != '' && $data['col'] != 'undefined'){
                    $q->whereHas('rel_to_color' , function  ($q) use ($data) {
                        $q->where('colors.id' , $data['col']);                            
                    });
                }
                if(!empty($data['size']) && $data['size'] != '' && $data['size'] != 'undefined'){
                    $q->whereHas('rel_to_size' , function  ($q) use ($data) {
                        $q->where('sizes.id' , $data['size']);                            
                    });
                }
            });
        }
        if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' && !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
            $q->whereHas('rel_to_inventory' , function ($q) use ($data){
                if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined'){
                    $min = $data['min'];
                }
                if(!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                    $max = $data['max'];
                }
                $q->whereBetween('new_price' , [$min , $max]);
            });
        }
        if(!empty($data['tag']) && $data['tag'] != '' && $data['tag'] != 'undefined'){
            $q->where(function ($q) use ($data) {
                $all = '';
                foreach(Products::all() as $product){
                    $explode = explode(',' , $product->tags);
                    if (in_array($data['tag'] , $explode)) {
                        $all .= $product->id;
                    }
                }
                $explode2 = explode(',' , $all);
                $q->find($explode2);
            });
        }

        })->orderBy($based , $type)->get();

        return view('themart.shop',[
            'categories' => $categories,
            'products' => $products,
            'colors' => $colors,
            'sizes' => $sizes,
            'tags' => $tags,
        ]);
    }
    function recent(){
        $data = json_decode(Cookie::get('recent_view') , true) ;
        $recent_viewed = '';
        if($data == Null){
            $recent_viewed = [];
        }else{
            $recent_viewed = array_unique($data);
            $recent_viewed = array_reverse($recent_viewed);
        }
        $recent_viewed = Products::find($recent_viewed);
        return view('themart.recent_view' , [
            'data' => $recent_viewed,
        ]);
    }
    function contact(){
        return view('themart.contact');
    }
    function contact_massage_store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'service' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        ContactMassage::insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'service' => $request->service,
            'message' => $request->message,
        ]);
        return back()->with('success' , 'Your Message Sent Successfully.');
    }
}
