@extends('admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Add Role In Permission</a>
                                </li>

                            </ol>
                        </div>
                        <h4 class="page-title">Add Role In Permission</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">


                <div class="col-lg-8 col-xl-12">
                    <div class="card">
                        <div class="card-body">


                            <!-- end timeline content-->

                            <div class="tab-pane" id="settings">
                                <form id="myForm" method="post" action="{{  route('role.permission.store') }}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Role
                                        In Permission</h5>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstname" class="form-label">All Roles </label>
                                                <select name="role_id" class="form-select" id="example-select" required>
                                                    <option selected disabled value="">Select Roles</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}"> {{ $role->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-check mb-2 form-check-primary">
                                            <input class="form-check-input" type="checkbox" value="" id="select_all">
                                            <label class="form-check-label" for="select_all">Select All</label>
                                        </div>

                                    </div>
                                        <hr>
                                        @foreach($permissions as $groupName => $groupPermissions)
                                            {{--one group will be in one row--}}
                                            <div class="row">
                                                {{--Left Side Checkbox--}}
                                                {{--<div class="form-check-primary"> this make checkbox color magenta--}}
                                                {{--<div class="form-check-success"> this make checkbox color green--}}
                                                <div class="col-3">
                                                    <div class="form-check mb-2 form-check-primary">
                                                        <input class="form-check-input  group-checkbox" type="checkbox" value="" id="group_{{ $loop->index }}">
                                                        <label class="form-check-label" for="group_{{ $loop->index }}">{{$groupName}}</label>
                                                    </div>

                                                </div>

                                                {{--Right side checkbox--}}
                                                <div class="col-9">
                                                    @foreach($groupPermissions as $permission)
                                                            <div class="form-check mb-2 form-check-primary">
                                                                <input class="form-check-input permission-checkbox group_{{ $loop->parent->index }}"
                                                                       name="permission[]"
                                                                       type="checkbox"
                                                                       value="{{ $permission->id }}"
                                                                       id="perm_{{ $permission->id }}">

                                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                                    {{$permission->name}}
                                                                </label>
                                                            </div>


                                                    @endforeach
                                                </div>

                                            </div> <!-- end row -->
                                        <br>
                                        @endforeach
                                    </div> <!-- end row -->


                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i
                                                class="mdi mdi-content-save"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- end settings content-->


                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->


    <script>
        $(document).ready(function () {
            // Toggle all checkboxes when "Select All" is clicked
            $('#select_all').on('change', function () {
                var checked = $(this).is(':checked');
                $('.form-check-input').prop('checked', checked);
            });

            // Toggle group checkboxes' children
            $('.group-checkbox').each(function (index) {
                $(this).on('change', function () {
                    $('.group_' + index).prop('checked', $(this).is(':checked'));
                });
            });

          /*  // Optional: update group checkbox if all children are manually checked/unchecked
            $('.permission-checkbox').on('change', function () {
                var groupIndex = this.className.match(/group_(\d+)/)[1];
                var allChecked = $('.group_' + groupIndex).length === $('.group_' + groupIndex + ':checked').length;
                $('#group_' + groupIndex).prop('checked', allChecked);
            });*/
        });
    </script>


@endsection
