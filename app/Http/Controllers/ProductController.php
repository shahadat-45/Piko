<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Products;
use App\Models\SubCategory;
use App\Models\Tags;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $brands = Brand::all();
        $tags = Tags::all();
        return view('products.add_product',[
            'categories' => $categories,
            'brands' => $brands,
            'tags' => $tags,
        ]);
    }
    function getsubcategory(Request $request){
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();

        // $sub_cats = '';

        foreach ($subcategories as $key => $subcategory) {
            $sub_cats = '<option value="' . $subcategory->id . '">' .$subcategory->sub_category_name . '</option>';
            echo $sub_cats;
        }
    }
    function product_insert(Request $request){
        if ($request->tags == null) {
            $after_implode = null ;
        }
        else{
            $after_implode = implode(',', $request->tags);
        }
        $photo = $request->image;
        $ext = $photo->extension();
        $product_image = Str::lower(str_replace(' ', '-', $request->product_name)) . '_' . now()->format('d-m-Y') . '.' . $ext;
        Image::make($photo)->resize(700, 700)->save(public_path('uploads/product/' . $product_image));

        $id = Products::insertGetId([
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'brand_id' => $request->brand,
            'product_name' => $request->product_name,
            // 'price' => $request->price,
            'discount' => $request->discount,
            'after_discount' => $request->price - ($request->price / 100 * $request->discount),
            'product_type' => $request->product_type,
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'additional_info' => $request->additional_info,
            'tags' => $after_implode,
            'slug' => Str::lower(str_replace(' ', '-', $request->product_name)) . random_int(10000, 99999),
            'thumbnail' => $product_image,
            'created_at' => Carbon::now(),
        ]);
        $gallery = $request->gallery;
        foreach ($gallery as $galy) {
            $ext = $galy->extension();
            $file_name = uniqid() . '.' . $ext;
            Image::make($galy)->resize(700, 700)->save(public_path('uploads/product/' . $file_name));

            Gallery::insert([
                'product_id' => $id,
                'images' => $file_name,
                'created_at' => Carbon::now(),
            ]);
        }

        return back()->with('product_added', 'Product Added Successfully');
    }

    function product_list(){
        $products = Products::all();
        $gallery = Gallery::all();
        return view('products.product_list', [
            'products' => $products,
            'gallery' => $gallery,
        ]);
    }
    function product_view($id){
        $product = Products::find($id);
        $gallery = Gallery::where('product_id', $id)->get();
        return view('products.product_view',[
            'product' => $product,
            'gallery' => $gallery,
        ]);
    }
    function product_delete($id){
        $product = Products::find($id);        
        $preview_img = public_path('uploads/product/' . $product->thumbnail);
        unlink($preview_img);
        
        $gallery = Gallery::where('product_id', $id)->get();
        foreach ($gallery as $img) {
            $gallery_img = public_path('uploads/product/' . $img->images);
            unlink($gallery_img);            
            Gallery::where('product_id', $id)->delete();
        }
        Products::find($id)->delete();
        return back()->with('deleted', 'Product deleted successfully');
    }
}
