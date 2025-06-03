<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EmployeeController extends Controller
{
    //method for showing all employee
    public function AllEmployee(){
        //latest employee show first
        $employee = Employee::latest()->get();
        return view('backend.employee.all_employee',compact('employee'));
    } // End Method


    public function AddEmployee(){
        return view('backend.employee.add_employee');
    } // End Method

    public function StoreEmployee(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|unique:employees|max:200',
            'phone' => 'required|max:200',
            'address' => 'required|max:400',
            'salary' => 'required|max:200',
            'vacation' => 'required|max:200',
            'experience' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'This Employee Name Field Is Required',
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

        Employee::create([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'vacation' => $request->vacation,
            'city' => $request->city,
            'image' => $save_url,
            'created_at' => Carbon::now(),

        ]);

         $notification = array(
             'message' => 'Employee Inserted Successfully',
             'alert-type' => 'success'
         );

        return redirect()->route('all.employee')->with($notification);
    } // End Method


    public function EditEmployee($id){

        $employee = Employee::findOrFail($id);
        return view('backend.employee.edit_employee',compact('employee'));

    } // End Method

    public function UpdateEmployee(Request $request){

        $employee_id = $request->id;

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

            Employee::findOrFail($employee_id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'experience' => $request->experience,
                'salary' => $request->salary,
                'vacation' => $request->vacation,
                'city' => $request->city,
                'image' => $save_url,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Employee Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.employee')->with($notification);

        } else{

            Employee::findOrFail($employee_id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'experience' => $request->experience,
                'salary' => $request->salary,
                'vacation' => $request->vacation,
                'city' => $request->city,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Employee Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.employee')->with($notification);

        } // End else Condition


    } // End Method
}
