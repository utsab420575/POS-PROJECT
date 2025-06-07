<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function Pos(){
        $product = Product::latest()->get();
        $customer = Customer::latest()->get();
        return view('backend.pos.pos_page',compact('product','customer'));
    } // End Method


    public function AddCart(Request $request){

        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => 20,
            'options' => ['size' => 'large']]);

         $notification = array(
             'message' => 'Product Added Successfully',
             'alert-type' => 'success'
         );

        return redirect()->back()->with($notification);

    } // End Method
}
