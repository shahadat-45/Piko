<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    function banner(){
        $banner = Banner::all();
        return view('the_mart_control.banner' , [
            'banners' => $banner,
        ]);
    }
    function banner_add(Request $request){
        $request->validate([
            'title' => 'required' ,
            'image' => 'required' ,
        ]);
        $image = $request->image;
        $ext = $image->extension();
        $file_name = uniqid() . '.' . $ext;
        Image::make($image)->save(public_path('uploads/theMart/banner/' . $file_name));
        Banner::insert([
            'title' => $request->title,
            'image' => $file_name,
            'link' => $request->link,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success' , 'Banner added successfully');

    }
    function banner_status($id) {
        if (Banner::find($id)->status == 1) {            
            Banner::find($id)->update([
                'status' => '0'
            ]);
        }
        else{
            Banner::find($id)->update([
                'status' => '1'
            ]);
        }
        return back();
    }
    function banner_delete($id){
        $image = public_path('uploads'). '/theMart/banner/' . Banner::find($id)->image ;
        unlink($image);
        Banner::find($id)->delete();
        return back()->with('delete', 'Banner slider deleted successfully');
    }
}
