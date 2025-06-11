<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('backend/assets/images/users/user-1.jpg')}}" alt="user-img" title="Mat Helme"
                 class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-bs-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>


                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboards </span>
                    </a>
                </li>

                @if(Auth::user()->can('pos.menu'))
                    <li>
                        <a href="{{ route('pos.index') }}">
                            <span class="badge bg-pink float-end">Hot</span>
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> POS </span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->can('own.pos.menu'))
                    <li>
                        <a href="{{ route('own.pos.index') }}">
                            <span class="badge bg-pink float-end">own pos</span>
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span>Own POS </span>
                        </a>
                    </li>
                @endif

                <li class="menu-title mt-2">Apps</li>

                @if(Auth::user()->can('employee.menu'))
                    <li>
                        <a href="#sidebarEcommerce" data-bs-toggle="collapse">
                            <i class="mdi mdi-cart-outline"></i>
                            <span> Employee Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEcommerce">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('employee.all'))
                                    <li>
                                        <a href="{{route('employee.all')}}">All Employee</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('employee.add'))
                                    <li>
                                        <a href="{{route('employee.add')}}">Add Employee</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(Auth::user()->can('customer.menu'))
                    <li>
                        <a href="#sidebarCrm" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span> Customer Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('customer.all'))
                                    <li>
                                        <a href="{{ route('customer.all') }}">All Customer</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('customer.add'))
                                    <li>
                                        <a href="{{route('customer.add')}}">Add Customer</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(Auth::user()->can('supplier.menu'))
                    <li>
                        <a href="#sidebarEmail" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Supplier Manage </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('supplier.all'))
                                    <li>
                                        <a href="{{route('supplier.all')}}">All Supplier</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('supplier.add'))
                                    <li>
                                        <a href="{{ route('supplier.add') }}">Add Supplier</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('employee.salary.menu'))
                    <li>
                        <a href="#salary" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Employee Salary </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="salary">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('employee.salary.advance.add'))
                                    <li>
                                        <a href="{{route('employee.salary.advance.add')}}">Add Advance Salary</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('employee.salary.advance.all'))
                                    <li>
                                        <a href="{{ route('employee.salary.advance.all') }}">All Advance Salary</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('employee.salary.pay'))
                                    <li>
                                        <a href="{{ route('employee.salary.pay') }}">Pay Salary</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif



                @if(Auth::user()->can('employee.attendance.menu'))
                    <li>
                        <a href="#attendance" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Employee Attendance </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="attendance">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('employee.attendance.list')}}">Employee Attendance List </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('category.menu'))
                    <li>
                        <a href="#category" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Category </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="category">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('category.all'))
                                    <li>
                                        <a href="{{ route('category.all') }}">All Category </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('product.menu'))
                    <li>
                        <a href="#product" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Products  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="product">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('product.all'))
                                    <li>
                                        <a href="{{ route('product.all') }}">All Product </a>
                                    </li>
                                @endif

                                @if(Auth::user()->can('product.add'))
                                    <li>
                                        <a href="{{ route('product.add') }}">Add Product </a>
                                    </li>
                                @endif

                                @if(Auth::user()->can('product.import'))
                                    <li>
                                        <a href="{{ route('product.import') }}">Import Product </a>
                                    </li>
                                @endif


                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('orders.menu'))
                    <li>
                        <a href="#orders" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Orders  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="orders">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('order.pending'))
                                    <li>
                                        <a href="{{ route('order.pending') }}">Pending Orders </a>
                                    </li>
                                @endif

                                @if(Auth::user()->can('order.complete'))
                                    <li>
                                        <a href="{{ route('order.complete') }}">Complete Orders </a>
                                    </li>
                                @endif


                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('stock.menu'))
                    <li>
                        <a href="#stock" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Stock Manage  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="stock">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('stock.manage'))
                                    <li>
                                        <a href="{{ route('stock.manage') }}">Stock </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('roles.menu'))
                    <li>
                        <a href="#permission" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Roles And Permission  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="permission">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('permission.all'))
                                    <li>
                                        <a href="{{ route('permission.all') }}">All Permission </a>
                                    </li>
                                @endif

                                @if(Auth::user()->can('roles.all'))
                                    <li>
                                        <a href="{{ route('roles.all') }}">All Roles </a>
                                    </li>
                                @endif

                                @if(Auth::user()->can('roles.permissions.add'))
                                    <li>
                                        <a href="{{ route('roles.permissions.add') }}">Roles in Permission </a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('roles.permission.all'))
                                    <li>
                                        <a href="{{ route('roles.permission.all') }}">All Roles in Permission </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif


                @if(Auth::user()->can('role.assignment.menu'))
                    <li>
                        <a href="#admin" data-bs-toggle="collapse">
                            <i class="mdi mdi-email-multiple-outline"></i>
                            <span> Setting Admin User    </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="admin">
                            <ul class="nav-second-level">
                                {{--@if(Auth::user()->can('role.assignments.all'))--}}
                                    <li>
                                        <a href="{{ route('role.assignments.all') }}">All User </a>
                                    </li>
                                {{--@endif--}}
                               {{-- @if(Auth::user()->can('role.assignments.add'))--}}
                                    <li>
                                        <a href="{{ route('role.assignments.add') }}">Add User </a>
                                    </li>
                               {{-- @endif--}}

                            </ul>
                        </div>
                    </li>
                @endif




                @if(Auth::user()->can('expense.menu'))
                    <li class="menu-title mt-2">Custom</li>


                    <li>
                        <a href="#sidebarAuth" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-circle-outline"></i>
                            <span> Expense  </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAuth">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('expense.add'))
                                    <li>
                                        <a href="{{ route('expense.add') }}">Add Expense</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('expense.today'))
                                    <li>
                                        <a href="{{ route('expense.today') }}">Today Expense</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('expense.month'))
                                    <li>
                                        <a href="{{ route('expense.month') }}">Monthly Expense</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('expense.year'))
                                    <li>
                                        <a href="{{ route('expense.year') }}">Yearly Expense</a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif


            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
