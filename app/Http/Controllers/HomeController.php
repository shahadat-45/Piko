<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function dashboard () {
        return view('backend.dashboard');
    }
    function logout () {
        Auth::logout();
        return redirect('/login');
    }
}
