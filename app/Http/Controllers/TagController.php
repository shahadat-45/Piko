<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
   function tags(){
    $all_tags = Tags::paginate(10);
    return view('brand&tags.tags', [
        'tags' => $all_tags,
    ]);
   }
   function tags_insert(Request $request){
    $request->validate([
        'tags'=> 'required',
    ]);
    Tags::insert([
        'tag_name' => $request->tags,
        'tag_slug' => Str::lower(str_replace(' ', '-', $request->tags)) . '.' . random_int(1000, 9999),
        'created_at' => Carbon::now(),
    ]);
    return back()->with('success', 'Tag name added successfully');
   }
   function tags_delete($id){
    Tags::find($id)->delete();
    return back()->with('delete_success', 'Tag name deleted successfully');
   }
}
