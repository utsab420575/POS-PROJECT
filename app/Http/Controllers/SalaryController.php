<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function AddAdvanceSalary(){
        $employee = Employee::latest()->get();
        return view('backend.salary.add_advance_salary',compact('employee'));
    }// End Method 
}
