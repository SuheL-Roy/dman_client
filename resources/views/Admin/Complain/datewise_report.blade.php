@extends('Master.main')
@section('title')
Ticket Report Date Wise
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-3" style="padding:0px;">
                                Ticket Report <small>( Date Wise )</small>
                            </h1>
                            <form action="{{ route('complain.report') }}" method="get">
                                {{ csrf_field() }}
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label style="float:right;">From :</label>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="date" name="fromdate" required
                                                value="{{ $fromdate }}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label style="float:right;">To :</label>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="date" value="{{ $todate }}" 
                                                class="form-control" name="todate" required/>
                                        </div>
                                        
                                    </div>
                                </div>
                                <button type="submit"class="btn btn-success  col-lg-1">Load</button>
                            </form>
                            <div class="col-lg-2">
                                <form action="{{ route('complain.datewise.print') }}" method="get" target="_blank"> 
                                @csrf
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}"/>
                                <input type="hidden" name="todate" value="{{ $todate }}"/>
                                <button type="submit" class="btn btn-primary " style="float:right;">
                                    <i class="fa fa-print"> Print</i>
                                </button>
                            </form>
                            </button> </div>
                            
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
                            <table id="table" data-toggle="table" data-pagination="true" 
                                    data-search="true" data-show-columns="true" 
                                    data-show-pagination-switch="true" data-show-refresh="true" 
                                    data-key-events="true" data-show-toggle="true" 
                                    data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" 
                                    data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="sl">SL.</th>
                                        <th data-field="date" data-editable="false">Date</th>
                                        <th data-field="time" data-editable="false">Time</th>
                                        <th data-field="name" data-editable="false">Name</th>
                                        <th data-field="role" data-editable="false">User Role</th>
                                        <th data-field="mobile" data-editable="false">Mobile</th>
                                        <th data-field="call_duration" data-editable="false">Call Duration</th>
                                        <th data-field="problem" data-editable="false">Problem</th>
                                        <th data-field="comment" data-editable="false">Comment</th>
                                        <th data-field="status" data-editable="false">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($complain as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->time }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->role=='activeMerchant'?'Mercahnt':'Call Center' }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        <td>{{ $data->call_duration }}</td>
                                        <td>{{ $data->problem }}</td>
                                        <td>{{ $data->comment }}</td>
                                        <td>{{ $data->status }}</td>
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