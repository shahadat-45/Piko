<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Inventory;
use App\Models\Products;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function variation(){
        $colors = Color::all();
        $size = Size::all();
        return view('products.variation',[
            'colors' => $colors,
            'size' => $size,
        ]);
    }
    function add_color(Request $request){
        Color::insert([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }
    function add_size(Request $request){
        Size::insert([
            'size' => $request->size_label,
            'created_at' => Carbon::now(),
        ]);
        // return back();
        return redirect('/variation#size_table');
    }
    function inventory($id){
        $inventory = Inventory::where('product_id', $id)->get();
        $product_id = $id;
        $colors = Color::all();
        $size = Size::all();
        return view('products.inventory', [
            "colors" => $colors,
            "size" => $size,
            "product_id" => $product_id,
            "inventory" => $inventory,
        ]);
    }
    function inventory_add(Request $request){
        $discount = Products::find($request->product_id)->discount;
        if(Inventory::where('color_id', $request->color)->where('size_id', $request->size)->where('product_id', $request->product_id)->exists()){
            Inventory::where('color_id', $request->color)->where('size_id', $request->size)->where('product_id', $request->product_id)->increment('quantity', $request->quantity);
        }
        else{
            $request->validate([
                'color' => 'required',
                'size' => 'required',
                'new_price' => 'required',
                'quantity' => 'required',
            ],
            [
                'color.required' => 'Color is required',
                'size.required' => 'Size is required',
                'new_price.required' => 'Price is required',
                'quantity.required' => 'Quantity is required',
            ],
        );
            Inventory::insert([
                'product_id' => $request->product_id,
                'color_id' => $request->color,
                'size_id' => $request->size,
                'new_price' => $request->new_price,
                'after_discount' => round($request->new_price - ($request->new_price / 100 * $discount)),
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
        }
        return back();
    }
    function inventory_delete($id){
        Inventory::find($id)->delete();
        return back()->with('delete_inventory', 'Inventory deleted successfully');
    }
}
