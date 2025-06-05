<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function EmployeeAttendanceList()
    {
        //find for same group of date(for many employee attendance date is same) show only one date
        $allData = Attendance::select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->get();
        return view('backend.attendance.view_employee_attend', compact('allData'));
    } // End Method


    public function AddEmployeeAttendance()
    {
        $employees = Employee::all();
        return view('backend.attendance.add_employee_attend', compact('employees'));
    }// End Method

    public function EmployeeAttendenceStore(Request $request)
    {
        // Validate input
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,leave,absent',
        ]);

        $date = date('Y-m-d', strtotime($request->date));

        $alreadyExists = Attendance::where('date', $date)->exists();
        if ($alreadyExists) {
            return back()->with([
                'message' => 'Attendance for this date already exists.',
                'alert-type' => 'error'
            ]);
        }

            /*[
              'attendance' => [
                  100 => ['status' => 'present'],   // from $employee->id = 100
                  101 => ['status' => 'leave'],     // from $employee->id = 101
                  102 => ['status' => 'absent'],    // from $employee->id = 102
              ]
          ]*/
        foreach ($request->attendance as $employeeId => $data) {
            Attendance::create([
                'employee_id' => $employeeId,
                'date' => $date,
                'status' => $data['status']
            ]);
        }

        return redirect()->route('employee.attend.list')->with([
            'message' => 'Attendance saved successfully.',
            'alert-type' => 'success'
        ]);
    }


}
