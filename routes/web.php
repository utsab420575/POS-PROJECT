<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleAssignmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index')->middleware('permission:employee.all');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('profile.destroy');
});

// Admin Routes
Route::get('admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
Route::get('/logout-success', [AdminController::class, 'AdminLogoutPage'])->name('logout.success');

Route::middleware('auth')->group(function () {

    // Admin profile and password
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('admin.password.change');
    Route::post('/update/password', [AdminController::class, 'UpdatePassword'])->name('admin.password.update');

    // Employee
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee/all', 'AllEmployee')->name('employee.all')->middleware('permission:employee.all');
        Route::get('/employee/add', 'AddEmployee')->name('employee.add')->middleware('permission:employee.add');
        Route::post('/employee/store', 'StoreEmployee')->name('employee.store')->middleware('permission:permission:employee.store');
        Route::get('/employee/edit/{id}', 'EditEmployee')->name('employee.edit')->middleware('permission:permission:employee.edit');
        Route::post('/employee/update', 'UpdateEmployee')->name('employee.update')->middleware('permission:employee.update');
        Route::get('/employee/delete/{id}', 'DeleteEmployee')->name('employee.delete')->middleware('permission:employee.delete');
    });

    // Customer
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/all', 'AllCustomer')->name('customer.all')->middleware('permission:customer.all');
        Route::get('/customer/add', 'AddCustomer')->name('customer.add')->middleware('permission:customer.add');
        Route::post('/customer/store', 'StoreCustomer')->name('customer.store')->middleware('permission:customer.store');
        Route::get('/customer/edit/{id}', 'EditCustomer')->name('customer.edit')->middleware('permission:customer.edit');
        Route::post('/customer/update', 'UpdateCustomer')->name('customer.update')->middleware('permission:customer.update');
        Route::get('/customer/delete/{id}', 'DeleteCustomer')->name('customer.delete')->middleware('permission:customer.delete');
    });

    // Supplier
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier/all', 'AllSupplier')->name('supplier.all')->middleware('permission:supplier.all');
        Route::get('/supplier/add', 'AddSupplier')->name('supplier.add')->middleware('permission:supplier.add');
        Route::post('/supplier/store', 'StoreSupplier')->name('supplier.store')->middleware('permission:supplier.store');
        Route::get('/supplier/edit/{id}', 'EditSupplier')->name('supplier.edit')->middleware('permission:supplier.edit');
        Route::post('/supplier/update', 'UpdateSupplier')->name('supplier.update')->middleware('permission:supplier.update');
        Route::get('/supplier/delete/{id}', 'DeleteSupplier')->name('supplier.delete')->middleware('permission:supplier.delete');
        Route::get('/supplier/details/{id}', 'DetailsSupplier')->name('supplier.details')->middleware('permission:supplier.details');
    });

    // Salary
    // Employee Salary
    Route::controller(SalaryController::class)->group(function () {

        // Advance Salary
        Route::get('/employee/salary/advance/add', 'AddAdvanceSalary')->name('employee.salary.advance.add')->middleware('permission:employee.salary.advance.add');
        Route::post('/employee/salary/advance/store', 'AdvanceSalaryStore')->name('employee.salary.advance.store')->middleware('permission:employee.salary.advance.store');
        Route::get('/employee/salary/advance/all', 'AllAdvanceSalary')->name('employee.salary.advance.all')->middleware('permission:employee.salary.advance.all');
        Route::get('/employee/salary/advance/edit/{id}', 'EditAdvanceSalary')->name('employee.salary.advance.edit')->middleware('permission:employee.salary.advance.edit');
        Route::post('/employee/salary/advance/update', 'UpdateAdvanceSalary')->name('employee.salary.advance.update')->middleware('permission:employee.salary.advance.update');
        Route::get('/employee/salary/advance/delete/{id}', 'DeleteAdvanceSalary')->name('employee.salary.advance.delete')->middleware('permission:employee.salary.advance.delete');

        // Pay Salary
        Route::get('/employee/salary/pay', 'PaySalary')->name('employee.salary.pay')->middleware('permission:employee.salary.pay');
        Route::get('/employee/salary/pay/now/{id}', 'PayNowSalary')->name('employee.salary.pay.now')->middleware('permission:employee.salary.pay.now');
        Route::post('/employee/salary/pay/store', 'EmployeeSalaryStore')->name('employee.salary.pay.store')->middleware('permission:employee.salary.pay.store');
    });

    // Employee Attendance
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/employee/attendance/list', 'EmployeeAttendanceList')->name('employee.attendance.list')->middleware('permission:employee.attendance.list');
        Route::get('/employee/attendance/add', 'AddEmployeeAttendance')->name('employee.attendance.add')->middleware('permission:employee.attendance.add');
        Route::post('/employee/attendance/store', 'EmployeeAttendenceStore')->name('employee.attendance.store')->middleware('permission:employee.attendance.store');
        Route::get('/employee/attendance/edit/{date}', 'EditEmployeeAttendence')->name('employee.attendance.edit')->middleware('permission:employee.attendance.edit');
        Route::post('/employee/attendance/update', 'UpdateEmployeeAttendenceStore')->name('employee.attendance.update')->middleware('permission:employee.attendance.update');
        Route::get('/employee/attendance/view/{date}', 'ViewEmployeeAttendence')->name('employee.attendance.view')->middleware('permission:employee.attendance.view');
    });

    // Category
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'AllCategory')->name('category.all')->middleware('permission:category.all');
        Route::post('/category/store', 'StoreCategory')->name('category.store')->middleware('permission:category.store');
        Route::get('/category/edit/{id}', 'EditCategory')->name('category.edit')->middleware('permission:category.edit');
        Route::post('/category/update', 'UpdateCategory')->name('category.update')->middleware('permission:category.update');
        Route::get('/category/delete/{id}', 'DeleteCategory')->name('category.delete')->middleware('permission:category.delete');
    });

    // Product
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'AllProduct')->name('product.all')->middleware('permission:product.all');
        Route::get('/product/add', 'AddProduct')->name('product.add')->middleware('permission:product.add');
        Route::post('/product/store', 'StoreProduct')->name('product.store')->middleware('permission:product.store');
        Route::get('/product/edit/{id}', 'EditProduct')->name('product.edit')->middleware('permission:product.edit');
        Route::post('/product/update', 'UpdateProduct')->name('product.update')->middleware('permission:product.update');
        Route::get('/product/delete/{id}', 'DeleteProduct')->name('product.delete')->middleware('permission:product.delete');
        Route::get('/product/barcode/{id}', 'BarcodeProduct')->name('product.barcode')->middleware('permission:product.barcode');
        Route::get('/product/import', 'ImportProduct')->name('product.import.view')->middleware('permission:product.import.view');
        Route::get('/product/export', 'Export')->name('product.export')->middleware('permission:product.export');
        Route::post('/product/import', 'Import')->name('product.import')->middleware('permission:product.import');
    });

    // Expense
    Route::controller(ExpenseController::class)->group(function () {
        Route::get('/expense/add', 'AddExpense')->name('expense.add')->middleware('permission:expense.add');
        Route::post('/expense/store', 'StoreExpense')->name('expense.store')->middleware('permission:expense.store');
        Route::get('/expense/today', 'TodayExpense')->name('expense.today')->middleware('permission:expense.today');
        Route::get('/expense/edit/{id}', 'EditExpense')->name('expense.edit')->middleware('permission:expense.edit');
        Route::post('/expense/update', 'UpdateExpense')->name('expense.update')->middleware('permission:expense.update');
        Route::get('/expense/month', 'MonthExpense')->name('expense.month')->middleware('permission:expense.month');
        Route::get('/expense/year', 'YearExpense')->name('expense.year')->middleware('permission:expense.year');
    });

    // POS
    Route::controller(PosController::class)->group(function () {
        Route::get('/pos', 'Pos')->name('pos.index')->middleware('permission:pos.index');
        Route::post('/pos/cart/add', 'AddCart')->name('pos.cart.add')->middleware('permission:pos.cart.add');
        Route::get('/pos/cart/items', 'AllItem')->name('pos.cart.items')->middleware('permission:pos.cart.items');
        Route::post('/pos/cart/update/{rowId}', 'CartUpdate')->name('pos.cart.update')->middleware('permission:pos.cart.update');
        Route::get('/pos/cart/remove/{rowId}', 'CartRemove')->name('pos.cart.remove')->middleware('permission:pos.cart.remove');
    });

    // POS (Own)
    Route::prefix('own')->controller(PosController::class)->group(function () {
        Route::get('/pos', 'OwnPos')->name('own.pos.index')->middleware('permission:own.pos.index');
        Route::post('/pos/cart/add', 'OwnAddCart')->name('own.pos.cart.add')->middleware('permission:own.pos.cart.add');
        Route::post('/pos/cart/update/{productId}', 'OwnCartUpdate')->name('own.pos.cart.update')->middleware('permission:own.pos.cart.update');
        Route::get('/pos/cart/remove/{productId}', 'OwnCartRemove')->name('own.pos.cart.remove')->middleware('permission:own.pos.cart.remove');
        Route::get('/pos/cart/items', 'OwnAllItem')->name('own.pos.cart.items')->middleware('permission:own.pos.cart.items');
        Route::get('/pos/cart/destroy', 'OwnDestroyCart')->name('own.pos.cart.destroy')->middleware('permission:own.pos.cart.destroy');
        Route::post('/pos/invoice/create', 'CreateInvoice')->name('own.pos.invoice.create')->middleware('permission:own.pos.invoice.create');
    });

    // Order
    Route::controller(OrderController::class)->group(function () {
        Route::post('/order/invoice/final', 'FinalInvoice')->name('order.invoice.final')->middleware('permission:order.invoice.final');
        Route::get('/order/pending', 'PendingOrder')->name('order.pending')->middleware('permission:order.pending');
        Route::get('/order/details/{order_id}', 'OrderDetails')->name('order.details')->middleware('permission:order.details');
        Route::post('/order/status/update', 'OrderStatusUpdate')->name('order.status.update')->middleware('permission:order.status.update');
        Route::get('/order/complete', 'CompleteOrder')->name('order.complete')->middleware('permission:order.complete');
        Route::get('/order/invoice/download/{order_id}', 'OrderInvoice')->name('order.invoice.download')->middleware('permission:order.invoice.download');

        //For Stock Manage
        Route::get('/stock/manage', 'StockManage')->name('stock.manage')->middleware('permission:stock.manage');
    });

    // Roles/Permissions
    Route::controller(RoleController::class)->group(function () {
        Route::get('/permission/all', 'AllPermission')->name('permission.all')->middleware('permission:permission.all');
        Route::get('/permission/add', 'AddPermission')->name('permission.add')->middleware('permission:permission.add');
        Route::post('/permission/store', 'StorePermission')->name('permission.store')->middleware('permission:permission.store');
        Route::get('/permission/edit/{id}', 'EditPermission')->name('permission.edit')->middleware('permission:permission.edit');
        Route::post('/permission/update', 'UpdatePermission')->name('permission.update')->middleware('permission:permission.update');
        Route::get('/permission/delete/{id}', 'DeletePermission')->name('permission.delete')->middleware('permission:permission.delete');


        //Role
        Route::get('/roles/all', 'AllRoles')->name('roles.all')->middleware('permission:roles.all');
        Route::get('/roles/add', 'AddRoles')->name('roles.add')->middleware('permission:roles.add');
        Route::post('/roles/store', 'StoreRoles')->name('roles.store')->middleware('permission:roles.store');
        Route::get('/roles/edit/{id}', 'EditRoles')->name('roles.edit')->middleware('permission:roles.edit');
        Route::post('/roles/update', 'UpdateRoles')->name('roles.update')->middleware('permission:roles.update');
        Route::get('/roles/delete/{id}', 'DeleteRoles')->name('roles.delete')->middleware('permission:roles.delete');


        ///Add Roles in Permission All Route (Assign Permission(Route) In Roles)
        /// Here We select Which Role Can Access Which Permission
        Route::get('/roles/permissions/add', 'AddRolesPermission')->name('roles.permissions.add')->middleware('permission:roles.permissions.add');
        //Role and related permission store into database
        Route::post('/role/permission/store','StoreRolesPermission')->name('role.permission.store')->middleware('permission:role.permission.store');
        Route::get('roles/permission/all','AllRolesPermission')->name('roles.permission.all')->middleware('permission:roles.permission.all');
        Route::get('roles/permission/edit/{id}','EditRolePermissions')->name('role.permission.edit')->middleware('permission:role.permission.edit');
        Route::post('/role/permission/update','UpdateRolePermission')->name('role.permission.update')->middleware('permission:role.permission.update');
        Route::get('/role/permission/delete/{id}','DeleteRolesPermission')->name('role.permission.delete')->middleware('permission:role.permission.delete');
    });


    // User Add/Edit/Delete
    Route::controller(RoleAssignmentController::class)->group(function(){
        Route::get('/role/assignments', 'AllRoleAssignments')->name('role.assignments.all')->middleware('permission:role.assignments.all');
        Route::get('/role/assignments/add','AddRoleAssignments')->name('role.assignments.add')->middleware('permission:role.assignments.add');
        Route::post('/role/assignments/store','StoreRoleAssignments')->name('role.assignments.store')->middleware('permission:role.assignments.store');


        Route::get('/role/assignments/edit/{id}','EditRoleAssignments')->name('role.assignments.edit')->middleware('permission:role.assignments.edit');
        Route::post('/role/assignments/update','UpdateRoleAssignments')->name('role.assignments.update')->middleware('permission:role.assignments.update');
        Route::get('/role/assignments/delete/{id}','DeleteRoleAssignments')->name('role.assignments.delete')->middleware('permission:role.assignments.delete');
    });

});

require __DIR__ . '/auth.php';
