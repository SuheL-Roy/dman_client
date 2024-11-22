@extends('Master.main')
@section('title')
    Shop
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4 p-0" style="padding:0px;">
                                    Shop<span class="table-project-n"></span> Table
                                </h1>
                                <div class="container col-lg-4">
                                    @if (session('success'))
                                        <div class="alert alert-dismissible alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('success') }}</strong>
                                        </div>
                                    @elseif(session('message'))
                                        <div class="alert alert-dismissible alert-info">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @elseif(session('danger'))
                                        <div class="alert alert-dismissible alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('danger') }}</strong>
                                        </div>
                                    @endif

                                </div>
                                <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                    data-toggle="modal" data-target="#PrimaryModalalert">Add Shop
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <div class="modal modal-adminpro-general default-popup-PrimaryModal fade" id="PrimaryModalalert"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('shop.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Add Shop Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Name <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="shop_name" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Phone <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="number" name="shop_phone" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Zone <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="shop_area" class="form-control" required>
                                                            <option value="">--- Select Zone ---</option>
                                                            @foreach ($coverage_area as $value)
                                                                <option value="{{ $value->name }}">{{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Address <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea name="shop_address" type="text" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Pickup Address <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea name="pickup_address" type="text" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Link
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="shop_link" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                            <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            id="InformationproModalhdbgcl" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="updatE">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Edit Shop Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input name="id" class="id" type="hidden" />
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Name <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="shop_name"
                                                            class="form-control shop_name" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Phone <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="number" name="shop_phone"
                                                            class="form-control shop_phone" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Area <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="shop_area" class="form-control shop_area" required>
                                                            <option value="">--- Select Zone ---</option>
                                                            @foreach ($coverage_area as $value)
                                                                <option value="{{ $value->name }}">{{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Address <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea name="shop_address" type="text" class="form-control shop_address" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Pickup Address <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea name="pickup_address" type="text" class="form-control pickup_address" required></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Shop Link
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="shop_link"
                                                            class="form-control shop_link" />
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true"
                                    data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                    data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="shop_name" data-editable="false">Shop Name</th>
                                            <th data-field="shop_phone" data-editable="false">Shop Phone</th>
                                            <th data-field="shop_area" data-editable="false">Shop Area</th>
                                            <th data-field="shop_address" data-editable="false">Shop Address</th>
                                            <th data-field="pickup_address" data-editable="false">Pickup Address</th>
                                            <th data-field="shop_link" data-editable="false">Shop Link</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->shop_name }}</td>
                                                <td>{{ $data->shop_phone }}</td>
                                                <td>{{ $data->shop_area }}</td>
                                                <td>{{ $data->shop_address }}</td>
                                                <td>{{ $data->pickup_address }}</td>
                                                <td>{{ $data->shop_link }}</td>
                                                <td>{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                <td class="datatable-ct">
                                                    <button type="button" value="{{ $data->id }}"
                                                        class="btn btn-primary ediT" data-toggle="modal"
                                                        data-target="#InformationproModalhdbgcl">
                                                        <i class="fa fa-edit"></i>Edit
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
        $(document).ready(function() {
            $('.ediT').on('click', function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('shop.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.shop_name').val(data[0]['shop_name']);
                        $('.shop_phone').val(data[0]['shop_phone']);
                        $('.shop_area').val(data[0]['shop_area']);
                        $('.shop_address').val(data[0]['shop_address']);
                        $('.pickup_address').val(data[0]['pickup_address']);
                        $('.shop_link').val(data[0]['shop_link']);

                    }
                });
            });
            $('#updatE').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('shop.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".id").val(),
                        'shop_name': $(".shop_name").val(),
                        'shop_phone': $(".shop_phone").val(),
                        'shop_area': $(".shop_area").val(),
                        'shop_address': $(".shop_address").val(),
                        'pickup_address': $(".pickup_address").val(),
                        'shop_link': $(".shop_link").val(),
                    },
                    success: function() {
                        $('#InformationproModalhdbgcl').modal('hide');
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Data Not Saved');
                    }
                });
            });
        });
        $('.deletE').on('click', function() {
            var id = $(this).data("id");
            $.ajax({
                url: "{{ route('shop.destroy') }}",
                type: 'GET',
                data: {
                    "id": id,
                },
                success: function() {
                    console.log("Data Deleted Successfully");
                    location.reload();
                }
            });
        });
    </script>
@endsection
