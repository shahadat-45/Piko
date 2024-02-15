<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand(){
        $brands = Brand::all();
        return view('brand&tags.brand', [
            'brands' => $brands,
        ]);
    }
    function brand_insert(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'required | max:1024 | mimes:jpg,jpeg,png,webp',           
        ]);
        $photo = $request->image;
        $ext = $photo->extension();
        $file_name = Str::lower(str_replace(' ', '-', $request->name)) . '-' . now()->format('d-m-Y') . '.' . $ext;
        Image::make($photo)->save(public_path('uploads/brand/' . $file_name));
        Brand::insert([
            "name"=> $request->name,
            "image"=> $file_name,
            "slug"=> Str::lower(str_replace(' ', '-', $request->name)). '.' . random_int(1000,9999),
            "created_at"=> Carbon::now(),
        ]);
        return back()->with('success', 'Brand name added successfully');
    }
    function brand_delete($id){
        Brand::find($id)->delete();
        return back()->with('delete_success', 'Brand name deleted successfully');
    }
}
