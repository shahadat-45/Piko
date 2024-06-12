<?php

namespace App\Http\Controllers;

use App\Models\ExcitingOffers1;
use App\Models\ExcitingOffers2;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ExcitingOffers extends Controller
{
    function exciting_offer(){
        $data = ExcitingOffers1::find(1);
        $data2 = ExcitingOffers2::find(1);
        return view('the_mart_control.exciting_offer',[
            'data' => $data,
            'data2' => $data2,
        ]);
    }
    function exciting_offer_update(Request $request){
        // echo '<pre>';
        // print_r($request->all());

        if ($request->photo) {
            $pre_img = public_path('uploads/theMart/'. ExcitingOffers1::find(1)->photo );
            unlink($pre_img);
            
            $photo = $request->photo;
            $ext = $photo->extension();
            $file_name = Str::lower(str_replace(' ', '-', $request->title)) . '.' . $ext;
            Image::make($photo)->save(public_path('uploads/theMart/'. $file_name));
        
        ExcitingOffers1::find(1)->update([
            'title' => $request->title,
            'price' => $request->price,
            'dis_price' => $request->dis_price,
            'time' => $request->time,
            'product_link' => $request->link,
            'photo' => $file_name,
            'updated_at' => Carbon::now(),
        ]);
    }
    else {
        ExcitingOffers1::find(1)->update([
            'title' => $request->title,
            'price' => $request->price,
            'dis_price' => $request->dis_price,
            'time' => $request->time,
            'product_link' => $request->link,
            'updated_at' => Carbon::now(),
        ]);
        
    }
        return back()->with('success' , 'Update Successfully');
    }
    function exciting_offer2_update(Request $request){
        // echo '<pre>';
        // print_r($request->all());

        if ($request->photo) {
            $pre_img = public_path('uploads/theMart/'. ExcitingOffers2::find(1)->photo );
            unlink($pre_img);
            
            $photo = $request->photo;
            $ext = $photo->extension();
            $file_name = Str::lower(str_replace(' ', '-', $request->title)) . '.' . $ext;
            Image::make($photo)->save(public_path('uploads/theMart/'. $file_name));
        
        ExcitingOffers2::find(1)->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'product_link' => $request->link,
            'photo' => $file_name,
            'updated_at' => Carbon::now(),
        ]);
    }
    else {
        ExcitingOffers2::find(1)->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'product_link' => $request->link,
            'updated_at' => Carbon::now(),
        ]);
        
    }
        return back()->with('success2' , 'Update Successfully');
    }
}
