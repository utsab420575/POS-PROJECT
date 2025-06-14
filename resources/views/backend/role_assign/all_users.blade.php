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
                                <a href="{{ route('role.assignments.add') }}"
                                   class="btn btn-primary rounded-pill waves-effect waves-light">Add User </a>
                            </ol>
                        </div>
                        <h4 class="page-title">All Admin <span class="btn btn-danger">{{ count($allUsers) }}</span></h4>
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($allUsers as $key=> $user)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><img
                                                src="{{ (!empty($user->photo)) ? asset($user->photo) : url('upload/no_image.jpg') }}"
                                                style="width:50px; height: 40px;"></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-pill bg-danger"> {{ $role->name }} </span>
                                            @endforeach
                                        </td>

                                        <td>
                                            @if(Auth::user()->can('role.assignments.edit'))
                                                <a href="{{ route('role.assignments.edit',$user->id) }}"
                                                   class="btn btn-blue rounded-pill waves-effect waves-light">Edit</a>
                                            @endif
                                            @if(Auth::user()->can('role.assignments.delete'))
                                                <a href="{{ route('role.assignments.delete',$user->id) }}"
                                                   class="btn btn-danger rounded-pill waves-effect waves-light"
                                                   id="delete">Delete</a>
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
