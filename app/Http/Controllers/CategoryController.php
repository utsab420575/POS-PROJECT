<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function AllCategory(){

        $category = Category::latest()->get();
        return view('backend.category.all_category',compact('category'));

    }// End Method

    public function StoreCategory(Request $request){

        Category::create([
            'category_name' => $request->category_name,
            'created_at' => Carbon::now(),
        ]);

         $notification = array(
             'message' => 'Category Inserted Successfully',
             'alert-type' => 'success'
         );

        return redirect()->route('all.category')->with($notification);
    }// End Method
}
