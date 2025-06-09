@extends('admin_dashboard')
@section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex justify-content-between align-items-center">
                        <h4 class="page-title">POS</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">POS</a></li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- POS Layout -->
            <div class="row">
                <!-- Cart Column -->
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
                                    @php
                                        $ownCart = session('own_cart', []);
                                    @endphp

                                    @if(count($ownCart) > 0)
                                        @foreach(session('own_cart') as $productId => $item)
                                            @php
                                                $subTotal = $item['price'] * $item['qty'];
                                            @endphp
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('own.pos.cart.update', $productId) }}">
                                                        @csrf
                                                        <input type="number" name="qty" value="{{ $item['qty'] }}" style="width: 50px;" min="1">
                                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                                    </form>
                                                </td>
                                                <td>{{ $item['price'] }}</td>
                                                <td>{{ $subTotal }}</td>
                                                <td>
                                                    <a href="{{ route('own.pos.cart.remove', $productId) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Cart is empty.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Totals -->
                            <div class="bg-primary p-3 mt-3 rounded">
                                <p class="text-white">Quantity: {{ $cartTotalQty }}</p>
                                <p class="text-white">Subtotal: {{ number_format($cartSubTotal, 2) }}</p>
                                <p class="text-white">VAT (5%): {{ number_format($vat, 2) }}</p>
                                <h4 class="text-white">Total: {{ number_format($total, 2) }}</h4>
                            </div>

                            <!-- Invoice -->
                            <form method="post" action="{{ route('own.pos.invoice.create') }}">
                                @csrf
                                <div class="form-group mb-3 mt-3">
                                    <label for="customer_id">All Customers</label>
                                    <a href="{{ route('customer.add') }}" class="btn btn-primary btn-sm mb-2 float-end">Add Customer</a>
                                    <select name="customer_id" class="form-select" required>
                                        <option value="" selected disabled>Select Customer</option>
                                        @foreach($customer as $cus)
                                            <option value="{{ $cus->id }}">{{ $cus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-blue waves-effect waves-light">Create Invoice</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Product Column -->
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Add</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product as $key => $item)
                                    <tr>
                                        <form method="POST" action="{{ route('own.pos.cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="name" value="{{ $item->product_name }}">
                                            <input type="hidden" name="qty" value="1">
                                            <input type="hidden" name="price" value="{{ $item->selling_price }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset($item->product_image) }}" style="width:50px; height:40px;"></td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-plus-square"></i>
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
