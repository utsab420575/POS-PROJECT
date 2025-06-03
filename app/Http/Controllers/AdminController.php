<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function AdminDestroy(Request $request): RedirectResponse
    {
        //delete session data
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();



         $notification = array(
             'message' => 'Admin Logout Successfully',
             'alert-type' => 'info'
         );
        //redirect to login page after logout
        return redirect('/logout-success')->with($notification);
    }

    public function AdminLogoutPage(){
        return view('admin.admin_logout');
    }

    public function AdminProfile(){

        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    }

    public function AdminProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_image/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_image'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();


        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }// End Method

    public function ChangePassword(){
        return view('admin.change_password');
    }// End Method
}
