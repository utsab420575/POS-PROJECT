<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AllProduct(){
        $product = Product::latest()->get();
        return view('backend.product.all_product',compact('product'));
   } // End Method

}
