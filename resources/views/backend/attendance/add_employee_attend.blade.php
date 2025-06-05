@extends('admin_dashboard')
@section('admin')

    <div class="content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <a href="{{ route('employee.attend.list') }}" class="btn btn-primary p-2 ps-4 pe-4 mb-2"><i class="fas fa-list"></i>
                                    Attendance List</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('employee.attend.store')}}" method="POST" id="attendanceForm">
                                @csrf
                                <div class="form-group col-md-4">
                                    <label for="date">Attendance Date</label>
                                    <input type="date" name="date" class="form-control form-control-sm p-2" required>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;" rowspan="2">SL</th>
                                        <th class="text-center" style="vertical-align: middle;" rowspan="2">Employee Name</th>
                                        <th colspan="3" class="text-center">Attendance Status</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center bg-primary">Present</th>
                                        <th class="text-center bg-primary">Leave</th>
                                        <th class="text-center bg-primary">Absent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($employees as $key => $employee)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $employee->name }}</td>
                                           {{-- <input type="hidden" name="attendance[{{ $key }}][employee_id]" value="{{ $employee->id }}">--}}

                                            @php $group = "status_group_$key"; @endphp

                                            {{-- Present --}}
                                            <td class="p-0 align-middle">
                                                <input type="radio" class="btn-check"
                                                       name="attendance[{{ $employee->id }}][status]" id="present{{ $key }}"
                                                       value="present" autocomplete="off" checked
                                                       data-group="{{ $group }}" data-color="success">
                                                <label class="btn btn-success w-100 m-0 py-2 d-flex align-items-center justify-content-center"
                                                       for="present{{ $key }}" data-role="{{ $group }}">Present</label>
                                            </td>

                                            {{-- Leave --}}
                                            <td class="p-0 align-middle">
                                                <input type="radio" class="btn-check"
                                                       name="attendance[{{ $employee->id }}][status]" id="leave{{ $key }}"
                                                       value="leave" autocomplete="off"
                                                       data-group="{{ $group }}" data-color="warning">
                                                <label class="btn btn-outline-secondary w-100 m-0 py-2 d-flex align-items-center justify-content-center"
                                                       for="leave{{ $key }}" data-role="{{ $group }}">Leave</label>
                                            </td>

                                            {{-- Absent --}}
                                            <td class="p-0 align-middle">
                                                <input type="radio" class="btn-check"
                                                       name="attendance[{{$employee->id }}][status]" id="absent{{ $key }}"
                                                       value="absent" autocomplete="off"
                                                       data-group="{{ $group }}" data-color="danger">
                                                <label class="btn btn-outline-secondary w-100 m-0 py-2 d-flex align-items-center justify-content-center"
                                                       for="absent{{ $key }}" data-role="{{ $group }}">Absent</label>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                                <button type="submit" class="btn btn-success">Submit Attendance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS for Toggle Button Classes -->
    <script>
        document.querySelectorAll('input[type=radio][data-group]').forEach(radio => {
            radio.addEventListener('change', function () {
                const group = this.dataset.group;
                const color = this.dataset.color;

                // Reset all buttons in group
                document.querySelectorAll(`label[data-role="${group}"]`).forEach(label => {
                    label.className = 'btn btn-outline-secondary w-100 m-0 py-2 d-flex align-items-center justify-content-center';
                });

                // Set selected button color
                const label = document.querySelector(`label[for="${this.id}"]`);
                if (label) {
                    label.classList.remove('btn-outline-secondary');
                    label.classList.add(`btn-${color}`);
                }
            });
        });
    </script>


@endsection
