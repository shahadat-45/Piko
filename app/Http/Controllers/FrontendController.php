<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function welcome(){
        $banner = Banner::all();
        return view('themart.themart' , [
            'banners' =>  $banner,
        ]);
    }
    function dropzone(){
        return view('dropzone');
    }
}
