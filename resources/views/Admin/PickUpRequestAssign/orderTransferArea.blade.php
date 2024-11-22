@extends('Master.main')
@section('title')
    Order List
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
                                Order List <small> ( Transfer To Area ) </small>
                            </h1>
                            <div class="col-lg-2">
                                <select name="area" id="area" class="form-control" title="Select Area" required>
                                    <option value="">Select Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->area }}">{{ $area->area }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="container col-lg-3">
                                @if(session('message'))
                                    <div class="alert alert-dismissible alert-success" style="padding-top:5px; padding-bottom:5px; margin-top:0px; margin-bottom:0px; text-align:center;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ session('message') }}</strong>
                                    </div>      
                                @endif
                            </div>
                            <a href="{{ route('order.transfer.confirm.list') }}" style="float:right;"
                                class="btn btn-primary col-lg-2 Primary">Transfer Order
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <br><br>
                            <table class="table table-bordered tbl order-list" id="table">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="sl">SL.</th>
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        <th data-field="order_id" data-editable="false">Order ID</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="collection" data-editable="false">Collection</th>
                                        <th data-field="pickup_date" data-editable="false">Pickup Date</th>
                                        <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    
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
    $(document).ready(function () {
        $('#area').on('change', function () {
            var area = $(this).val();
            $.ajax(
            {
                url: '{{ route('get.order.area') }}',
                type: 'GET',
                data: { area : area },
                success: function (response){
                    $("tbody tr").remove();
                    $("table.order-list").append(response.orders_html);
                    
                    $('#table tr').each(function() {
                        $(this).find('.addOrder').on('click', function () {
                            var id = $(this).val();
                            console.log(id);
                            $.ajax(
                            {
                                url: 'transfer-add/' +id,
                                type: 'GET',
                                data: { id : id },
                                success: function (){
                                    console.log("Order Transfer Successfully");
                                }
                            });
                        });
                     });
                }
            });
        });
    });

    

    
</script>
@endsection