<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function AllCustomer(){
        //latest employee show first
        $customer = Customer::latest()->get();
        return view('backend.customer.all_customer',compact('customer'));
    } // End Method
}
