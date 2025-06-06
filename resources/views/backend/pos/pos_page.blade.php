@extends('admin_dashboard')More actions
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">POS</a></li>

                            </ol>
                        </div>
                        <h4 class="page-title">POS</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>QTY</th>
                                        <th>Price</th>
                                        <th>SubTotal</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Mark</td>
                                        <td>
                                            <input type="number" value="0" style="width:40px;" min="1">
                                        </td>
                                        <td>334</td>
                                        <td>43543</td>
                                        <td> <a href=""><i class="fas fa-trash-alt" style="color:#ffffff"></i></a> </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>


                            <div class="bg-primary">
                                <br>
                                <p style="font-size:18px; color:#fff"> Quantity : 3434 </p>
                                <p style="font-size:18px; color:#fff"> SubTotal : 3434 </p>
                                <p style="font-size:18px; color:#fff"> Vat : 3434 </p>
                                <p><h2 class="text-white"> Total </h2> <h1 class="text-white"> 3434</h1>   </p>
                                <br>
                            </div>

                            <br>
                            <form>


                                <div class="form-group mb-3">
                                    <label for="firstname" class="form-label">All Customer </label>

                                    <a href="{{ route('add.customer') }}" class="btn btn-primary rounded-pill waves-effect waves-light mb-2">Add Customer </a>


                                    <select name="supplier_id" class="form-select" id="example-select">
                                        <option selected disabled >Select Customer </option>
                                        @foreach($customer as $cus)
                                            <option value="{{ $cus->id }}">{{ $cus->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <button class="btn btn-blue waves-effect waves-light">Create Invoice</button>


                            </form>

                        </div>
                    </div> <!-- end card -->


                </div> <!-- end col-->

                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">


                            <!-- end timeline content-->

                            <div class="tab-pane" id="settings">


                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($product as $key=> $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td><img src="{{ asset($item->product_image) }}"
                                                     style="width:50px; height: 40px;"></td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>
                                                <button type="submit" style="font-size: 20px; color: #000;"><i
                                                        class="fas fa-plus-square"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                            <!-- end settings content-->


                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->

@endsection
