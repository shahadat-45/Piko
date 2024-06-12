<?php

// app/Http/Controllers/SocialLoginController.php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SocialLoginController extends Controller
{
    //Github
    public function github_redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function github_callback()
    {
        $user = Socialite::driver('github')->user();

        $customer = Customer::updateOrCreate(
            ['email' => $user->getEmail()],
            [
                'name' => $user->getName(),
                'password' => bcrypt('pass@123'), // Use a secure method for password handling
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]
        );

        if (Auth::guard('customer')->attempt(['email' => $user->getEmail(), 'password' => 'pass@123'])) {
            return redirect('/');
        }

        return redirect('/user/login'); // Redirect if authentication fails
    }
    //Google
    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        $user = Socialite::driver('google')->user();

        $customer = Customer::updateOrCreate(
            ['email' => $user->getEmail()],
            [
                'name' => $user->getName(),
                'password' => bcrypt('pass@123'), // Use a secure method for password handling
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]
        );

        if (Auth::guard('customer')->attempt(['email' => $user->getEmail(), 'password' => 'pass@123'])) {
            return redirect('/');
        }

        return redirect('/user/login'); // Redirect if authentication fails
    }
}
