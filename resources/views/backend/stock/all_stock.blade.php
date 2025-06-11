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


                                @if(Auth::user()->can('product.import.view'))
                                    <a href="{{ route('product.import.view') }}"
                                       class="btn btn-info rounded-pill waves-effect waves-light">Import </a>
                                @endif
                                @if(Auth::user()->can('product.export'))
                                    <a href="{{ route('product.export') }}"
                                       class="btn btn-danger rounded-pill waves-effect waves-light">Export </a>
                                @endif
                                &nbsp;&nbsp;&nbsp;
                                @if(Auth::user()->can('product.add'))
                                    <a href="{{ route('product.add') }}"
                                       class="btn btn-primary rounded-pill waves-effect waves-light">Add Product </a>
                                @endif
                            </ol>
                        </div>
                        <h4 class="page-title">All Product</h4>
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
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Code</th>
                                    <th>Stock</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($product as $key=> $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><img src="{{ asset($item->product_image) }}"
                                                 style="width:50px; height: 40px;"></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->category->category_name}}</td>
                                        <td>{{$item->supplier->name}}</td>
                                        <td>{{ $item->product_code }}</td>
                                        <td>
                                            <button
                                                class="btn btn-warning waves-effect waves-light">{{ $item->product_store }}</button>
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
