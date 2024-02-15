<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function edit_user () {
        return view('profile.edit');
    }
    function update_user (Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        User::find(Auth::id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return back()->with('success', 'User information update successfully');
    }
    function change_password (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required',
        ]);
        if (password_verify($request->current_password, Auth::user()->password)) {
            User::find(Auth::user()->id)->update([
                'password' => bcrypt($request->password),
            ]);
            
            return back()->with('successfull', 'Your password is changed successfully');
        }
        else{
            return back()->with('wrong_pass', 'Current password is wrong');            
        }
    }
    function change_profile_pic (Request $request) {
        $request->validate([
            'profile_photo' => 'required | mimes:jpg,jpeg,png,webp | max:1024',
        ]);
        if (Auth::user()->photo != null) {
            $delete = public_path('uploads/user/' . Auth::user()->photo);
            unlink($delete);
        }
        $photo = $request->profile_photo;
        $extension = $photo->extension();
        $file_name = Auth::id(). '.' . $extension;
        Image::make($photo)->resize(400, 400)->save(public_path('uploads/user/'.$file_name));
        User::find(Auth::id())->update([
            'photo' => $file_name,
        ]);
        return back()->with('photo_updated', 'Profile photo uploaded');
    }
    function user_list() {
        $users = User::all();
        return view('backend.user.user_list', [
            'users' => $users,
        ]);

    }
    function user_delete($id){
        User::find($id)->delete();
        return back()->with('delete_success', 'User deleted successfully');
    }
}
