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
                                Order List <small> ( Pick Up Request Assign To Rider ) </small>
                            </h1>
                            <div class="container col-lg-4">
                                @if(session('message'))
                                <div class="alert alert-dismissible alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ session('message') }}</strong>
                                </div>  
                                @endif
                            </div>
                            {{-- @can('superAdmin') --}}
                            <a href="{{ route('request.assign.confirm_list') }}" style="float:right;"
                                class="btn btn-primary col-lg-2 Primary">PickUp Assign
                            </a>
                            {{-- @endcan --}}
                            {{--  <button type="button" class="btn btn-info Primary" style="float:right;" 
                                data-toggle="modal" data-target="#PrimaryModalalert">Assign
                            </button>  --}}
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form action="{{ route('request.assign.store') }}" method="POST">
                                @csrf
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#">
                                        <i class="fa fa-close"></i></a>
                                </div>
                                <div class="modal-header header-color-modal bg-color-1">
                                    <h4 class="modal-title">Assign Pick Up Request</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Rider <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <select name="rider" class="form-control" required>
                                                    <option>Select Rider</option>
                                                    @foreach ($rider as $data)
                                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning btn-sm" type="button"data-dismiss="modal">Close</button>
                                    <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                    <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <div id="InformationproModalhdbgcl" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header header-color-modal bg-color-1">
                                    <h4 class="modal-title">Assign Pick Up Request</h4>
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                    </div>
                                </div>
                            <form id="updatE">@csrf
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <input name="id" class="id" type="hidden"/>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Rider <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <select name="rider" class="form-control rider" required>
                                                    <option>Select Rider</option>
                                                    @foreach ($rider as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
                                    <button class="btn btn-success btn-sm" type="submit">Confirm</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

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
                                        <th data-field="customer_name" data-editable="false">Customer</th>
                                        <th data-field="type" data-editable="false">Type</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($order as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
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
                                        <td class="datatable-ct">
                                            {{-- <button type="button" value="{{ $data->id }}"
                                                class="btn btn-primary ediT btn-xs" 
                                                data-toggle="modal" 
                                                data-target="#InformationproModalhdbgcl">
                                                <i class="fa fa-edit"></i>
                                            </button> --}}
                                            <button class="addOrder btn btn-primary btn-xs" 
                                                value="{{ $data->tracking_id }}" type="button">
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </button>
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