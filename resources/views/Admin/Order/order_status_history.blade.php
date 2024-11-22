@extends('Master.main')
@section('title')
    Order Status History
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
                                Order Status History 
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

                    <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form action="{{ route('category.store') }}" method="POST">
                                @csrf
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#">
                                        <i class="fa fa-close"></i></a>
                                </div>
                                <div class="modal-header header-color-modal bg-color-1">
                                    <h4 class="modal-title">Add Category Info</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="name" class="form-control" required/>
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
                                    <h4 class="modal-title">Edit Category Info</h4>
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                    </div>
                                </div>
                            <form id="updatE">@csrf
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                <input name="id" class="id" type="hidden"/>
                                                <input type="text" class="name form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
                                    <button class="btn btn-success btn-sm" type="submit">Update</button>
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
                                        <th data-field="phone" data-editable="false">Customer Phone</th>
                                        <th data-field="pickup_date" data-editable="false">Pick Up Date</th>
                                        <th data-field="user_id" data-editable="false">User ID</th>
                                        <th data-field="status" data-editable="false">Status</th>
                                        <th data-field="created_at" data-editable="false">Created At</th>
                                        {{--  <th data-field="action">Action</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($data as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->tracking_id }}</td>
                                        <td>{{ $data->phone }}</td>
                                        <td>{{ $data->pickup_date }}</td>
                                        <td>{{ $data->user_id }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        {{--  <td class="datatable-ct">
                                            @can('admin')
                                            <button class="btn btn-danger deletE btn-xs"
                                                data-id="{{ $data->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            @endcan
                                            @if($data->status == "1")
                                                <a href="{{route('category.status',['id'=>$data->id])}}" 
                                                    class="btn btn-warning btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Category Status ??')">
                                                    <i class="fa fa-arrow-down" 
                                                    title="Change Category Status to Inactive ??"></i>
                                                </a>
                                            @elseif($data->status == "0")
                                                <a href="{{route('category.status',['id'=>$data->id])}}" 
                                                    class="btn btn-success btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Category Status ??')">
                                                    <i class="fa fa-arrow-up" 
                                                    title="Change Category Status to Active ??"></i>
                                                </a>
                                            @endif
                                        </td>  --}}
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
            $('.ediT').on('click', function () {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('category.edit') }}",
                    data: {id: id},
                    success: function (data) {
                        $('.id').val(data[0]['id']);
                        $('.name').val(data[0]['name']);
                    }
                });
            });
            $('#updatE').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('category.update') }}",
                    data: {
                        '_token'    : $('input[name=_token]').val(),
                        'id'        : $(".id").val(),
                        'name'      : $(".name").val(),
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
        $('.deletE').on('click', function () {
            var id = $(this).data("id");
            $.ajax(
            {
                url: "{{ route('category.destroy') }}",
                type: 'GET',
                data: { "id" : id },
                success: function (){
                    console.log("Data Deleted Successfully");
                    location.reload();
                }
            });
        });
    </script>

@endsection