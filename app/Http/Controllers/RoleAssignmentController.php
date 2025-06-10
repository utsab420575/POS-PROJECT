<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleAssignmentController extends Controller
{
    public function index(){
        $allUsers = User::latest()->get();
        return view('backend.role_assign.all_users',compact('allUsers'));
    }



}
