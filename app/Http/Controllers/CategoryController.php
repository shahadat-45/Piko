<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    function category(){
        $categories = Category::all();
        return view('category.category', compact('categories'));
    }
    function category_insert(Request $request) {
        $request->validate([
            "name"=>'required',
            'image' => 'required | mimes:jpg,jpeg,png,webp | max:1024',
        ]);

        $photo = $request->image;
        $ext = $photo->extension();
        $category_image = Str::lower(str_replace(' ', '-', $request->name)) . '_' . now()->format('d-m-Y') . '.' . $ext;
        Image::make($photo)->resize(400, 400)->save(public_path('uploads/category/' . $category_image));

        Category::insert([
            "name" => $request->name,
            "slug" => Str::lower(str_replace(' ', '-', $request->name)),
            "image" => $category_image,
            "created_at" => Carbon::now(),

        ]);
        return back()->with('success', 'Category added successfully');
    }
    function category_delete($id){
        
        Category::find($id)->delete();
        return back()->with('delete_success', 'Category item delete successfully');
        
    }
    function category_update(Request $request, $id){
        $request->validate([
            'image' => 'required | mimes:jpg,jpeg,png,webp | max:2048',
        ]);
        $photo = $request->image;

        if($request->image == null){

            Category::find($id)->update([
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                // "image" => $category_image,
                "updated_at" => Carbon::now(),
            ]);
        }
        else{
            $delete = public_path('uploads/category/') . Category::find($id)->image;
            unlink($delete);

            $ext = $photo->extension();
            $category_image = $request->name . '_' . now()->format('d-m-Y') . '.' . $ext;
            Image::make($photo)->resize(400, 400)->save(public_path('uploads/category/' . $category_image));
            
            Category::find($id)->update([
            "name" => $request->name,
            "slug" => $request->slug,
            "description" => $request->description,
            "image" => $category_image,
            "updated_at" => Carbon::now(),
        ]);
    }
        return back()->with('update-success', 'Category Update Successfully');
    }

    function category_checked_delete(Request $request){
        $categories = $request->foo;
        foreach ($categories as $key => $category) {
            Category::find($category)->delete();
        }
        return back()->with('delete_success', 'Category item delete successfully');
    }

    function trashed_categories(){
        $categories = Category::onlyTrashed()->get();
        return view('backend.trash_category', compact('categories'));
    }

    function trash_deleted($id){
        $delete = public_path('uploads/category/') . Category::onlyTrashed()->find($id)->image;
        unlink($delete);
        Category::onlyTrashed()->find($id)->forceDelete();
        return back()->with('trash_deleted_permanently', 'Category Deleted Permanently');
    }
    function trash_category_checked_delete(Request $request){
        $trash_categories = $request->foo;
        foreach ($trash_categories as $category) {
            $delete = public_path('uploads/category/') . Category::onlyTrashed()->find($category)->image;
            unlink($delete);
            Category::onlyTrashed()->find($category)->forceDelete();
        }
        // echo '<pre>';
        // print_r($trash_categories);
        // echo '</pre>';
        return back()->with('trash_deleted_permanently', 'Categories Deleted Permanently');
    }
     function trash_restore($id){
        Category::onlyTrashed()->find($id)->restore();
        return back()->with('trash_restored', 'Category Restored Successfully');
     }
}
