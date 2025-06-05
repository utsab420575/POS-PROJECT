<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function EmployeeAttendanceList(){
        //find for same group of date(for many employee attendance date is same) show only one date
        $allData = Attendance::select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->get();
        return view('backend.attendance.view_employee_attend',compact('allData'));
    } // End Method


    public function AddEmployeeAttendance(){
        $employees = Employee::all();
        return view('backend.attendance.add_employee_attend',compact('employees'));
    }// End Method
}
