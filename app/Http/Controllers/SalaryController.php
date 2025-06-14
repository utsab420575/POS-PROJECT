<?php

namespace App\Http\Controllers;

use App\Models\AdvanceSalary;
use App\Models\Employee;
use App\Models\PaySalary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SalaryController extends Controller
{
    //form show
    public function AddAdvanceSalary(){
        $employee = Employee::latest()->get();
        return view('backend.salary.add_advance_salary',compact('employee'));
    }// End Method

    //form data store
    public function AdvanceSalaryStore(Request $request){

        $validateData = $request->validate([
            'month' => 'required',
            'year' => 'required',
            'advance_salary' => 'required|max:255',
        ]);

        $month = $request->month;
        $employee_id = $request->employee_id;

        $advanced = AdvanceSalary::where('month',$month)->where('employee_id',$employee_id)->first();

        //we give advance salary for once;if advance salary exist for same month than we not give advance salary for that employee
        if ($advanced === NULL) {
            AdvanceSalary::create([
                'employee_id' => $request->employee_id,
                'month' => $request->month,
                'year' => $request->year,
                'advance_salary' => $request->advance_salary,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Advance Salary Paid Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('employee.salary.advance.all')->with($notification);


        } else{

            $notification = array(
                'message' => 'Advance Already Paid',
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);

        }

    }// End Method

    //ALl Advance Salary Show in blade
    public function AllAdvanceSalary(){

        $salary = AdvanceSalary::latest()->get();

        return view('backend.salary.all_advance_salary',compact('salary'));

    }// End Method

    //edit form show
    public function EditAdvanceSalary($id){
        //$employee = Employee::latest()->get();
        $salary = AdvanceSalary::findOrFail($id);
        $employee=$salary->employee;
        return view('backend.salary.edit_advance_salary',compact('salary','employee'));

    }// End Method


    public function UpdateAdvanceSalary(Request $request){



        //return $request;
        $salary_id = $request->id;

        AdvanceSalary::findOrFail($salary_id)->update([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'year' => $request->year,
            'advance_salary' => $request->advance_salary,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Advance Salary Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.salary.advance.all')->with($notification);


    }// End Method

    public function DeleteAdvanceSalary($id){
        AdvanceSalary::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Advance Salary Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



    //////////////////////// Pay Salary All Mehtod /////////////////


    //send month and salary also
    public function PaySalary(Request $request){
        $month = $request->month;
        $year = $request->year;

        $employee = [];

        if ($month && $year) {
           $employee=Employee::latest()->get();
        }

        return view('backend.salary.pay_salary', compact('employee', 'month', 'year'));
    }// End Method

    public function PayNowSalary($id,Request $request){
        $month=$request->month;
        $year=$request->year;
        $single_employee = Employee::findOrFail($id);
        return view('backend.salary.paid_salary',compact('single_employee','month','year'));
    }// End Method

    public function EmployeeSalaryStore(Request $request)
    {
        $employee_id = $request->id;

        // Check if already paid for the given employee, month, and year
        $already_paid = PaySalary::where('employee_id', $employee_id)
            ->where('salary_month', $request->month)
            ->where('salary_year', $request->year)
            ->exists(); // ✅ Use `exists()` for boolean check

        if ($already_paid) {
            $notification= [
                'message' => 'Already Paid Before',
                'alert-type' => 'error'
            ];

            return redirect()->route('pay.salary', [
                'month' => $request->month,
                'year' => $request->year,
            ])->with($notification);
        }

        // Store the new salary payment
        PaySalary::create([
            'employee_id' => $employee_id,
            'salary_month' => $request->month,
            'salary_year' => $request->year,
            'paid_amount' => $request->salary,
            'advance_salary' => $request->advance_salary,
            'due_salary' => $request->due_salary,
            'created_at' => now(),
        ]);


        $notification = [
            'message' => 'Employee Salary Paid Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('employee.salary.pay', [
            'month' => $request->month,
            'year' => $request->year,
        ])->with($notification);
    }




}
