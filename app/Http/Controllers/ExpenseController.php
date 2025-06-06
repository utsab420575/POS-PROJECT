<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpenseController extends Controller
{
    public function AddExpense(){
        return view('backend.expense.add_expense');
    } // End Method


    public function StoreExpense(Request $request){

        Expense::create([

            'details' => $request->details,
            'amount' => $request->amount,
            'month' => $request->month,
            'year' => $request->year,
            'date' => $request->date,
            'created_at' => Carbon::now(),
        ]);


            $notification = array(
                'message' => 'Expense Inserted Successfully',
                'alert-type' => 'success'
            );

        return redirect()->back()->with($notification);

    } // End Method

    public function TodayExpense(){

        //give current date
        $date = date("d-m-Y");
        $today = Expense::where('date',$date)->get();
        return view('backend.expense.today_expense',compact('today'));

    } // End Method


    public function EditExpense($id){

        $expense = Expense::findOrFail($id);
        return view('backend.expense.edit_expense',compact('expense'));

    }// End Method


    public function UpdateExpense(Request $request){

        $expense_id = $request->id;

        Expense::findOrFail($expense_id)->update([

            'details' => $request->details,
            'amount' => $request->amount,
            'month' => $request->month,
            'year' => $request->year,
            'date' => $request->date,
            'created_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Expense Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('today.expense')->with($notification);

    }// End Method
}
