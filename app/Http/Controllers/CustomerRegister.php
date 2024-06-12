<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerEmailVerify;
use App\Models\PassReset;
use App\Notifications\customerEmailVerify as NotificationsCustomerEmailVerify;
use App\Notifications\passResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Notification;

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
            'password_confirmation' => 'required',
        ]);
        $customer_info = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        $info = CustomerEmailVerify::create([
            'token' => uniqid(),
            'customer_id' => $customer_info->id,
        ]);
        Notification::send($customer_info, new NotificationsCustomerEmailVerify($info));
        return back()->with('register_success' , 'Registered successfully, Please verify your email');
    }

    function user_login(){
        return view('themart.customer_login');
    }
    
    function user_login_post(Request $request){
        if (Customer::where('email', $request->email)->exists()) {
           if (Auth::guard('customer')->attempt(['email'=>$request->email , 'password'=>$request->password])) {
            if (Auth::guard('customer')->user()->email_verified_at == null) {
                Auth::guard('customer')->logout();
                return back()->with('not_verified' , 'Please Verify Your Email!');
            }
            else{
                return redirect('/');
            }
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

    function pass_reset_req(){
        return view('customer.pass_reset_req');
    }

    function pass_reset_req_send(Request $request){
        $customer = Customer::where('email' , $request->email)->first();
        if (Customer::where('email' , $request->email)->exists()) {
            PassReset::where('customer_id', $customer->id)->delete();
            $pass_info = PassReset::create([
                'token' => uniqid(),
                'customer_id' => $customer->id,
                'created_at' => Carbon::now(),
            ]);
            Notification::send($customer, new passResetNotification($pass_info));
            return back()->with('success', 'Password Reset Request Send To Your Email');
        }
        else{
            return back()->with('invalid', 'Invalid Email Address');
        }
    }

    function pass_reset_form($token){
        if (PassReset::where('token' , $token)->exists()) {
            return view('customer.pass_reset_form',[
                'token' => $token,
            ]);            
        }
        else {
            abort('404');
        }
    }

    function pass_reset_update(Request $request , $token){
        $info = PassReset::where('token' , $token)->first();
        if (PassReset::where('token' , $token)->exists()) {

            $request->validate([
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);

           Customer::find($info->customer_id)->update([
            'password' => bcrypt($request->password),
           ]);

           PassReset::where('token' , $token)->delete();


           return redirect(route('user.login'))->with('pass_updated' , 'Your Password Updated Successfully');
        }
        else {
            abort('404');
        }
    }

    function customer_email_verify($token){
        if(CustomerEmailVerify::where('token' , $token)->exists()){
            $customer = CustomerEmailVerify::where('token' , $token)->first();
        
            Customer::find($customer->customer_id)->update([
                'email_verified_at' => Carbon::now(),
            ]);

            CustomerEmailVerify::where('token' , $token)->delete();
            return redirect(route('user.login'))->with('verified', 'Email verified successfully');
        }
        else{
            abort('404');
        }
        
    }

    function email_verify_req(){
        return view('customer.email_verify_req');
    }
    function email_verify_req_send(Request $request){
        if (Customer::where('email' , $request->email)->exists()) {
            $customer = Customer::where('email' , $request->email)->first();
            CustomerEmailVerify::where('customer_id' , $customer->id)->delete();
            $info = CustomerEmailVerify::create([
                'token' => uniqid(),
                'customer_id' => $customer->id,
            ]);
            Notification::send($customer, new NotificationsCustomerEmailVerify($info));
            return back()->with('req_sent' , 'Verification Mail Sended! Please Verify Your Email');
        }
        else{
            return back()->with('invalid_email' , "Your Email doesn't Exist");
        }        
    }
}
