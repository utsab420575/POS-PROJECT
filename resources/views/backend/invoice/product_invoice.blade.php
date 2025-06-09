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
                                <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                <li class="breadcrumb-item active">Create Invoice</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Customer</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo & title -->
                            <div class="clearfix">
                                <div class="float-start">
                                    <div class="auth-logo">
                                        <div class="logo logo-dark">
                                            <span class="logo-lg">
                                                <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="22">
                                            </span>
                                        </div>

                                        <div class="logo logo-light">
                                            <span class="logo-lg">
                                                <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="22">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-end">
                                    <h4 class="m-0 d-print-none">Invoice</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <p><b>Hello, {{ $customer->name }}</b></p>
                                    </div>

                                </div><!-- end col -->
                                <div class="col-md-4 offset-md-2">
                                    <div class="mt-3 float-end">
                                        <p><strong>Order Date : &nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                            <span class="float-end">{{ \Carbon\Carbon::now()->format('M d, Y') }}</span>
                                        </p>
                                        <p><strong>Order Status : </strong> <span class="float-end"><span
                                                    class="badge bg-danger">Unpaid</span></span></p>
                                        <p><strong>Order No. : </strong> <span class="float-end">000028 </span></p>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <h6>Billing Address</h6>
                                    <address>
                                        {{ $customer->address }} - {{ $customer->city }}<br>
                                        <abbr title="Phone">Shop Name:</abbr> {{ $customer->shopname }}<br>
                                        <abbr title="Phone">Phone:</abbr> {{ $customer->phone }}<br>
                                        <abbr title="Phone">Email:</abbr> {{ $customer->email }}<br>
                                    </address>
                                </div> <!-- end col -->

                                {{--<div class="col-sm-6">
                                    <h6>Shipping Address</h6>
                                    <address>
                                        Stanley Jones<br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        <abbr title="Phone">P:</abbr> (123) 456-7890
                                    </address>
                                </div> <!-- end col -->--}}
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-4 table-centered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th style="width: 10%">Qty</th>
                                                    <th style="width: 10%">Unit Cost</th>
                                                    <th style="width: 10%" class="text-end">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                    $subTotal = 0;
                                                @endphp
                                                @foreach($contents as $key=>$item)
                                                    @php
                                                        $lineTotal = $item['qty'] * $item['price'];
                                                        $subTotal += $lineTotal;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$i+1}}</td>
                                                        <td>
                                                            {{ $item['name'] }}
                                                        </td>
                                                        <td>{{ $item['qty'] }}</td>
                                                        <td>${{ number_format($item['price'], 2) }}</td>
                                                        <td class="text-end">${{ number_format($lineTotal, 2) }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="clearfix pt-5">
                                        <h6 class="text-muted">Notes:</h6>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="float-end">
                                        <p><b>Sub-total:</b> <span class="float-end">${{ number_format($subTotal, 2) }}</span></p>
                                        <p><b>VAT (5%):</b> <span
                                                class="float-end"> &nbsp;&nbsp;&nbsp; ${{ number_format($subTotal * 0.05, 2) }}</span></p>
                                        <h3>${{ number_format($subTotal * 1.05, 2) }}</h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="mt-4 mb-1">
                                <div class="text-end d-print-none">
                                    <a href="javascript:window.print()"
                                       class="btn btn-primary waves-effect waves-light"><i
                                            class="mdi mdi-printer me-1"></i> Print</a>
                                    {{--Modal button--}}
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup-modal">Create Invoice </button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->



    <!-- Signup modal content -->
    <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center mt-2 mb-4 ">
                        <div class="auth-logo">
                            <h3>Invoice Of {{ $customer->name }}</h3>
                            <h3>Total Amount  ${{ number_format($subTotal * 1.05, 2) }}</h3>
                        </div>
                    </div>




                    <form class="px-3" method="post" action="{{ route('order.invoice.final') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment</label>
                            <select name="payment_status" class="form-select" id="example-select">
                                <option selected disabled >Select Payment </option>

                                <option value="HandCash">HandCash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Due">Due</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pay" class="form-label">Pay Now</label>
                            <input class="form-control" name="pay" type="text" placeholder="Pay Now">
                        </div>


                        <div class="mb-3">
                            <label for="due" class="form-label">Due Amount</label>
                            <input class="form-control" name="due" type="text"  placeholder="Due Amount ">
                        </div>


                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <input type="hidden" name="order_date" value="{{ date('d-F-Y') }}">
                        <input type="hidden" name="order_status" value="pending">
                        <input type="hidden" name="total_products" value="{{ $totalProducts }}">
                        <input type="hidden" name="sub_total" value="{{ number_format($subTotal, 2, '.', '') }}">
                        <input type="hidden" name="vat" value="{{ number_format($vat, 2, '.', '') }}">
                        <input type="hidden" name="total" value="{{ number_format($total, 2, '.', '') }}">


                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" type="submit">Complete Order </button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
