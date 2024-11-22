@extends('Master.main')
@section('title')
    Manager List 
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-3" style="padding:0px;">Manager List</h1>
                            <div class="container col-lg-6">
                                @if(session('message'))
                                    <div class="alert alert-dismissible alert-success"
                                        style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ session('message') }}</strong>
                                    </div>      
                                @endif
                            </div>
                            @can('superAdmin')
                            <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;" 
                                data-toggle="modal" data-target="#PrimaryModalalert">Register Manager
                            </button>
                            @endcan
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form action="" method="POST">
                                @csrf
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#">
                                        <i class="fa fa-close"></i></a>
                                </div>
                                <div class="modal-header header-color-modal bg-color-1">
                                    <h4 class="modal-title">Register Manager Information</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" name="name" autocomplete="name"
                                                    class="form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Email <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <input id="email" type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror" 
                                                    value="{{ old('email') }}" required 
                                                    autocomplete="email" placeholder="Manager Email">
                                                @error('email')
                                                    <span class="invalid-feedback help-block small" role="alert">
                                                        <strong style="color:red;">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Mobile <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <input type="number" name="mobile"
                                                    class="form-control" required> 
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Password <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <input id="password" type="password" name="password" 
                                                    class="form-control @error('password') is-invalid @enderror" 
                                                    placeholder="Password at least 6 character" 
                                                    required autocomplete="new-password">
                                                @error('password')
                                                    <span class="invalid-feedback help-block small" role="alert">
                                                        <strong style="color:red;">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Confirm Password <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <input id="password-confirm" type="password" 
                                                    required placeholder="Confirm Password" 
                                                    name="password_confirmation" class="form-control" 
                                                    autocomplete="new-password">
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
                                    <h4 class="modal-title">Edit Employee Info</h4>
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                    </div>
                                </div>
                            <form id="updatE">@csrf
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <input type="hidden" class="id" name="id"/>
                                                <input type="text" name="name" required 
                                                    class="name form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Role <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <select name="role" class="form-control role" required>
                                                    <option value="Manager">Manager</option>
                                                    <option value="SalesMan">SalesMan</option>
                                                </select>
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
                                        {{--  <th data-field="id" data-editable="false">Employee ID</th>  --}}
                                        <th data-field="name" data-editable="false">Name</th>
                                        <th data-field="email" data-editable="false">Email</th>
                                        <th data-field="mobile" data-editable="false">Mobile</th>
                                        {{--  <th data-field="status" data-editable="false">Status</th>  --}}
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($manager as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        {{--  <td>E{{ $data->od }}{{ $data->id }}</td>  --}}
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        {{--  <td>
                                            @if($data->status == 1) Active
                                            @elseif($data->status == 0) Inactive
                                            @endif
                                        </td>  --}}
                                        <td class="datatable-ct">
                                            {{-- <button type="button" value="{{ $data->emp }}"
                                                class="btn btn-primary ediT btn-xs" data-toggle="modal" 
                                                data-target="#InformationproModalhdbgcl">
                                                <i class="fa fa-edit"></i>
                                            </button> --}}
                                            @if($data->status == 1)
                                                <a href="{{ route('employee.status',['id'=>$data->emp])}}" 
                                                    class="btn btn-warning btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Employee Status ??')">
                                                    <i class="fa fa-arrow-down" 
                                                    title="Change Employee Status to Inactive ??"></i>
                                                </a>
                                            @elseif($data->status == 0)
                                                <a href="{{ route('employee.status',['id'=>$data->emp])}}" 
                                                    class="btn btn-success btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Employee Status ??')">
                                                    <i class="fa fa-arrow-up" 
                                                    title="Change Employee Status to Active ??"></i>
                                                </a>
                                            @endif
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
        $('.ediT').on('click', function () {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('employee.edit') }}",
                data: { id: id  },
                success: function (data) {
                    $('.id').val(data[0]['id']);
                    $('.name').val(data[0]['name']);
                    $('.role').val(data[0]['role']);
                }
            });
        });
        $('#updatE').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('employee.update') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id'    : $(".id").val(),
                    'name'  : $(".name").val(),
                    'role'  : $(".role").val(),
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