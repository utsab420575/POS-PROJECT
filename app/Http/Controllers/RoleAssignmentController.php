<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;

class RoleAssignmentController extends Controller
{
    public function AllRoleAssignments(){
        $allUsers = User::latest()->get();
        return view('backend.role_assign.all_users',compact('allUsers'));
    }

    public function AddRoleAssignments(){
        $roles = Role::all();
        return view('backend.role_assign.add_user',compact('roles'));
    }

    public function StoreRoleAssignments(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'roles'    => 'required|exists:roles,id',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $save_url =null;
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

            $path = public_path('upload/user_image/');
            $image->save($path . $name_gen);

            $save_url = 'upload/user_image/'.$name_gen;
        }
        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'photo'    => $save_url,
        ]);

        // Assign role using Spatie

        if ($request->roles) {
            $role = Role::findById($request->roles);
            $user->assignRole($role);
        }

        $notification = array(
            'message' => 'New User Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.assignments.all')->with($notification);

    }// End Method



}
