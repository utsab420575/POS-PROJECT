@extends('admin_dashboard')
@section('admin')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <!-- Left: Page Title -->
                        <h4 class="page-title mb-0">All Pay Salary</h4>
                        <div class="page-title-right">
                            <div class="page-title-right">
                                <form action="{{route('pay.salary')}}" method="GET" class="d-flex align-items-center gap-2 pb-4">

                                    @php
                                        $defaultMonth = date('F', strtotime('-1 month'));
                                        $defaultYear = date('Y', strtotime('-1 month'));
                                    @endphp

                                        <!-- Month Dropdown -->
                                    <select name="month" class="form-select form-select-sm" required>
                                        @foreach(range(1, 12) as $m)
                                            @php $monthName = date('F', mktime(0, 0, 0, $m, 1)); @endphp
                                            <option
                                                value="{{ $monthName }}" {{ $monthName == $defaultMonth ? 'selected' : '' }}>
                                                {{ $monthName }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Year Dropdown -->
                                    <select name="year" class="form-select form-select-sm" required>
                                        @for($y = now()->year; $y >= now()->year - 5; $y--)
                                            <option
                                                value="{{ $y }}" {{ $y == $defaultYear ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-success btn-sm">View</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->


                <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{$month??'' }} {{$year??''}}</h4>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Month</th>
                                    <th>Salary</th>
                                    <th>Advance</th>
                                    <th>Due</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                {{--table data shown when month and year is selected--}}
                                @if(!empty($month) && !empty($year))
                                    <tbody>
                                    @foreach($employee as $key=> $item)
                                        @php
                                            $advance = $item->getAdvanceSalary($month, $year);
                                            $advanceAmount = $advance?->advance_salary ?? 0;
                                            $due = $item->salary - $advanceAmount;
                                        @endphp
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td><img src="{{ asset($item->image) }}" style="width:50px; height: 40px;"></td>
                                            <td>{{ $item->name }}</td>
                                            <td><span class="badge bg-info"> {{ $month }} </span>
                                            </td>
                                            <td> {{ $item->salary }} </td>
                                            <td>{{$advanceAmount>0? $advanceAmount:'No Advance'}}</td>
                                            <td>{{$due}}</td>
                                            <td>
                                                <a href="{{ route('edit.advance.salary',$item->id) }}"
                                                   class="btn btn-blue rounded-pill waves-effect waves-light">Pay Now</a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                {{--no month year selected show error message--}}
                                @else
                                    <div class="alert alert-info mt-3">
                                        Please select a <strong>Month</strong> and <strong>Year</strong> to view salary data.
                                    </div>
                                @endif
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>

            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->

    More actions
@endsection
