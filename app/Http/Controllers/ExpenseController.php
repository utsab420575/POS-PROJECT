<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function AddExpense(){
        return view('backend.expense.add_expense');
    } // End Method
}
