@extends('Master.main')
@section('title')
    Rider Attendance
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-2" style="padding:0px; margin-right:20px;">
                                    Rider Attendance
                                </h1>


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
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="m_name" data-editable="false">Rider No</th>
                                            <th data-field="s_phone" data-editable="false">Rider Name</th>
                                            <th data-field="s_phone1" data-editable="false">Mobile</th>
                                            <th data-field="s_phone2" data-editable="false">Branch</th>
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

                                        @foreach (session('all_data') as $value)
                                            <tr>
                                                <td></td>
                                                <td>{{ ++$i }}</td>
                                                <td class="user-id">{{ $value['user-id'] }}</td>
                                                <td class="rider-name">{{ $value['rider-name'] }}</td>
                                                <td class="mobile">{{ $value['mobile'] }}</td>
                                                <td class="area">{{ $value['area'] }}</td>
                                                <td style="width: 150px;" class="status">{{ $value['status'] }}</td>
                                                <td class="intime"> <input type="time" name="intime"
                                                        class="form-control" value="{{ $value['intime'] }}">
                                                </td>
                                                <td class="outtime">
                                                    <input type="time" name="outtime" class="form-control"
                                                        value="{{ $value['outtime'] }}">
                                                </td>

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

            var all_attendance_table = $('#tables').DataTable({

                'columnDefs': [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }],
                'select': {
                    'style': 'multi'
                },
                'order': [
                    [1, 'asc']
                ],
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,



            });


            // var all_attendance_table = $('#table').DataTable()



            $("#preview").click(function() {




                var all_data = [];





                // all_attendance_table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                //     var data = this.node();

                //     // console.log(data);


                //     // // if ($(data).find('tr').prop('input')) {


                //     all_data.push($(data).find('.user-id').text());
                //     all_data.push($(data).find('.rider-name').text());
                //     all_data.push($(data).find('.mobile').text());
                //     all_data.push($(data).find('.area').text());
                //     all_data.push($(data).find("input[name='intime']").val());
                //     all_data.push($(data).find("input[name='outtime']").val());



                //     // var value = $("#tables tbody tr input[name='intime']").val();
                //     // all_data.push(value);

                //     // var value1 = $("#tables tbody tr input[name='outtime']").val();
                //     // all_data.push(value1);

                //     // var value2 = $("#tables tbody tr td select[name='status']").val();
                //     // all_data.push(value2);






                // });


                $('#tables tbody tr').each(function() {

                    var rider_id = $(this).find('.user-id').text();
                    all_data.push(rider_id);
                    var rider_name = $(this).find('.rider-name').text();
                    all_data.push(rider_name);
                    var mobile = $(this).find('.mobile').text();
                    all_data.push(mobile);
                    var area = $(this).find('.area').text();
                    all_data.push(area);

                    var status = $(this).find('.status').text();
                    all_data.push(status);


                    var intime = $(this).find("input[name='intime']").val();
                    all_data.push(intime);

                    var outtime = $(this).find("input[name='outtime']").val();
                    all_data.push(outtime);


                });


                console.log(all_data);

                $.ajax({
                    type: "POST",
                    url: "{{ route('rider.attendance.all.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        all_data: all_data,


                    },
                    success: function(data) {

                        window.location.href =
                            "{{ route('rider.attendance.index') }}";


                    }
                });







            });













        });
    </script>
@endsection
