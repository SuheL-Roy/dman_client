@extends('Master.main')
@section('title')
    PickUp Request List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">PickUp Request List</h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>







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
                                            <th data-field="name1" data-editable="false">Create Date</th>
                                            <th data-field="name" data-editable="false">Merchant Name</th>
                                            <th data-field="voucher" data-editable="false">PickuP Address</th>
                                            <th data-field="email" data-editable="false">Note</th>
                                            <th data-field="mobile" data-editable="false">Estimated Parcel</th>
                                            @if (Auth::user()->role == 1)
                                                <th data-field="mobile1" data-editable="false">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($pick_up_list as $data)
                                            <tr>
                                                {{-- <td>{{ $data->created_at }}</td> --}}
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('Y-m-d h:i A') }}
                                                </td>
                                                <td>{{ $data->business_name }}</td>
                                                <td>{{ $data->pickup_address }}</td>
                                                <td>{{ $data->note }}</td>
                                                <td>{{ $data->estimate_parcel }}</td>
                                                @if (Auth::user()->role == 1)
                                                    <td sty class="datatable-ct">


                                                        <a style="font-size: 12px;" class="btn btn-danger"
                                                            href="{{ route('pickup_destroy', ['id' => $data->id]) }}"
                                                            onclick="return confirm('Are You Sure You Want To Delete ??')">

                                                            <i class="fa fa-trash"></i>
                                                        </a>




                                                    </td>
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
