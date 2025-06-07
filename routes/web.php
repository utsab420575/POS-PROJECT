<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//for logout ;
Route::get('admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');


// Route to show logout success message/page
Route::get('/logout-success', [AdminController::class, 'AdminLogoutPage'])->name('logout.success');


Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('change.password');
    Route::post('/update/password', [AdminController::class, 'UpdatePassword'])->name('update.password');


    //all route should be use auth middleware
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/all/employee', 'AllEmployee')->name('all.employee');
        Route::get('/add/employee', 'AddEmployee')->name('add.employee');
        Route::post('/store/employee', 'StoreEmployee')->name('employee.store');
        Route::get('/edit/employee/{id}', 'EditEmployee')->name('edit.employee');
        Route::post('/update/employee', 'UpdateEmployee')->name('employee.update');
        Route::get('/delete/employee/{id}', 'DeleteEmployee')->name('delete.employee');
    });


    //all route should be use auth middleware
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/all/customer', 'AllCustomer')->name('all.customer');
        Route::get('/add/customer', 'AddCustomer')->name('add.customer');
        Route::post('/store/customer', 'StoreCustomer')->name('customer.store');
        Route::get('/edit/customer/{id}', 'EditCustomer')->name('edit.customer');
        Route::post('/update/customer', 'UpdateCustomer')->name('customer.update');
        Route::get('/delete/customer/{id}', 'DeleteCustomer')->name('delete.customer');
    });


    //Supplier All Route
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/all/supplier', 'AllSupplier')->name('all.supplier');
        Route::get('/add/supplier', 'AddSupplier')->name('add.supplier');
        Route::post('/store/supplier', 'StoreSupplier')->name('supplier.store');
        Route::get('/edit/supplier/{id}', 'EditSupplier')->name('edit.supplier');
        Route::post('/update/supplier', 'UpdateSupplier')->name('supplier.update');
        Route::get('/delete/supplier/{id}', 'DeleteSupplier')->name('delete.supplier');
        Route::get('/details/supplier/{id}', 'DetailsSupplier')->name('details.supplier');
    });


    //Advance Salary All Route
    Route::controller(SalaryController::class)->group(function () {
        Route::get('/add/advance/salary', 'AddAdvanceSalary')->name('add.advance.salary');
        Route::post('/advance/salary/store','AdvanceSalaryStore')->name('advance.salary.store');
        Route::get('/all/advance/salary','AllAdvanceSalary')->name('all.advance.salary');
        Route::get('/edit/advance/salary/{id}','EditAdvanceSalary')->name('edit.advance.salary');
        Route::post('/advance/salary/update','UpdateAdvanceSalary')->name('advance.salary.update');
        Route::get('/delete/advance/salary/{id}','DeleteAdvanceSalary')->name('delete.advance.salary');
    });

    /// Pay Salary All Route More actions
    Route::controller(SalaryController::class)->group(function(){
        Route::get('/pay/salary','PaySalary')->name('pay.salary');
        Route::get('/pay/now/salary/{id}','PayNowSalary')->name('pay.now.salary');
        Route::post('/employee/salary/store','EmployeeSalaryStore')->name('employee.salary.store');
    });


    Route::controller(AttendanceController::class)->group(function(){
        Route::get('/employee/attend/list','EmployeeAttendanceList')->name('employee.attend.list');
        Route::get('/add/employee/attend','AddEmployeeAttendance')->name('add.employee.attend');
        Route::post('/employee/attend/store','EmployeeAttendenceStore')->name('employee.attend.store');
        Route::get('/edit/employee/attend/{date}','EditEmployeeAttendence')->name('employee.attend.edit');
        Route::post('/employee/attendance/update', 'UpdateEmployeeAttendenceStore')->name('employee.attendance.update');
        Route::get('/view/employee/attend/{date}','ViewEmployeeAttendence')->name('employee.attend.view');

    });



    ///Category All Route
    Route::controller(CategoryController::class)->group(function(){

        Route::get('/all/category','AllCategory')->name('all.category');
        Route::post('/store/category','StoreCategory')->name('category.store');
        Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
        Route::post('/update/category','UpdateCategory')->name('category.update');
        Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');

    });



    //Product All Route
    Route::controller(ProductController::class)->group(function(){
        Route::get('/all/product','AllProduct')->name('all.product');
        Route::get('/add/product','AddProduct')->name('add.product');
        Route::post('/store/product','StoreProduct')->name('product.store');
        Route::get('/edit/product/{id}','EditProduct')->name('edit.product');
        Route::post('/update/product','UpdateProduct')->name('product.update');
        Route::get('/delete/product/{id}','DeleteProduct')->name('delete.product');
        Route::get('/barcode/product/{id}','BarcodeProduct')->name('barcode.product');
        Route::get('/import/product','ImportProduct')->name('import.product');
        Route::get('/export','Export')->name('export');
        Route::post('/import','Import')->name('import');
    });



    ///Expense All Route More actions
    Route::controller(ExpenseController::class)->group(function(){
        Route::get('/add/expense','AddExpense')->name('add.expense');
        Route::post('/store/expense','StoreExpense')->name('expense.store');
        Route::get('/today/expense','TodayExpense')->name('today.expense');

        Route::get('/edit/expense/{id}','EditExpense')->name('edit.expense');
        Route::post('/update/expense','UpdateExpense')->name('expense.update');

        Route::get('/month/expense','MonthExpense')->name('month.expense');
        Route::get('/year/expense','YearExpense')->name('year.expense');
    });



    //POS
    Route::controller(PosController::class)->group(function(){
        Route::get('/pos','Pos')->name('pos');
        Route::post('/add-cart','AddCart');
        Route::get('/allitem','AllItem');
        Route::post('/cart-update/{rowId}','CartUpdate');
        Route::get('/cart-remove/{rowId}','CartRemove');
    });


    // POS with own made cart (prefix: own)
    Route::prefix('own')->controller(PosController::class)->group(function () {
        Route::get('/pos', 'OwnPos')->name('own.pos');
        Route::post('/add-cart', 'OwnAddCart')->name('own.add.cart');
        Route::post('/cart-update/{productId}', 'OwnCartUpdate')->name('own.cart.update');
        Route::get('/cart-remove/{productId}', 'OwnCartRemove')->name('own.cart.remove');


        //this route for testing ; showing cart items
        Route::get('/allitem','OwnAllItem');
        //for destroy cart item
        Route::get('/cart-destroy', 'OwnDestroyCart')->name('own.cart.destroy');
    });


});
require __DIR__ . '/auth.php';
