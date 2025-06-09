<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Employee
            ['name' => 'employee.all', 'group_name' => 'employee'],
            ['name' => 'employee.add', 'group_name' => 'employee'],
            ['name' => 'employee.store', 'group_name' => 'employee'],
            ['name' => 'employee.edit', 'group_name' => 'employee'],
            ['name' => 'employee.update', 'group_name' => 'employee'],
            ['name' => 'employee.delete', 'group_name' => 'employee'],

            // Employee Attendance
            ['name' => 'employee.attendance.list', 'group_name' => 'employee_attendance'],
            ['name' => 'employee.attendance.add', 'group_name' => 'employee_attendance'],
            ['name' => 'employee.attendance.store', 'group_name' => 'employee_attendance'],
            ['name' => 'employee.attendance.edit', 'group_name' => 'employee_attendance'],
            ['name' => 'employee.attendance.update', 'group_name' => 'employee_attendance'],
            ['name' => 'employee.attendance.view', 'group_name' => 'employee_attendance'],

            // Customer
            ['name' => 'customer.all', 'group_name' => 'customer'],
            ['name' => 'customer.add', 'group_name' => 'customer'],
            ['name' => 'customer.store', 'group_name' => 'customer'],
            ['name' => 'customer.edit', 'group_name' => 'customer'],
            ['name' => 'customer.update', 'group_name' => 'customer'],
            ['name' => 'customer.delete', 'group_name' => 'customer'],

            // Supplier
            ['name' => 'supplier.all', 'group_name' => 'supplier'],
            ['name' => 'supplier.add', 'group_name' => 'supplier'],
            ['name' => 'supplier.store', 'group_name' => 'supplier'],
            ['name' => 'supplier.edit', 'group_name' => 'supplier'],
            ['name' => 'supplier.update', 'group_name' => 'supplier'],
            ['name' => 'supplier.delete', 'group_name' => 'supplier'],
            ['name' => 'supplier.details', 'group_name' => 'supplier'],

            // Employee Salary
            ['name' => 'employee.salary.advance.add', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.advance.store', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.advance.all', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.advance.edit', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.advance.update', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.advance.delete', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.pay', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.pay.now', 'group_name' => 'employee_salary'],
            ['name' => 'employee.salary.pay.store', 'group_name' => 'employee_salary'],

            // Category
            ['name' => 'category.all', 'group_name' => 'category'],
            ['name' => 'category.store', 'group_name' => 'category'],
            ['name' => 'category.edit', 'group_name' => 'category'],
            ['name' => 'category.update', 'group_name' => 'category'],
            ['name' => 'category.delete', 'group_name' => 'category'],

            // Product
            ['name' => 'product.all', 'group_name' => 'product'],
            ['name' => 'product.add', 'group_name' => 'product'],
            ['name' => 'product.store', 'group_name' => 'product'],
            ['name' => 'product.edit', 'group_name' => 'product'],
            ['name' => 'product.update', 'group_name' => 'product'],
            ['name' => 'product.delete', 'group_name' => 'product'],
            ['name' => 'product.barcode', 'group_name' => 'product'],
            ['name' => 'product.import.view', 'group_name' => 'product'],
            ['name' => 'product.import', 'group_name' => 'product'],
            ['name' => 'product.export', 'group_name' => 'product'],

            // Expense
            ['name' => 'expense.add', 'group_name' => 'expense'],
            ['name' => 'expense.store', 'group_name' => 'expense'],
            ['name' => 'expense.today', 'group_name' => 'expense'],
            ['name' => 'expense.month', 'group_name' => 'expense'],
            ['name' => 'expense.year', 'group_name' => 'expense'],
            ['name' => 'expense.edit', 'group_name' => 'expense'],
            ['name' => 'expense.update', 'group_name' => 'expense'],

            // POS
            ['name' => 'pos.index', 'group_name' => 'pos'],
            ['name' => 'pos.cart.add', 'group_name' => 'pos'],
            ['name' => 'pos.cart.items', 'group_name' => 'pos'],
            ['name' => 'pos.cart.update', 'group_name' => 'pos'],
            ['name' => 'pos.cart.remove', 'group_name' => 'pos'],

            // Own POS
            ['name' => 'own.pos.index', 'group_name' => 'own_pos'],
            ['name' => 'own.pos.cart.add', 'group_name' => 'own_pos'],
            ['name' => 'own.pos.cart.update', 'group_name' => 'own_pos'],
            ['name' => 'own.pos.cart.remove', 'group_name' => 'own_pos'],
            ['name' => 'own.pos.cart.items', 'group_name' => 'own_pos'],
            ['name' => 'own.pos.cart.destroy', 'group_name' => 'own_pos'],
            ['name' => 'own.pos.invoice.create', 'group_name' => 'own_pos'],

            // Order
            ['name' => 'order.invoice.final', 'group_name' => 'order'],
            ['name' => 'order.pending', 'group_name' => 'order'],
            ['name' => 'order.details', 'group_name' => 'order'],
            ['name' => 'order.status.update', 'group_name' => 'order'],
            ['name' => 'order.complete', 'group_name' => 'order'],
            ['name' => 'order.invoice.download', 'group_name' => 'order'],

            // Stock
            ['name' => 'stock.manage', 'group_name' => 'stock'],

            // Roles / Permissions
            ['name' => 'permission.all', 'group_name' => 'roles'],
            ['name' => 'permission.add', 'group_name' => 'roles'],
            ['name' => 'permission.store', 'group_name' => 'roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'group_name' => $permission['group_name'],
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
