<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
   function sub_category(){
    $category = Category::all();
    $subcategory = SubCategory::all();
    return view('category.sub-category',[
        'category' => $category,
        'subcategory' => $subcategory,
    ]);
   }
   function sub_category_insert(Request $request){
    $request->validate([
        'category_name'=>'required',
        'sub_category_name'=> 'required',
    ],[
        'category_name.required'=>'Category field is required !',
        'sub_category_name.required'=>'Sub-Category field is required !',
    ]);
    SubCategory::insert([
        'category_id'=> $request->category_name,
        'sub_category_name'=> $request->sub_category_name,
        'created_at'=> Carbon::now(),
    ]);
    return back();
   }
   function sub_category_delete($id){
    SubCategory::find($id)->delete();
    return back()->with('delete_success', 'Category item delete successfully');
   }
   function sub_category_update(Request $request,$id){
    
    SubCategory::find($id)->update([
        'sub_category_name'=> $request->sub_category_name,
        'updated_at' => Carbon::now(),
    ]);
    return back();
   }
}
