@extends('Master.main')
@section('title')
  Scheduler
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
                                    Scheduler<span class="table-project-n"></span> Table
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

                                @php 
                                    Illuminate\Support\Facades\Session::forget('message'); 
                                @endphp

                                <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                    data-toggle="modal" data-target="#PrimaryModalalert">Add Scheduler
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('scheduler.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Add Schedule Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            Start Time<span class="table-project-n">*</span>
                                                        </label>
                                                  
                                                        <input type="time" name="s_time" class="form-control"
                                                            required />
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            End Time<span class="table-project-n">*</span>
                                                        </label>
                                                  
                                                        <input type="time" name="e_time" class="form-control"
                                                            required />
                                                    </div>
                                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            From<span class="table-project-n">*</span>
                                                        </label>                                                  
                                                        <input type="date" name="f_date" class="form-control"
                                                            required />
                                                    </div>

                                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            To<span class="table-project-n">*</span>
                                                        </label>                                                  
                                                        <input type="date" name="t_date" class="form-control"
                                                            required />
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
                                        <h4 class="modal-title">Edit Schedule</h4>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i
                                                    class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <form id="updatE">@csrf
                                        <div class="modal-body">
                                            <input name="id" class="id" type="hidden" />

                                      <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            Start Time<span class="table-project-n">*</span>
                                                        </label>
                                                  
                                                        <input type="time" name="s_time" class="form-control s_time"
                                                            required />
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            End Time<span class="table-project-n">*</span>
                                                        </label>
                                                  
                                                        <input type="time" name="e_time" class="form-control e_time"
                                                            required />
                                                    </div>
                                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            From<span class="table-project-n">*</span>
                                                        </label>                                               
                                                        <input type="date" name="f_date" class="form-control f_date"
                                                            required />
                                                    </div>

                                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <label class="login2 pull-left pull-left-pro">
                                                            To<span class="table-project-n">*</span>
                                                        </label>                                                    
                                                        <input type="date" name="t_date" class="form-control t_date"
                                                            required />
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
                                           
                                            <th data-field="sl">SL.</th>
                                            <th data-field="f_date" data-editable="false">From Date</th>
                                            <th data-field="t_date" data-editable="false">To Date</th>
                                             <th data-field="time" data-editable="false">Time</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $value)
                                            <tr>
                                                
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ \Carbon\Carbon::parse($value->f_date)->format('d-m-Y')}}</td>
                                                <td>{{ \Carbon\Carbon::parse($value->t_date)->format('d-m-Y')}}</td>
                                                 <td>{{ \Carbon\Carbon::parse($value->s_time)->format('g:i A')}} - {{ \Carbon\Carbon::parse($value->e_time)->format('g:i A')}}</td>
                                                <td>
                                                    @if ($value->status == 1)
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif
                                                </td>
                                                <td class="datatable-ct w-25" style="width:25%;">

                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" value="{{ $value->id }}"
                                                            class="btn btn-primary ediT " data-toggle="modal"
                                                            data-target="#InformationproModalhdbgcl">
                                                            <i class="fa fa-edit"></i>
                                                            Edit
                                                        </button>
                                                        @if ($value->status == '1')
                                                            <a class="btn btn-success"
                                                                href="{{ route('scheduler.status', ['id' => $value->id]) }}"
                                                                class="btn"
                                                                onclick="return confirm('Are You Sure You Want To Inactive Status ??')">
                                                                Active
                                                                
                                                            </a>
                                                        @elseif($value->status == '0')
                                                            <a class="btn btn-warning"
                                                                href="{{ route('scheduler.status', ['id' => $value->id]) }}"
                                                                class="btn"
                                                                onclick="return confirm('Are You Sure You Want To active Status ??')">
                                                                Inactive
                                                            </a>
                                                        @endif
                                                         <a class="btn btn-danger"
                                                                href="{{ route('scheduler.destroy', ['id' => $value->id]) }}"                                                               
                                                                onclick="return confirm('Are You Sure You Want To delete this schedule ??')">
                                                               <i class="fa fa-trash-o"></i>
                                                            </a>

                                                            
                                                    </div>
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
                    url: "{{ route('scheduler.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.s_time').val(data[0]['s_time']);
                        $('.e_time').val(data[0]['e_time']);
                        $('.f_date').val(data[0]['f_date']);
                        $('.t_date').val(data[0]['t_date']);
                    }
                });
            });
            $('#updatE').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('scheduler.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".id").val(),
                        's_time': $(".s_time").val(),
                        'e_time': $(".e_time").val(),
                        'f_date': $(".f_date").val(),
                        't_date': $(".t_date").val(),
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
                url: "{{ route('business.type.destroy') }}",
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
