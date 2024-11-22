@extends('Master.main')
@section('title')
    PickUp Request Assign Confoirmation
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
                                Order List <small> ( PickUp Request Assign Confoirmation) </small>
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
                            <a class="btn btn-warning col-lg-1" href="{{ route('request.assign.pickup') }}"
                                style="float:right;">Back</a>
                           
                           
                            
                        </div>
                    </div>
                       
               
                <form class="" method="post" action="{{route('request.assign.confirm.pickUP')}}">   
                   @csrf  

               
                    <div class="col-lg-2">
                        <select name="rider" class="form-control" required>
                            <option value="">Select Rider</option>
                            @foreach ($user as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success col-lg-1" style="float:right;">Confirm
                    </button>
                         
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
                                            <!-- <th data-field="state" data-checkbox="true"></th> -->
                                            <th data-field="sl">SL.</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="order_id" data-editable="false">Order ID</th>
                                            <th data-field="area" data-editable="false">Area</th>
                                            <th data-field="collection" data-editable="false">Collection</th>
                                            {{--  <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>  --}}
                                            <th data-field="pickup_date" data-editable="false">Pickup Date</th>
                                            <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;?>
                                        @if($tracking_id)
                                        @foreach ($tracking_id as $id)
                                        @php
                                            $data =  App\Admin\Order::where('tracking_id',$id)->where('status','PickUp Request')->first();
                                        @endphp
                                         @if($data)  
                                        <tr>
                                            <td><input type="checkbox" value="{{ $data->tracking_id }}" name="tracking_ids[]"/></td>
                                            <!-- <td>{{ $i++ }}.</td> -->
                                            <td>{{ $data->tracking_id }}</td>
                                            <td>{{ $data->order_id }}</td>
                                            <td>{{ $data->area }}</td>
                                            <td>{{ $data->collection }}</td>
                                            {{--  <td>{{ $data->merchant_pay }}</td>  --}}
                                            <td>{{ $data->pickup_date }}</td>
                                            <td>{{ $data->pickup_time }}</td>
                                       
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </form>
                     
                </div>
            </div>
        </div>
    </div>
</div>

@endsection