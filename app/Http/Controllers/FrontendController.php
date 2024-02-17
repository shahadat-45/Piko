<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function welcome(){
        return view('themart.themart');
    }
    function dropzone(){
        return view('dropzone');
    }
}
