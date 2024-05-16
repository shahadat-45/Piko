<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Billing;
use App\Models\OrderedProduct;
use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    function customer_orders(){
        $myorders = Orders::where('customer_id' , Auth::guard('customer')->id())->latest()->get();
        return view('themart.customer_order' , [
            'myorders' => $myorders,
        ]);
    }
    function download_invoice($id){
        $order_info = Orders::find($id);
        $bill_info = Billing::where('order_id' , $order_info->order_id)->first();
        $orderProduct = OrderedProduct::where('order_id' , $order_info->order_id)->get();
        $order_id = $order_info->order_id;
        $pdf = Pdf::loadView('customer.invoice-download', [
            'order_info' => $order_info,
            'bill_info' => $bill_info,
            'orderProduct' => $orderProduct,
            'order_id' => $order_id,
        ]);
     
        return $pdf->download('invoice.pdf');
    }
}
