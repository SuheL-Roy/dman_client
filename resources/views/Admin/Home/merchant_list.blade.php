@extends('Master.main')
@section('title')
    Merchant List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Merchant List</h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>


                        <div id="InformationproModalhdbgcl"
                            class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header header-color-modal bg-color-1">
                                        <h4 class="modal-title">Edit Employee Info</h4>
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i
                                                    class="fa fa-close"></i></a>
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
                                                        <input type="hidden" class="id" name="id" />
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            {{-- <th data-field="id" data-editable="false">Merchant ID</th> --}}
                                            {{-- <th data-field="name" data-editable="false">Name</th> --}}
                                            <th data-field="business_name" data-editable="false">Business Name</th>
                                            <th data-field="mobile" data-editable="false">Mobile</th>
                                            <th data-field="area" data-editable="false">Hub </th>
                                            {{-- <th data-field="district" data-editable="false">District</th> --}}

                                            <th data-field="m_discount" data-editable="false">Email</th>
                                            <th data-field="m_cod" data-editable="false">Merchant Id</th>
                                            {{-- <th data-field="m_insurance" data-editable="false">Risk Fee (%)</th> --}}


                                            {{-- <th data-field="dhaka-regular" data-editable="false">Sub Dhaka Regular(TK)
                                            </th> --}}
                                            {{-- <th data-field="dhaka-express" data-editable="false">Sub Dhaka Express(TK)
                                            </th> --}}
                                            {{-- <th data-field="outside-dhaka-regular" data-editable="false">Outside Dhaka
                                                Regular(TK)</th> --}}
                                            {{-- <th data-field="outside-dhaka-express" data-editable="false">Outside Dhaka
                                                Express(TK)</th> --}}

                                            {{-- <th data-field="status" data-editable="false">Status</th> --}}
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                {{--  <td>M{{ $data->od }}{{ $data->id }}</td>  --}}
                                                {{-- <td>M{{ $data->ID }}</td> --}}
                                                {{-- <td>{{ $data->name }}</td> --}}
                                                <td>{{ $data->business_name }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->branch_name }}</td>
                                                {{-- <td>{{ $data->district }}</td> --}}

                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->ID }}</td>
                                                {{-- <td>{{ $data->m_insurance }}</td> --}}



                                                {{-- <td>{{ $data->sub_dhaka_regular }}</td> --}}
                                                {{-- <td>{{ $data->sub_dhaka_express }}</td> --}}
                                                {{-- <td>{{ $data->outside_dhaka_regular }}</td> --}}
                                                {{-- <td>{{ $data->outside_dhaka_express }}</td> --}}
                                                {{-- <td></td> --}}

                                                {{-- <td>
                                            @if ($data->role == 7) Active
                                            @else Inactive
                                            @endif
                                        </td> --}}
                                                <td class="datatable-ct">
                                                    <div class="btn-group" role="group" aria-label="Basic example">

                                                        <a class="btn btn-info"
                                                            href="{{ route('shop.merchant.preview', ['id' => $data->user_id]) }}"
                                                            class="btn ">

                                                            View
                                                        </a>

                                                        <a class="btn btn-primary"
                                                            href="{{ route('shop.merchant.edit', ['id' => $data->user_id]) }}"
                                                            class="btn ">

                                                            Edit
                                                        </a>

                                                        @if ($data->role == 12)
                                                            <a class="btn btn-success"
                                                                href="{{ route('shop.merchant.status', ['id' => $data->user_id]) }}"
                                                                class="btn"
                                                                onclick="return confirm('Are You Sure You Want To Inactivate This Merchant ??')">

                                                                Active
                                                            </a>
                                                        @elseif($data->role == 13)
                                                            <a class="btn btn-warning"
                                                                href="{{ route('shop.merchant.status', ['id' => $data->user_id]) }}"
                                                                class="btn"
                                                                onclick="return confirm('Are You Sure You Want To Activate This Merchant ??')">

                                                                InActive
                                                            </a>
                                                        @endif
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
                    url: "{{ route('shop.merchant.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.name').val(data[0]['name']);
                        $('.role').val(data[0]['role']);
                    }
                });
            });
            $('#updatE').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('shop.merchant.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".id").val(),
                        'name': $(".name").val(),
                        'role': $(".role").val(),
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
    </script>
@endsection
