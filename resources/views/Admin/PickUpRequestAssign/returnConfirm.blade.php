@extends('Master.main')
@section('title')
    Order Return To Merchant Confirmation
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-4" style="padding:0px;">
                                Order Return <small> ( To Merchant Confirmation ) </small>
                            </h1>
                            <div class="container col-lg-4">
                            @if(session('message'))
                                <div class="alert alert-dismissible alert-success" style="padding-top:5px; 
                                    padding-bottom:5px; margin-top:0px; margin-bottom:0px; text-align:center;">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ session('message') }}</strong>
                                </div>      
                            @endif
                            </div>
                            <form action="{{ route('order.return.rider.save') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="col-lg-2">
                                    <select name="rider" class="form-control" required>
                                        <option value="">Select Rider</option>
                                        @foreach ($user as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success col-lg-1" 
                                    style="float:right;">Confirm
                                </button>
                            </form>
                            <a class="btn btn-warning col-lg-1" href="{{ route('order.return.merchant') }}"
                                style="float:right;">Back</a>
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
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        <th data-field="order_id" data-editable="false">Order ID</th>
                                        <th data-field="merchant" data-editable="false">Merchant</th>
                                        <th data-field="mobile" data-editable="false">Mobile</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="collection" data-editable="false">Collection</th>
                                        <th data-field="return" data-editable="false">Return Charge</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach (Cart::getContent() as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->attributes->merchant }}</td>
                                        <td>{{ $data->attributes->mobile }}</td>
                                        <td>{{ $data->attributes->area }}</td>
                                        <td>{{ $data->attributes->collection }}</td>
                                        <td>{{ $data->attributes->return }}</td>
                                        <td>
                                            <a class="btn btn-danger btn-xs" 
                                                href="{{ route('order.return.rider.remove',['id'=>$data->id]) }}"
                                                onclick="return confirm('You want to Remove Assigned Order Return ??');">
                                                <i class="fa fa-remove"></i>
                                            </a>
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

@endsection