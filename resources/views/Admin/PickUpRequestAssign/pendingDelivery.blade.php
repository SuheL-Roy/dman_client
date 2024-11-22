@extends('Master.main')
@section('title')
    Hold Order
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
                                Order List <small> ( Hold ) </small>
                            </h1>
                            <div class="container col-lg-7">
                                @if(session('message'))
                                <div class="alert alert-dismissible alert-info"
                                    style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ session('message') }}</strong>
                                </div>  
                                @endif
                            </div>
                            
                        </div>
                    </div>

                    

                    
                    {{-- <form class="" method="post" action="{{route('pending.delivery.index')}}">  
                        @csrf

                    <div class="col-lg-2">
                        <select name="status" class="form-control status" required>
                            <option value="">Select Status</option>
                            <option value="Hold Order" {{$status==['Hold Order']?"Selected":''}}>Hold Order</option>
                            <option value="Cancel Order" {{$status==['Cancel Order']?"Selected":''}}>Cancel Order</option>
                            <option value="Reschedule Order" {{$status==['Reschedule Order']?"Selected":''}}>Reschedule Order</option>
                         
                        </select>
                    </div>

                    <button type="submit" class="col-lg-1 btn btn-info btn-sm">
                        Load
                    </button>

                  </form> --}}

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
                                        <th data-field="sl">SL.</th>                                  
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                         {{--                <th data-field="order_id" data-editable="false">Order ID</th> --}}
                                        <th data-field="m_name" data-editable="false">M. Name</th>
                                        <th data-field="m_shop_name" data-editable="false">S. Name</th>
                                        <th data-field="m_phone" data-editable="false">S. Phone</th>
                                        <th data-field="m_address" data-editable="false">S. Address</th>
                                    
                                        <th data-field="customer_name" data-editable="false">C. Name</th>
                                        <th data-field="customer_mobile_no" data-editable="false">C. Phone</th>  
                                        <th data-field="customer_address" data-editable="false">C. Address</th> 

                                        <th data-field="type" data-editable="false">Type</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="status" data-editable="false">Status</th>
                                        <th data-field="action" data-editable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($order as $data)
                                    <tr>                                        
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->tracking_id }}</td>
                                     {{--    <td>{{ $data->order_id }}</td> --}}
                                        <td>{{ $data->business_name }}</td>
                                        <td>{{ $data->shop_name }}</td>
                                        <td>{{ $data->shop_phone }}</td>
                                        <td>{{ $data->shop_address }}</td>

                                        <td>{{ $data->customer_name }}</td>
                                        <td>{{ $data->customer_phone }}</td>
                                        <td>{{ $data->customer_address }}</td>

                                        <td>{{ $data->type }}</td>
                                        <td>{{ $data->area }}</td>
                                        <td>{{ $data->status }}</td>

                                        <td class="datatable-ct">
                                            @if ($data->status!='Partially Delivered')
                                            <a href="{{ route('order.move.delivery.assign',
                                            ['id'=>$data->tracking_id])}}" 
                                            class="btn btn-info btn-xs"
                                            onclick="return confirm('Are You Sure ??')"
                                            title="Reached In Destination Hub ??">
                                            <i class="fa fa-check-circle"></i>
                                            </a> 
                                            @endif
                                            
                                            <a href="{{ route('order.move.return',
                                                ['id'=>$data->tracking_id])}}" 
                                                class="btn btn-danger btn-xs"
                                                onclick="return confirm('Are You Sure ??')"
                                                title="Return To Head Office ??">
                                                <i class="fa fa-times-circle"></i>
                                            </a>
                                            
                                            @if ($data->status!='Partially Delivered')

                                            <a href="{{ route('order.move.reschedule',
                                            ['id'=>$data->tracking_id])}}" 
                                            class="btn btn-success btn-xs"
                                            onclick="return confirm('Are You Sure ??')"
                                            title="Move to Reschedule ??">
                                            <i class="fa fa-calendar"></i>
                                            </a>
                                            @endif
                                           
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
