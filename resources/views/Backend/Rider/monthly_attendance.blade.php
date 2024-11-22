@extends('Master.main')
@section('title')
    Monthly Attendance
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h6 class="col-lg-2" style="padding:0px; margin-right:20px;">
                                    Mothly Employee wise Attendance
                                </h6>

                                <form action="{{ route('rider.attendance.monthly.attendance') }}" method="get">
                                    @csrf
                                    <div class="col-lg-4" style="padding:0px;">

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">Employee :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select name="employee" class="selectpicker form-control"
                                                    title="Select Employee" data-style="btn-info" data-live-search="true">

                                                    <option value="">Select Employee</option>
                                                    @foreach ($Employee as $data)
                                                        <option value="{{ $data->name }}"
                                                            {{ $employee == $data->name ? 'Selected' : '' }}>
                                                            {{ $data->name }}
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <label style="float:right;">Date :</label>
                                            </div>
                                            <div class="col-lg-9">

                                                <input type="text" name="todate" value="{{ $todate }}"
                                                    class="form-control from" placeholder="Click to Select Month" required>

                                            </div>






                                        </div>
                                    </div>
                                    <button type="submit"class="btn btn-primary btn-sm Primary">Load</button>
                                </form>

                            </div>
                        </div>

                        <p>
                        <form action="{{ route('rider.attendance.monthly.attendance.print') }}" method="get"
                            class="col-lg-1" style="float:right;" target="_blank">
                            @csrf

                            <input type="hidden" name="employee" value="{{ $employee }}" />
                            <input type="hidden" name="todate" value="{{ $todate }}" />
                            <button type="submit" class="btn btn-primary" style="float:right;">
                                <i class="fa fa-print"></i>
                            </button>
                        </form>
                        </p>


                        <div class="clearfix">
                            <p>present = P , Absent = A ,Leave = L , Holiday = H ,Off Day = O</p>
                        </div>
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

                                            <th>SL</th>
                                            <th>Employee</th>
                                            <th>Designation</th>
                                            <!-- <th>ID</th> -->
                                            <!-- Log on to codeastro.com for more projects! -->
                                            @php

                                                /// if ($todate) {
                                                //  $today = \Carbon\Carbon::parse($todate)->format('Y-m-d');
                                                // } else {
                                                //     $today = today();
                                                // }
                                                if ($todate) {
                                                    $today1 = $todate;
                                                    $today = \Carbon\Carbon::parse($today1);
                                                } else {
                                                    $today = today();
                                                }
                                                //$today = today();

                                                $dates = [];

                                                for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                                    $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                                }

                                            @endphp
                                            @foreach ($dates as $key => $date)
                                                <th style="">


                                                    {{ $key + 1 }}

                                                </th>
                                            @endforeach
                                            <th>Total Present</th>
                                            <th>Total Absent</th>
                                            <th>Total Leave</th>
                                            <th>Total Late</th>

                                        </tr>


                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                            $j = 0;
                                        @endphp

                                        @foreach ($monthly_attendance as $key => $item)
                                            <tr>

                                                <td>{{ ++$j }}</td>
                                                <td class="user-id">{{ $item->name }}</td>
                                                <td class="rider-name">{{ $item->type }}</td>

                                                @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)
                                                    @php

                                                        $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');

                                                        $check_attd = \App\Attendance::query()
                                                            ->where('name', $item->name)
                                                            //->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                                            ->whereDate('created_at', $date_picker)
                                                            ->first();
                                                        $total_leave = \App\Attendance::query()
                                                            ->where('name', $item->name)
                                                            ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                                            ->where('status', 'Leave')
                                                            ->count();
                                                        $total_present = \App\Attendance::query()
                                                            ->where('name', $item->name)
                                                            ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                                            ->where('status', 'Present')
                                                            ->count();

                                                        $total_absent = \App\Attendance::query()
                                                            ->where('name', $item->name)
                                                            ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                                            ->where('status', 'Absent')
                                                            ->count();

                                                        $total_late = \App\Attendance::query()
                                                            ->where('name', $item->name)
                                                            ->whereMonth('created_at', '=', \Carbon\Carbon::parse($todate)->format('m'))
                                                            ->where('status', 'Late')
                                                            ->count();

                                                    @endphp


                                                    <td>

                                                        <div style="text-align: center; font-weight: bold;"
                                                            class="form-check form-check-inline ">

                                                            @if (isset($check_attd))
                                                                @if ($check_attd->status == 'Present')
                                                                    <i class="text-success">p</i>
                                                                @elseif($check_attd->status == 'Absent')
                                                                    <i class="text-danger">A</i>
                                                                @elseif($check_attd->status == 'Leave')
                                                                    <i class="text-danger">L</i>
                                                                @elseif($check_attd->status == 'Late')
                                                                    <i class="text-warning">LA</i>
                                                                @endif
                                                            @else
                                                                <i class=""></i>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endfor
                                                <td>{{ $total_present }}</td>
                                                <td>{{ $total_absent }}</td>
                                                <td>{{ $total_leave }}</td>
                                                <td>{{ $total_late }}</td>
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


    <script>
        $(document).ready(function() {
            var startDate = new Date();
            var fechaFin = new Date();
            var FromEndDate = new Date();
            var ToEndDate = new Date();




            $('.from').datepicker({
                autoclose: true,
                minViewMode: 1,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(selected) {
                startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                $('.to').datepicker('setStartDate', startDate);
            });

            $('.to').datepicker({
                autoclose: true,
                minViewMode: 1,
                format: 'mm/yyyy'
            }).on('changeDate', function(selected) {
                FromEndDate = new Date(selected.date.valueOf());
                FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                $('.from').datepicker('setEndDate', FromEndDate);
            });
        });
    </script>
@endsection
