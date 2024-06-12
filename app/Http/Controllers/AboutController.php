<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{
    function about_page(){
        $data = About::find(1);
        return view('the_mart_control.about_page',[
            'data' => $data,
        ]);
    }
    function about_update(Request $request){
        if ($request->photo) {
            $pre_img = public_path('uploads/theMart/'. About::find(1)->photo );
            unlink($pre_img);
            
            $photo = $request->photo;
            $ext = $photo->extension();
            $file_name = 'about_page_banner' . '.' . $ext;
            Image::make($photo)->save(public_path('uploads/theMart/'. $file_name));
        
        About::find(1)->update([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $file_name,
            'updated_at' => Carbon::now(),
        ]);
        }
        else {
            About::find(1)->update([
                'title' => $request->title,
                'description' => $request->description,
                'updated_at' => Carbon::now(),
            ]);            
        }
        return back()->with('success' , 'Update Successfully');
    }
}
