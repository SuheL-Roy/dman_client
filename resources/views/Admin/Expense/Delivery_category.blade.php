@extends('Master.main')
@section('title')
Reason Category List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Reason Category List</h1>
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
                                    <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                        data-toggle="modal" data-target="#PrimaryModalalert"> Add Reason Category
                                    </button>
                                @endcan
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('order.delivery_category_store') }}" method="POST">
                                        @csrf
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title"> Reason Category</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Reason Category <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                                        <select name="reason_category" class="form-control" required>
                                                            <option value="">Select Reason Category</option>
                                                            <option value="Return">Return</option>
                                                            <option value="Reshedule">Reshedule</option>
                                                            <option value="Exchange">Exchange</option>
                                                            <option value="Partial">Partial</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Reason Name <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="reason_name" autocomplete="name"
                                                            class="form-control" placeholder="comment..." required />
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
                                    <form action="{{ route('Expense.update') }}" method="POST">
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
                                                        <input type="hidden" class="id" name="id">
                                                        <input type="text" name="name" autocomplete="name"
                                                            class="form-control name" placeholder="Expense Name" required />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
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
                                            {{--  <th data-field="id" data-editable="false">Employee ID</th>  --}}
                                            <th data-field="name" data-editable="false">Reason Category</th>
                                            <th data-field="name1" data-editable="false">Reason Name</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($delivery_category as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>

                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ $data->comment }}</td>


                                                <td class="datatable-ct">
                                                   

                                                    <a style="font-size: 12px;" class="btn btn-danger"
                                                        href="{{ route('order.reason_category_destroy', ['id' => $data->id]) }}"
                                                        onclick="return confirm('Are You Sure You Want To Delete ??')">

                                                        <i class="fa fa-trash"></i>
                                                    </a>



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
                    url: "{{ route('Expense.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.name').val(data[0]['name']);
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
        });
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