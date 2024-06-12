<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqStore;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    function faq_list(){
        $faqs = Faq::all();
        $faqs_store = FaqStore::all();
        return view('the_mart_control.faqs',[
            'faqs' => $faqs,
            'faqs_store' => $faqs_store,
        ]);
    }
    function faq_add(Request $request){
        $request->validate([
            'question' => 'required' ,
            'answer' => 'required' ,
        ]);
        Faq::insert([
            'question' => $request->question,
            'answer' => $request->answer,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success' , 'FAQs Added Successfully');
    }
    function faq_delete($id){
        Faq::find($id)->delete();
        return back()->with('deleted' , 'FAQs Deleted Successfully');
    }
    function faq_store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'question' => 'required',
        ]);
        FaqStore::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'question' => $request->question,
            'created_at' => Carbon::now(),
            ]);
        return redirect('/faq#faq')->with('submited', 'Thank you');
    }
    function faq_store_delete($id){
        FaqStore::find($id)->delete();
        return back()->with('faq_deleted' , 'FAQs Deleted Successfully');
    }
}
