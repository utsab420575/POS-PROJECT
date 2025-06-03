<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //method for showing all employee
    public function AllEmployee(){
        //latest employee show first
        $employee = Employee::latest()->get();
        return view('backend.employee.all_employee',compact('employee'));
    } // End Method

}
