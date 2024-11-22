@extends('Master.main')
@section('title')
Payment Requests
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
                                     Payment Requests <span class="table-project-n"></span> 
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
                              
                                {{--  <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;" 
                                data-toggle="modal" data-target="#PrimaryModalalert">Add Complain
                            </button>  --}}
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
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td></td>
                                                 
                                                @if ($data->status=='Submited')
                                                <td><b>{{ $i++ }}.</b></td>
                                                <td><b>{{ $data->date }}</b></td>
                                                <td><b>{{ $data->time }}</b></td>
                                                <td><b>{{ $data->name }}</b></td>
                                                <td><b>{{ $data->role=='activeMerchant'?'Mercahnt':'Call Center' }}</b></td>
                                                <td><b>{{ $data->mobile }}</b></td>
                                                <td><b>{{ $data->call_duration }}</b></td>
                                                <td><b>{{ $data->problem }}</b></td>
                                                <td><b>{{ $data->comment }}</b></td>
                                                <td><b>{{ $data->status }}</b></td>
                                                @else
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
                                                @endif
                                                
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
