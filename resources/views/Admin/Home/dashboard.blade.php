@extends('Master.main')
@section('title')
Ticket
@endsection
@section('content')
    <style>
        .btn-success {
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        button:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }

        a:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }
    </style>
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">
                                    Reveived Tickets <span class="table-project-n"></span> List
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
                                <a href="{{ route('complain.create') }}" class="btn btn-success col-lg-2"
                                    style="float:right;">Add Ticket
                                </a>
                                {{--  <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;" 
                                data-toggle="modal" data-target="#PrimaryModalalert">Add Complain
                            </button>  --}}
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('complain.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Add Ticket Info</h4>
                                        </div>
                                        <div class="modal-body" style="padding-top: 15px; padding-bottom:0px;">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Name <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="name" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Mobile <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="number" name="mobile" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Area <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="area" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Date <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="date" name="date" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Time <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="time" name="time" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Call Duration<span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="call_duration" class="form-control"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Ticket Type <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <textarea type="text" name="problem" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            User Type <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select name="user_type" class="form-control" required>
                                                            <option value=""> Select User Type </option>
                                                            <option value="Merchant">Merchant</option>
                                                            <option value="Customer">Customer</option>
                                                            <option value="Agent">Agent</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Status <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select name="status" class="form-control" required>
                                                            <option value=""> Select Status </option>
                                                            <option value="Received">Received</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Solved">Solved</option>
                                                            <option value="Cancel">Cancel</option>
                                                        </select>
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

                        <div id="InformationproModalhdbgcl"
                            class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-1">
                                        <h4 class="modal-title">Edit Ticket Info</h4>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i
                                                    class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <form id="updatE">@csrf
                                        <div class="modal-body" style="padding-top:15px; padding-bottom:0px;">
                                            <input name="id" class="id" type="hidden" />
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Name
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                        <input type="text" class="form-control name" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Mobile
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                        <input type="number" class="form-control mobile" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Date
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6"
                                                        style="padding:0px; padding-left:15px;">
                                                        <input type="date" class="form-control date"
                                                            style="padding:7px;" readonly />
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Time
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                                        <input type="time" class="form-control time"
                                                            style="padding-left:10px;" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            {{--  <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <label class=" ">
                                                    Call Duration
                                                </label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-6">
                                                <input type="text" class="form-control call" readonly/>
                                            </div>
                                        </div>
                                    </div>  --}}
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Problem
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                        <textarea class="form-control problem" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Comment
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                        <textarea class="form-control comment" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Status
                                                        </label>
                                                    </div>
                                                    <div class="btn-group col-lg-10 col-md-10 col-sm-10 col-xs-12"
                                                        data-toggle="buttons">
                                                        <select class="form-control stat" required>
                                                            <option value="Received">Received</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Solved">Solved</option>
                                                            <option value="Cancel">Cancel</option>
                                                        </select>
                                                        {{--  <label class="btn btn-info act ive form-check-label">
                                                    <input class="stat form-check-input" type="radio" 
                                                        name="stat" value="Received" autocomplete="off">Received 
                                                </label>
                                                <label class="btn btn-info form-check-label">
                                                    <input class="stat form-check-input" type="radio" 
                                                        name="stat" value="Pending" autocomplete="off">Pending
                                                </label>
                                                <label class="btn btn-info form-check-label">
                                                    <input class="stat form-check-input" type="radio" 
                                                        name="stat" value="Solved" autocomplete="off">Solved
                                                </label>
                                                <label class="btn btn-info form-check-label">
                                                    <input class="stat form-check-input" type="radio" 
                                                        name="stat" value="Cancel" autocomplete="off">Cancel
                                                </label>  --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="padding-right:70px;">
                                            <button class="btn btn-warning" data-dismiss="modal">Close</button>
                                            <button class="btn btn-success" type="submit">Update</button>
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
                                            <th data-field="date" data-editable="false">Date</th>
                                            <th data-field="time" data-editable="false">Time</th>
                                            <th data-field="name" data-editable="false">Name</th>
                                            <th data-field="Rr" data-editable="false">User Role</th>
                                            <th data-field="mobile" data-editable="false">Mobile</th>
                                            <th data-field="call_duration" data-editable="false">Call Duration</th>
                                            {{--  <th data-field="role" data-editable="false">User Role</th>  --}}
                                            <th data-field="problem" data-editable="false">Ticket Type</th>
                                            <th data-field="rr" data-editable="false">Comment</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            @can('superAdmin')
                                                <th data-field="action">Action</th>
                                            @endcan
                                            @can('activeManager')
                                                <th data-field="action">Action</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->date }}</td>
                                                <td>{{ $data->time }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->role=='activeMerchant'?'Mercahnt':'Call Center' }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->call_duration }}</td>
                                                <td>{{ $data->problem }}</td>
                                                <td>{{ $data->comment }}</td>
                                                <td>{{ $data->status }}</td>
                                                @can('superAdmin')
                                                    <td class="datatable-ct">
                                                        <button type="button" value="{{ $data->id }}"
                                                            class="btn btn-primary ediT" data-toggle="modal"
                                                            data-target="#InformationproModalhdbgcl">
                                                            <i class="fa fa-edit"></i>
                                                            Edit
                                                        </button>
                                                        {{--  <button class="btn btn-danger deletE btn-xs"
                                                data-id="{{ $data->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </button>  --}}
                                                        {{--  @if ($data->status == '1')
                                                <a href="{{route('complain.status',['id'=>$data->id])}}" 
                                                    class="btn btn-warning btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Complain Status ??')">
                                                    <i class="fa fa-arrow-down" 
                                                    title="Change Complain Status to Inactive ??"></i>
                                                </a>
                                            @elseif($data->status == "0")
                                                <a href="{{route('complain.status',['id'=>$data->id])}}" 
                                                    class="btn btn-success btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Complain Status ??')">
                                                    <i class="fa fa-arrow-up" 
                                                    title="Change Complain Status to Active ??"></i>
                                                </a>
                                            @endif  --}}
                                                    </td>
                                                @endcan
                                                @can('activeManager')
                                                    <td class="datatable-ct">
                                                        <button type="button" value="{{ $data->id }}"
                                                            class="btn btn-primary ediT" data-toggle="modal"
                                                            data-target="#InformationproModalhdbgcl">
                                                            <i class="fa fa-edit"></i>
                                                            Edit
                                                        </button>
                                                    </td>
                                                @endcan
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
                    url: "{{ route('complain.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.name').val(data[0]['name']);
                        $('.mobile').val(data[0]['mobile']);
                        $('.area').val(data[0]['area']);
                        $('.date').val(data[0]['date']);
                        $('.time').val(data[0]['time']);
                        $('.call').val(data[0]['call_duration']);
                        $('.user_type').val(data[0]['user_type']);
                        $('.problem').val(data[0]['problem']);
                        $('.comment').val(data[0]['comment']);
                        $('.stat').val(data[0]['status']);
                        {{--  $('input[name=stat]:checked', '#updatE').val(data[0]['status'])  --}}
                        {{--  $('.stat:checked').val('status');  --}}
                        {{--  $('input[type=radio]:checked').val(data[0]['status']);  --}}
                    }
                });
            });
            $('#updatE').on('submit', function(e) {
               
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('complain.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".id").val(),
                        'status': $(".stat").val(),
                    },
                    success: function() {
                        $('#InformationproModalhdbgcl').modal('hide');
                        location.reload();
                    },
                    error: function(error) {
                        $('#InformationproModalhdbgcl').modal('hide');
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
