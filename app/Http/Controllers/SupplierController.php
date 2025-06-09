<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SupplierController extends Controller
{
    public function AllSupplier(){
        $supplier = Supplier::latest()->get();
        return view('backend.supplier.all_supplier',compact('supplier'));
    } // End Method

    public function AddSupplier(){
         return view('backend.supplier.add_supplier');
    } // End Method



    public function StoreSupplier(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|unique:customers|max:200',
            'phone' => 'required|max:200',
            'address' => 'required|max:400',
            'shopname' => 'required|max:200',
            'account_holder' => 'required|max:200',
            'account_number' => 'required',
            'type' => 'required',
            'image' => 'required',
        ]);

        $recive_image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$recive_image->getClientOriginalExtension();

        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($recive_image);

        // resize image proportionally to 300px width
        //$image->scale(636,852);
        //resize image without proportionally
        $image->resize(300,300);
        $path = public_path('upload/employee/');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $image->save($path . $name_gen);
        $save_url = 'upload/employee/'.$name_gen;

        Supplier::create([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'city' => $request->city,
            'image' => $save_url,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    } // End Method


    public function EditSupplier($id){

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.edit_supplier',compact('supplier'));

    } // End Method


    public function UpdateSupplier(Request $request){

        $supplier_id = $request->id;

        if ($request->file('image')) {

            $recive_image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$recive_image->getClientOriginalExtension();

            // create image manager with desired driver
            $manager = new ImageManager(new Driver());

            // read image from file system
            $image = $manager->read($recive_image);

            // resize image proportionally to 300px width
            //$image->scale(636,852);
            //resize image without proportionally
            $image->resize(300,300);

            $path = public_path('upload/employee/');
            $image->save($path . $name_gen);

            $save_url = 'upload/employee/'.$name_gen;


            Supplier::findOrFail($supplier_id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'shopname' => $request->shopname,
                'type' => $request->type,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'city' => $request->city,
                'image' => $save_url,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Supplier Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('supplier.all')->with($notification);

        } else{

            Supplier::findOrFail($supplier_id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'shopname' => $request->shopname,
                'type' => $request->type,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'city' => $request->city,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Supplier Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('supplier.all')->with($notification);

        } // End else Condition


    } // End Method



    public function DeleteSupplier($id){

        $supplier_img = Supplier::findOrFail($id);
        $img = $supplier_img->image;
        unlink($img);

        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method

    public function DetailsSupplier($id){

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.details_supplier',compact('supplier'));

    } // End Method



}
