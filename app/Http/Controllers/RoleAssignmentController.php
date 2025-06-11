<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $save_url =null;
        Log::info('Before image processing', ['hasFile' => $request->hasFile('photo')]);
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
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $image->save($path . $name_gen);


            $save_url = 'upload/user_image/'.$name_gen;
            Log::info('Image processed', ['save_url' => $save_url]);
        }
        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'photo'    => $save_url,
        ]);

        Log::info('User created', ['user_id' => $user->id, 'photo' => $user->photo]);
        // Assign role using Spatie

        if ($request->roles) {
            /*$role = Role::findById($request->roles);
            $user->assignRole($role);*/
            $roles = Role::whereIn('id', $request->roles)->get();
            $user->syncRoles($roles); // Pass Role instances instead of IDs
        }

        $notification = array(
            'message' => 'User Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.assignments.all')->with($notification);

    }// End Method



    public function EditRoleAssignments($id){

        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('backend.role_assign.edit_user',compact('roles','user'));

    }// End Method


    public function UpdateRoleAssignments(Request $request)
    {
        //return $request;
        try {
            // Validate request data
            $validated = $request->validate([
                'id'    => 'required|exists:users,id',
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'phone' => 'nullable|string|max:20',
                'roles' => 'required|array',
                'roles.*' => 'exists:roles,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            ]);

            // Find user
            $user = User::findOrFail($request->id);
            $save_url = $user->photo;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->photo) {
                    $imgPath = public_path($user->photo);
                    if (file_exists($imgPath) && is_file($imgPath)) {
                        unlink($imgPath);
                    }
                }

                // Process new image
                $image = $request->file('image');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();


                $path = 'upload/user_image/';

                // Create directory if not exists
                if (!file_exists(public_path($path))) {
                    mkdir(public_path($path), 0755, true);
                }

                // Resize and save image
                $manager = new ImageManager(new Driver());
                $image = $manager->read($image);
                $image->resize(300, 300);
                $image->save(public_path($path . $name_gen));

                $save_url = $path . $name_gen;
            }

            // Update user details
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'photo' => $save_url,
            ]);

            /*// Sync roles (using sync instead of detach+assign for better handling)
            $user->syncRoles($request->roles);*/
            if ($request->roles) {
                /*$role = Role::findById($request->roles);
                $user->syncRoles([$role]);*/
                $roles = Role::whereIn('id', $request->roles)->get();
                $user->syncRoles($roles); // Pass Role instances instead of IDs
            }

            $notification = [
                'message' => 'User Updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('role.assignments.all')->with($notification);

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage(), [
                'user_id' => $request->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            $notification = [
                'message' => 'Error Updating User: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect()->back()->withInput()->with($notification);
        }
    }



    public function DeleteRoleAssignments($id){

        try {
            $user = User::findOrFail($id);

            // Delete user image if exists
            if ($user->photo) {
                $imgPath = public_path($user->photo);

                // Check if file exists and is actually a file (not a directory)
                if (file_exists($imgPath) && is_file($imgPath)) {
                    unlink($imgPath);
                }
            }

            // Remove all roles (Spatie)
            $user->roles()->detach();

            // Delete the user
            $user->delete();

            $notification = [
                'message' => 'User Deleted Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('role.assignments.all')->with($notification);

        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error Deleting User: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }

    }// End Method

}
