<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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



}
