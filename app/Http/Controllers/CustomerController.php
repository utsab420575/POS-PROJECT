<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CustomerController extends Controller
{
    public function AllCustomer(){
        //latest employee show first
        $customer = Customer::latest()->get();
        return view('backend.customer.all_customer',compact('customer'));
    } // End Method

    public function AddCustomer(){
         return view('backend.customer.add_customer');
    } // End Method


    public function StoreCustomer(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|unique:customers|max:200',
            'phone' => 'required|max:200',
            'address' => 'required|max:400',
            'shopname' => 'required|max:200',
            'account_holder' => 'required|max:200',
            'account_number' => 'required',
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
        $path = public_path('upload/customer/');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $image->save($path . $name_gen);
        $save_url = 'upload/customer/'.$name_gen;

        Customer::create([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'shopname' => $request->shopname,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'city' => $request->city,
            'image' => $save_url,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.customer')->with($notification);
    } // End Method


    public function EditCustomer($id){

        $customer = Customer::findOrFail($id);
        return view('backend.customer.edit_customer',compact('customer'));

    } // End Method


    public function UpdateCustomer(Request $request){

        $customer_id = $request->id;

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

            $path = public_path('upload/customer/');
            $image->save($path . $name_gen);

            $save_url = 'upload/customer/'.$name_gen;

            Customer::findOrFail($customer_id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'shopname' => $request->shopname,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'city' => $request->city,
                'image' => $save_url,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.customer')->with($notification);

        } else{

            Customer::findOrFail($customer_id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'shopname' => $request->shopname,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'bank_branch' => $request->bank_branch,
                'city' => $request->city,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.customer')->with($notification);

        } // End else Condition


    } // End Method


    public function DeleteCustomer($id){

        $customer_img = Customer::findOrFail($id);
        $img = $customer_img->image;
        unlink($img);

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method


}
