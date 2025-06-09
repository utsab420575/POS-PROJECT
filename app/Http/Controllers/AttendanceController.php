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

        return redirect()->route('employee.attendance.list')->with([
            'message' => 'Attendance saved successfully.',
            'alert-type' => 'success'
        ]);
    }


    public function EditEmployeeAttendence($date){
         $employees = Employee::all();
         //editData will be this
        /*Collection [
            Attendance { id: 1, employee_id: 100, date: '2025-06-05', status: 'present' },
            Attendance { id: 2, employee_id: 101, date: '2025-06-05', status: 'leave' },
            Attendance { id: 3, employee_id: 102, date: '2025-06-05', status: 'absent' },
        ]*/
         $editData = Attendance::where('date',$date)->get();
         //attendanceData will this; so here key is employee_id
        //$status = $attendanceData[$employee->id]->status ?? null; we can access Attendance data using employee_id
        /*Collection [
                100 => Attendance { id: 1, employee_id: 100, date: '2025-06-05', status: 'present' },
                101 => Attendance { id: 2, employee_id: 101, date: '2025-06-05', status: 'leave' },
                102 => Attendance { id: 3, employee_id: 102, date: '2025-06-05', status: 'absent' },
        ]*/
         $attendanceData = $editData->keyBy('employee_id');
         return view('backend.attendance.edit_employee_attend',compact('employees','attendanceData','date'));

    }// End Method

    public function UpdateEmployeeAttendenceStore(Request $request){
        // Validate input
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,leave,absent',
        ]);

        $date = date('Y-m-d', strtotime($request->date));

        /*[
          'attendance' => [
              100 => ['status' => 'present'],   // from $employee->id = 100
              101 => ['status' => 'leave'],     // from $employee->id = 101
              102 => ['status' => 'absent'],    // from $employee->id = 102
          ]
      ]*/
        foreach ($request->attendance as $employeeId => $data) {
            Attendance::updateOrCreate(
                ['employee_id' => $employeeId, 'date' => $date],
                ['status' => $data['status']]
            );
        }

        return redirect()->route('employee.attendance.list')->with([
            'message' => 'Attendance updated successfully.',
            'alert-type' => 'success'
        ]);
    }//End Method

    public function ViewEmployeeAttendence($date){
        $details = Attendance::where('date',$date)->get();
        return view('backend.attendance.details_employee_attend',compact('details'));
    }// End Method

}
