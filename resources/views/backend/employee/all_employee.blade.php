@extends('admin_dashboard')
@section('admin')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <a href="{{route('employee.add')}}"
                                   class="btn btn-primary rounded-pill waves-effect waves-light">Add Employee </a>
                            </ol>
                        </div>
                        <h4 class="page-title">All Employee</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($employee as $key=>$item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><img src="{{ asset($item->image) }}" style="width:50px; height: 40px;"></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->salary }}</td>
                                        <td>
                                            @if(Auth::user()->can('employee.edit'))
                                                <a href="{{route('employee.edit',$item->id)}}"
                                                   class="btn btn-blue rounded-pill waves-effect waves-light">Edit</a>
                                            @endif
                                            @if(Auth::user()->can('employee.delete'))
                                                <a href="{{route('employee.delete',$item->id)}}" id="delete"
                                                   class="btn btn-danger rounded-pill waves-effect waves-light">Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


        </div> <!-- container -->

    </div> <!-- content -->

@endsection
