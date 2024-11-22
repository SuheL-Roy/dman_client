@extends('Master.main')
@section('title')
    Delivered Report
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
                            Delivered Report <small>
                                    @if ($route == 'order.report.rider.today.delivered') 
                                   ( Daily )
                                    @endif
                                    @if ($route == 'order.report.rider.monthly.delivered') 
                                   ( Monthly )
                                    @endif
                                    
                                    </small>
                            </h1>
                           
                            {{--  <form action="{{ route('order.report.datewise.print') }}" method="get"
                                class="col-lg-1" style="float:right;" target="_blank"> 
                                @csrf
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}"/>
                                <input type="hidden" name="todate" value="{{ $todate }}"/>
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="float:right;">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>  --}}
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
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        <th data-field="customer_name" data-editable="false">Customer Name</th>
                                        <th data-field="colection_phone" data-editable="false">Customer Phone</th>
                                         <th data-field="customer_address" data-editable="false">Customer Address</th>
                                           <th data-field="collect" data-editable="false">Collected</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($data as $value)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $value->tracking_id }}</td>
                                        <td>{{ $value->customer_name }}</td>
                                        <td>{{ $value->customer_phone }}</td>
                                        <td>{{ $value->customer_address }}</td>
                                        <td>{{ $value->collect }}</td>


                                   
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                   <tr>
                                        <td colspan="5"></td>
                                        
                                       
                                    </tr>
                                 
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
