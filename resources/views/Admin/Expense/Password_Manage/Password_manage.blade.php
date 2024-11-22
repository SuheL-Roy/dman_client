@extends('Master.main')
@section('title')
    Password Manage
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Password Manage List</h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                @can('superAdmin')
                                    {{-- <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                        data-toggle="modal" data-target="#PrimaryModalalert"> Expense Type
                                    </button> --}}
                                @endcan
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('Expense.ExpenseType') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title"> Expense Type Information</h4>
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
                                                            class="form-control" placeholder="Expense Name" required />
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

                        <div id="EditModal" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('shop.merchant.update_password') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">Change Password</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            New Password <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="hidden" class="id" name="id">
                                                        <input type="password" name="password" autocomplete="name"
                                                            id="edit_password" class="form-control"
                                                            placeholder="New Password at-least 6 Character" required />
                                                        {{-- @error('password')
                                                            <span class="invalid-feedback help-block small" role="alert">
                                                                <strong style="color:red;">{{ $message }}</strong>
                                                            </span>
                                                        @enderror --}}
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="form-group-inner">

                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Confirm New Password <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="hidden" class="id" name="id">
                                                        <input type="password" name="password_confirmation"
                                                            autocomplete="name" id="edit_confirm_password"
                                                            class="form-control name" placeholder="Re-write New Password"
                                                            required />
                                                        <span id="password-mismatch-message"
                                                            class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                            <button class="btn btn-success btn-sm edit_submit"
                                                type="submit">Update</button>
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
                                            {{--  <th data-field="id" data-editable="false">Employee ID</th>  --}}
                                            <th data-field="name" data-editable="false">Name</th>
                                            <th data-field="email" data-editable="false">Email</th>
                                            <th data-field="phone" data-editable="false">Phone</th>
                                            <th data-field="role" data-editable="false">Role</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($users as $key => $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}</td>

                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                @if ($data->role == 4)
                                                    <td>Manager</td>
                                                @elseif($data->role == 5)
                                                    <td>Inactive Manager</td>
                                                @elseif($data->role == 6)
                                                    <td>Accounts</td>
                                                @elseif($data->role == 7)
                                                    <td>Inactive Accounts</td>
                                                @elseif($data->role == 8)
                                                    <td>Agent</td>
                                                @elseif($data->role == 9)
                                                    <td>Inactive Agent</td>
                                                @elseif($data->role == 10)
                                                    <td>Rider</td>
                                                @elseif($data->role == 11)
                                                    <td>Inactive Rider</td>
                                                @elseif($data->role == 12)
                                                    <td>Merchant</td>
                                                @elseif($data->role == 13)
                                                    <td>Inactive Merchant</td>
                                                @elseif($data->role == 14)
                                                    <td>Employee</td>
                                                @elseif($data->role == 15)
                                                    <td>Inactive Employee</td>
                                                @elseif($data->role == 16)
                                                    <td>CallCenter</td>
                                                @elseif($data->role == 17)
                                                    <td>Inactive CallCenter</td>
                                                @endif




                                                <td class="datatable-ct">
                                                    <button style="font-size: 18px;" type="button"
                                                        value="{{ $data->id }}" class="btn btn-success ediT btn-xs"
                                                        data-toggle="modal" data-target="#EditModal">
                                                        {{-- <i class="fa fa-edit"></i> --}}
                                                        Change Password
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



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            // Listen for changes in the password fields
            $('#edit_password, #edit_confirm_password').on('input', function() {
                var password = $('#edit_password').val();
                var confirmPassword = $('#edit_confirm_password').val();

                // Check if passwords match
                if (password === confirmPassword) {
                    $('#edit_confirm_password').removeClass('is-invalid');
                    $('#password-mismatch-message').text('').hide();
                    $('.edit_submit').prop('disabled', false);
                } else {
                    $('#edit_confirm_password').addClass('is-invalid');
                    $('#password-mismatch-message').text('Confirmed passwords do not match').css('color',
                            'red')
                        .show();
                    $('.edit_submit').prop('disabled', true);
                }
            });

            // Submit the form only when passwords match
            $('.edit_submit').on('click', function(e) {
                var password = $('#edit_password').val();
                var confirmPassword = $('#edit_confirm_password').val();

                // Check if passwords match
                if (password !== confirmPassword) {
                    // Prevent form submission if passwords don't match
                    e.preventDefault();
                    $('#edit_confirm_password').addClass('is-invalid');
                    $('#password-mismatch-message').text('Confirmed passwords do not match').css('color',
                        'red').show();
                    $('.edit_submit').prop('disabled', true);
                }
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            // Listen for changes in the password fields
            $('#edit_password, #edit_confirm_password').on('input', function() {
                var password = $('#edit_password').val();
                var confirmPassword = $('#edit_confirm_password').val();

                // Check if passwords meet the minimum length
                var isLengthValid = password.length >= 6 && confirmPassword.length >= 6;

                // Check if passwords match and meet the minimum length
                if (password === confirmPassword && isLengthValid) {
                    $('#edit_confirm_password').removeClass('is-invalid');
                    $('#password-mismatch-message').text('').hide();
                    $('.edit_submit').prop('disabled', false);
                } else {
                    $('#edit_confirm_password').addClass('is-invalid');
                    if (!isLengthValid) {
                        $('#password-mismatch-message').text('Passwords must be at least 6 characters').css(
                                'color',
                                'red')
                            .show();
                    } else {
                        $('#password-mismatch-message').text('Confirmed passwords do not match').css(
                                'color',
                                'red')
                            .show();
                    }
                    $('.edit_submit').prop('disabled', true);
                }
            });

            // Submit the form only when passwords match and meet the minimum length
            $('.edit_submit').on('click', function(e) {
                var password = $('#edit_password').val();
                var confirmPassword = $('#edit_confirm_password').val();

                // Check if passwords match and meet the minimum length
                if (password !== confirmPassword || password.length < 6 || confirmPassword.length < 6) {
                    // Prevent form submission if passwords don't match or don't meet the minimum length
                    e.preventDefault();
                    $('#edit_confirm_password').addClass('is-invalid');
                    if (password.length < 6 || confirmPassword.length < 6) {
                        $('#password-mismatch-message').text('Passwords must be at least 6 characters').css(
                            'color',
                            'red').show();
                    } else {
                        $('#password-mismatch-message').text('Confirmed passwords do not match').css(
                            'color',
                            'red').show();
                    }
                    $('.edit_submit').prop('disabled', true);
                }
            });
        });
    </script>


    </script>


    <script>
        // $(document).ready(function() {
        // $('.ediT').on('click', function() {
        $(document).on('click', '.ediT', function() {
            var id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ route('shop.merchant.get_id') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.id').val(data[0]['id']);

                }
            });
        });
        // $('#updatE').on('submit', function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('exclusive.update') }}",
        //         data: {
        //             '_token': $('input[name=_token]').val(),
        //             'id': $(".id").val(),
        //             'name': $(".name").val(),
        //             'role': $(".role").val(),
        //         },
        //         success: function() {
        //             $('#InformationproModalhdbgcl').modal('hide');
        //             location.reload();
        //         },
        //         error: function(error) {
        //             console.log(error);
        //             alert('Data Not Saved');
        //         }
        //     });
        // });
        // });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("password-confirm");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection
