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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Edit Admin</a></li>

                            </ol>
                        </div>
                        <h4 class="page-title">Edit Admin</h4>
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
                                <form id="myForm" method="post" action="{{ route('role.assignments.update') }}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit
                                        User</h5>

                                    <div class="row">


                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstname" class="form-label"> Name</label>
                                                <input type="text" name="name" class="form-control"
                                                       value="{{ $user->name }}">

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstname" class="form-label"> Email</label>
                                                <input type="email" name="email" class="form-control"
                                                       value="{{ $user->email }}">

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstname" class="form-label"> Phone</label>
                                                <input type="text" name="phone" class="form-control"
                                                       value="{{ $user->phone }}">

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="firstname" class="form-label">Asign Roles </label>
                                                <select name="roles[]" class="form-select" id="example-select" multiple>
                                                    <option disabled>Select Roles</option>
                                                    @foreach($roles as $role)
                                                        <option
                                                            value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }} >{{ $role->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="example-fileinput" class="form-label">Image</label>
                                                <input type="file" name="image" id="image" class="form-control">

                                            </div>
                                        </div> <!-- end col -->


                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="example-fileinput" class="form-label"> </label>
                                                <img id="showImage" src="{{ $user->photo ? asset($user->photo) : asset('upload/no_image.jpg') }}"  class="rounded-circle avatar-lg img-thumbnail"
                                                     alt="profile-image">
                                            </div>
                                        </div> <!-- end col -->


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


    <script type="text/javascript">

        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>

@endsection
