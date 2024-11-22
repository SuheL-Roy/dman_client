@extends('Master.main')
@section('title')
    Pick Up Request Assign
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-5" style="padding:0px;">
                                Pick Up Request<small> ( Pick Up Request Assign To Rider ) </small>
                            </h1>
                            <div class="container col-lg-4">
                                @if(session('message'))
                                <div class="alert alert-dismissible alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ session('message') }}</strong>
                                </div>  
                                @endif
                            </div>
                            
                          
                        
                        </div>
                    </div>
                    <div class="clearfix"></div>

               
                <form class="" method="post" action="{{route('request.assign.pickUP.confirm')}}">  
                    @csrf                 
                        <button type="submit" class="btn btn-primary" style="float: right">
                           PickUp Assign
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
                                            <th data-field="merchant" data-editable="false">Merchant</th>
                                            <th data-field="customer_name" data-editable="false">Customer</th>
                                            <th data-field="type" data-editable="false">Type</th>
                                            <th data-field="area" data-editable="false">Area</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;?>
                                        
                                        @foreach ($order as $data)
                                        <tr>
                                            <td><input type="checkbox" value="{{ $data->tracking_id }}" name="tracking_ids[]"/></td>
                                            <!-- <td>{{ $i++ }}.</td> -->
                                            <td>{{ $data->tracking_id }}</td>
                                            <td>{{ $data->order_id }}</td>
                                            <td>{{ $data->merchant }}</td>
                                            <td>{{ $data->customer_name }}</td>
                                            <td>
                                                @if ($data->type == 1)
                                                    Urgent
                                                @elseif ($data->type == 0)
                                                    Regular
                                                @endif
                                            </td>
                                            <td>{{ $data->area }}</td>
                                         
                                        </tr>
                                        @endforeach
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

<script>
    $(document).ready(function () {
        $('.addOrder').on('click', function () {
            var id = $(this).val();
            $.ajax(
            {
                url: '-add/' +id,
                type: 'GET',
                data: { id : id },
                success: function ()
                {
                    console.log("PickUp Request Assigned");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.ediT').on('click', function () {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('request.assign.edit') }}",
                data: {id: id},
                success: function (data) {
                    $('.id').val(data[0]['tracking_id']);
                }
            });
        });
        $('#updatE').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('request.assign.update') }}",
                data: {
                    '_token'        : $('input[name=_token]').val(),
                    'tracking_id'   : $(".id").val(),
                    'rider'         : $(".rider").val(),
                },
                success: function () {
                    $('#InformationproModalhdbgcl').modal('hide');
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Data Not Saved');
                }
            });
        });
    });
</script>

@endsection