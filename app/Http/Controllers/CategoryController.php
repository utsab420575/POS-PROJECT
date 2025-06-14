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

        return redirect()->route('category.all')->with($notification);
    }// End Method

    public function EditCategory($id){
        $category = Category::findOrFail($id);
        return view('backend.category.edit_category',compact('category'));

    }// End Method


    public function UpdateCategory(Request $request){

        $category_id = $request->id;

        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);

    }// End Method


    public function DeleteCategory($id){

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }// End Method
}
