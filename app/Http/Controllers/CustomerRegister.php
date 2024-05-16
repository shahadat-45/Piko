<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class CustomerRegister extends Controller
{
    function register(){
        return view('themart.customer_register');
    }
    function register_store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required | email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if($request->password != $request->password_confirmation){
            return back()->with('pass_error', 'Password and confirm password not matched');
        }
        else{
            $pass = bcrypt($request->password);
            Customer::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $pass,
                'created_at' => Carbon::now(),
            ]);
        }
        return redirect('/user/login')->with('register_success' , 'Registered successfully');
    }
    function user_login(){
        return view('themart.customer_login');
    }
    function user_login_post(Request $request){
        if (Customer::where('email', $request->email)->exists()) {
           if (Auth::guard('customer')->attempt(['email'=>$request->email , 'password'=>$request->password])) {
            return redirect('/');
           }
           else {
               return back()->with('pass_error', 'Wrong password'); 
           }
        }
        else{
            return back()->with('email_error', 'Your Email is not exist');
        }

    }
    function user_logout(){
        Auth::guard('customer')->logout();
        return redirect('/user/login');
    }
    function user_profile(){
        $myorders = '';
        return view('themart.customr_profile' , [
            'myorders' => $myorders,
        ]);
    }
    function user_profile_update(Request $request){

        if (!$request->password == '') {
            if (!$request->photo == '') {
                if (!Auth::guard('customer')->user()->photo == null) {
                    $img = public_path('uploads/customer/') . Auth::guard('customer')->user()->photo;
                    unlink($img);
                }
                $photo = $request->photo;
                $extension = $photo->extension();
                $file_name = Auth::guard('customer')->id() . '_' . Auth::guard('customer')->user()->name . '.' . $extension;
                Image::make($photo)->save(public_path('uploads/customer/' . $file_name));
                Customer::find(Auth::guard('customer')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'country' => $request->country,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'photo' => $file_name,
                    'updated_at' => Carbon::now(),
                ]);
                
            }
            else{
                Customer::find(Auth::guard('customer')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'country' => $request->country,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'updated_at' => Carbon::now(),
                ]);
            }            
        }
        else {
            if (!$request->photo == '') {
                if (!Auth::guard('customer')->user()->photo == null) {
                    $img = public_path('uploads/customer/') . Auth::guard('customer')->user()->photo;
                    unlink($img);
                }
                $photo = $request->photo;
                $extension = $photo->extension();
                $file_name = Auth::guard('customer')->id() . '_' . Auth::guard('customer')->user()->name . '.' . $extension;
                Image::make($photo)->save(public_path('uploads/customer/' . $file_name));
                Customer::find(Auth::guard('customer')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'photo' => $file_name,
                    'updated_at' => Carbon::now(),
                ]);                
            }
            else{
                Customer::find(Auth::guard('customer')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'address' => $request->address,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        return back();
    }
}
