@extends('Master.main')
@section('title')
    Income Report Date Wise
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">


                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-12 form-group" style="padding:0px;">
                                    Income Report
                                </h1>
                                <form action="{{ route('Income.report.print') }}" method="get" class="col-lg-1"
                                    style="float:right;" target="_blank">
                                    @csrf

                                    <input type="hidden" name="income_type" value="{{ $income_type }}" />
                                    <input type="hidden" name="income_fors" value="{{ $income_for }}" />
                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" />
                                    <button type="submit" class="btn btn-primary" style="float:right;">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </form>
                                <form action="{{ route('Income.report') }}" method="get">
                                    @csrf
                                    <div class="col-lg-2">
                                        <select name="income_type" class="selectpicker form-control"
                                            title="Select Income Type" data-live-search="true">
                                            {{--  <option value="">Select Rider</option>  --}}
                                            @foreach ($income_types as $data)
                                                <option {{ $data->type_name == $income_type ? 'selected' : '' }}
                                                    value="{{ $data->type_name }}">{{ $data->type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-lg-2">
                                        <select name="income_for" class="selectpicker form-control"
                                            title="Select Income For" data-live-search="true">
                                            {{--  <option value="">Select Rider</option>  --}}
                                            @foreach ($merchant as $data)
                                                <option {{ $data->business_name == $income_for ? 'selected' : '' }}
                                                    value="{{ $data->business_name }}">{{ $data->business_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  <div class="col-lg-3"></div>  --}}
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">From:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control" style="padding-left: 7px;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label style="float:right;">To:</label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm" style="float:right;">Load
                                    </button>
                                </form>

                            </div>
                        </div>
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="date" data-editable="false">Date</th>
                                            <th data-field="time" data-editable="false">Voucher No</th>
                                            <th data-field="name" data-editable="false">Income Type</th>
                                            <th data-field="role" data-editable="false">Income For</th>
                                            <th data-field="mobile" data-editable="false">Amount</th>
                                            <th data-field="call_duration" data-editable="false">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @isset($datas)
                                            @foreach ($datas as $data)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->date }}</td>
                                                    <td>{{ $data->voucher_no }}</td>
                                                    <td>{{ $data->income_type }}</td>
                                                    <td>{{ $data->income_for }}</td>
                                                    <td>{{ $data->amount }}</td>
                                                    <td>{{ $data->details }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
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
