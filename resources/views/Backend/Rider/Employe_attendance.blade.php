@extends('Master.main')
@section('title')
    Employee Attendance
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-5" style="padding:0px; margin-right:20px;">
                                    Employee Attendance
                                </h1>

                                <form action="{{ route('employee.attendance.index') }}" method="get">
                                    @csrf
                                    {{-- <div class="col-lg-3" style="padding:0px;">

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">Branch :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select name="role" class="selectpicker form-control"
                                                    title="Select Employee" data-style="btn-info" data-live-search="true"
                                                    required>
                                                    <option value="2">Admin</option>
                                                    <option value="4">Manager</option>
                                                    <option value="6">Accounts</option>
                                                    <option value="16">Call Center</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2" style="padding:0px;">
                                                <label style="float:right;"> Date :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control"
                                                    name="todate" required />
                                            </div>

                                        </div>
                                    </div>
                                    {{-- <button type="submit"class="btn btn-primary btn-sm Primary">Load</button> --}}
                                </form>
                            </div>
                        </div>

                        <p>
                            <button type="submit" id="preview" class="btn btn-success col-lg-1"
                                style="float:right;">Submit
                            </button>
                        </p>


                        <div class="clearfix"></div>
                        <hr>

                        <div class="sparkline13-graph">

                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div id="toolbar">
                                    <select class="form-control">
                                        <option value="">Export Basic</option>
                                        <option value="all">Export All</option>
                                        <option value="selected">Export Selected</option>
                                    </select>
                                </div>
                                <table id="tables" data-toggle="table" data-pagination="false" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>

                                            <th data-field="sl">SL.</th>
                                            <th data-field="m_name" data-editable="false">Employee No</th>
                                            <th data-field="s_phone" data-editable="false">Employee Name</th>
                                            <th data-field="s_phone1" data-editable="false">Mobile</th>
                                            <th data-field="s_phone2" data-editable="false">Role</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="collection" data-editable="false">In time</th>
                                            <th data-field="delivery" data-editable="false">Out Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                            $j = 0;
                                        @endphp

                                        @foreach ($user as $key => $item)
                                            <tr>

                                                <td>{{ ++$j }}</td>
                                                <td class="user-id">{{ $item->id }}</td>
                                                <td class="rider-name">{{ $item->name }}</td>
                                                <td class="mobile">{{ $item->mobile }}</td>
                                                @if ($item->role == 2)
                                                    <td class="area">Admin</td>
                                                @elseif ($item->role == 4)
                                                    <td class="area">Manager</td>
                                                @elseif ($item->role == 6)
                                                    <td class="area">Accounts</td>
                                                @elseif ($item->role == 16)
                                                    <td class="area">Call Center</td>
                                                @endif

                                                <td style="width: 150px;"><select name="status" class="form-control status"
                                                        title="Select status" required>

                                                        <option value="Absent">Absent</option>
                                                        <option value="Present">Present</option>
                                                        <option value="Leave">Leave</option>
                                                        <option value="Late">Late</option>

                                                    </select></td>
                                                <td><input type="time" name="intime" class="form-control"></td>
                                                <td><input type="time" name="outtime" class="form-control"></td>
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
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer>
    </script>
    <script>
        $(document).ready(function() {





            $("#preview").click(function() {




                var all_data = [];


                $('#tables tbody tr').each(function() {

                    var rider_id = $(this).find('.user-id').text();
                    all_data.push(rider_id);
                    var rider_name = $(this).find('.rider-name').text();
                    all_data.push(rider_name);
                    var mobile = $(this).find('.mobile').text();
                    all_data.push(mobile);
                    var area = $(this).find('.area').text();
                    all_data.push(area);

                    var tdObject = $(this).find('td:eq(5)');
                    var selectObject = tdObject.find("select");
                    var status = selectObject.val();
                    all_data.push(status);


                    var intime = $(this).find("input[name='intime']").val();
                    all_data.push(intime);

                    var outtime = $(this).find("input[name='outtime']").val();
                    all_data.push(outtime);


                });


                 console.log(all_data);

                $.ajax({
                    type: "POST",

                    url: "{{ route('employee.attendance.all.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        all_data: all_data,


                    },
                    success: function(data) {

                        window.location.href =
                            "{{ route('employee.attendance.index') }}";



                    }
                });







            });













        });
    </script>
@endsection
