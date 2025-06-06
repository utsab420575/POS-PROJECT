<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
            'product_image'  => 'required|image|mimes:jpg,jpeg,png,gif|max:5048',
        ]);

        //return $request;
        $recive_image = $request->file('product_image');
        $name_gen = hexdec(uniqid()).'.'.$recive_image->getClientOriginalExtension();

        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($recive_image);

        // resize image proportionally to 300px width
        //$image->scale(636,852);
        //resize image without proportionally
        $image->resize(300,300);
        $path = public_path('upload/product/');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $image->save($path . $name_gen);
        $save_url = 'upload/product/'.$name_gen;

        Product::create([

            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'product_code' => $request->product_code,
            'product_garage' => $request->product_garage,
            'product_store' => $request->product_store,
            'buying_date' => $request->buying_date,
            'expire_date' => $request->expire_date,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'product_image' => $save_url,
            'created_at' => Carbon::now(),

        ]);

         $notification = array(
             'message' => 'Product Inserted Successfully',
             'alert-type' => 'success'
         );

        return redirect()->route('all.product')->with($notification);
    }


    public function EditProduct($id){
        $product = Product::findOrFail($id);
        $category = Category::latest()->get();
        $supplier = Supplier::latest()->get();
        return view('backend.product.edit_product',compact('product','category','supplier'));
    } // End Method



    public function UpdateProduct(Request $request){
        $validated = $request->validate([
            'product_name'   => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'product_code'   => 'required|string|max:100|',
            'buying_date'    => 'required|date',
            'expire_date'    => 'required|date|after_or_equal:buying_date',
            'buying_price'   => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'product_image'  => 'image|mimes:jpg,jpeg,png,gif|max:5048',
        ]);


        $product_id = $request->id;

        if ($request->file('product_image')) {
            $recive_image = $request->file('product_image');
            $name_gen = hexdec(uniqid()).'.'.$recive_image->getClientOriginalExtension();

            // create image manager with desired driver
            $manager = new ImageManager(new Driver());

            // read image from file system
            $image = $manager->read($recive_image);

            // resize image proportionally to 300px width
            //$image->scale(636,852);
            //resize image without proportionally
            $image->resize(300,300);

            $path = public_path('upload/product/');
            $image->save($path . $name_gen);

            $save_url = 'upload/product/'.$name_gen;

            Product::findOrFail($product_id)->update([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'product_code' => $request->product_code,
                'product_garage' => $request->product_garage,
                'product_store' => $request->product_store,
                'buying_date' => $request->buying_date,
                'expire_date' => $request->expire_date,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                'product_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.product')->with($notification);

        } else{

            Product::findOrFail($product_id)->update([

                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'product_code' => $request->product_code,
                'product_garage' => $request->product_garage,
                'product_store' => $request->product_store,
                'buying_date' => $request->buying_date,
                'expire_date' => $request->expire_date,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.product')->with($notification);

        } // End else Condition


    } // End Method

    public function DeleteProduct($id){

        $product_img = Product::findOrFail($id);
        $img = $product_img->product_image;
        unlink($img);

        Product::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method



}
