<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //showing all permission
    public function AllPermission(){

        $permissions = Permission::all();
        return view('backend.pages.permission.all_permission',compact('permissions'));

    } // End Method
}
