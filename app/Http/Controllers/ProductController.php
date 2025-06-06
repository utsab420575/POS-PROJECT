<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AllProduct(){
        $product = Product::latest()->get();
        return view('backend.product.all_product',compact('product'));
   } // End Method


    public function AddProduct(){
        $category = Category::latest()->get();
        $supplier = Supplier::latest()->get();
        return view('backend.product.add_product',compact('category','supplier'));
    }// End Method

    public function StoreProduct(Request $request){
        $validated = $request->validate([
            'product_name'   => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'product_code'   => 'required|string|max:100|unique:products,product_code',
            'buying_date'    => 'required|date',
            'expire_date'    => 'required|date|after_or_equal:buying_date',
            'buying_price'   => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'product_image'  => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        return $request;
    }



}
