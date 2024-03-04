<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\NewsletterEmails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class NewsletterController extends Controller
{
    function newsletter(){
        $emails = NewsletterEmails::all();
        return view('the_mart_control.newsletter' , [
            'emails' => $emails,
        ]);
    }
    function newsletter_update(Request $request){
        if ($request->image) {
            $image = public_path('uploads/theMart/') . Newsletter::find(1)->image ;
            unlink($image);
            
            $image = $request->image;
            $ext = $image->extension();
            $file_name = 'newsletter' . uniqid() . '.' . $ext;
            Image::make($image)->save(public_path('uploads/theMart/' . $file_name));
            
            Newsletter::where('id', 1)->update([
                'title' => $request->title,
                'image' => $file_name,
            ]);
        }
        else{
            Newsletter::where('id', 1)->update([
                'title' => $request->title,
            ]);
        }
        
        return back();
    }
    function newsletter_store(Request $request){
        $request->validate([
            'newsletter' => 'required | email',
        ]);
        NewsletterEmails::insert([
            'emails' => $request->newsletter,
            'created_at' => Carbon::now(),
        ]);
        return redirect('/#newsletter')->with('email_submited' , 'Your email submited successfully');
    }
}
