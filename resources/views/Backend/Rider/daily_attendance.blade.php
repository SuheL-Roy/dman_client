@extends('Master.main')
@section('title')
    Daily Attendance
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
                                    Daily Attendance
                                </h1>

                                <form action="{{ route('rider.attendance.daily.attendance') }}" method="get">
                                    @csrf
                                    <div class="col-lg-4" style="padding:0px;">

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">Employee :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select name="employee" class="selectpicker form-control"
                                                    title="Select Employee" data-style="btn-info" data-live-search="true">
                                                    <option value="">Select Eemployee</option>
                                                    @foreach ($Employee as $data)
                                                        <option value="{{ $data->name }}"
                                                            {{ $employee == $data->name ? 'Selected' : '' }}>
                                                            {{ $data->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <label style="float:right;">Select Date :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control"
                                                    name="todate" required />
                                            </div>

                                        </div>
                                    </div>
                                    <button type="submit"class="btn btn-primary btn-sm Primary">Load</button>

                                </form>

                                <form action="{{ route('rider.attendance.daily.attendance.print') }}" method="get"
                                    class="col-lg-1" style="float:right;" target="_blank">
                                    @csrf

                                    <input type="hidden" name="employee" value="{{ $employee }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" />
                                    <button type="submit" class="btn btn-primary" style="float:right;">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </form>
                            </div>
                        </div>




                        <div class="clearfix">

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
                                            {{-- <th></th> --}}
                                            <th data-field="sl">SL.</th>
                                            <th data-field="m_name" data-editable="false">Employee No</th>
                                            <th data-field="s_phone" data-editable="false">Employee Name</th>
                                            <th data-field="s_phone1" data-editable="false">Designation</th>
                                            <th data-field="s_phone2" data-editable="false">Mobile</th>
                                            <th data-field="s_phone3" data-editable="false">Branch</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th>In time</th>
                                            <th>Out Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                            $j = 0;
                                        @endphp

                                        @foreach ($data2 as $item)
                                            <tr>

                                                <td>{{ ++$j }}</td>
                                                <td class="user-id">{{ $item->user_id }}</td>
                                                <td class="rider-name">{{ $item->name }}</td>
                                                <td class="mobile">{{ $item->type }}</td>
                                                <td class="mobile">{{ $item->mobile }}</td>
                                                <td class="area">{{ $item->area }}</td>
                                                <td class="area">{{ $item->status }}</td>

                                                @if ($item->in_time == null)
                                                    <td style="text-align: center;">-----</td>
                                                @else
                                                    <td style="width: 150px;">
                                                        {{ \Carbon\Carbon::parse($item->in_time)->format('h:i A') }}</td>
                                                @endif


                                                @if ($item->out_time == null)
                                                    <td style="text-align: center;">-----</td>
                                                @else
                                                    <td style="width: 150px;">
                                                        {{ \Carbon\Carbon::parse($item->out_time)->format('h:i A') }}</td>
                                                @endif
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
@endsection
