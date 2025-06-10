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
                                <a href="" class="btn btn-primary rounded-pill waves-effect waves-light">Add Role in Permission </a>
                            </ol>
                        </div>
                        <h4 class="page-title">All Roles Permission</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <table  class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Roles Name </th>
                                    <th>Permission Name </th>
                                    <th width="18%">Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($roles as $index => $role)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach($role->permissions as $perm)
                                                <span class="badge rounded-pill bg-danger"> {{ $perm->name }} </span>
                                            @endforeach

                                        </td>
                                        <td width="18%">
                                            <a href="{{ route('role.permission.store.edit',$role->id) }}" class="btn btn-blue rounded-pill waves-effect waves-light">Edit</a>
                                            <a href="{{ route('permission.delete',$role->id) }}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete">Delete</a>
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
