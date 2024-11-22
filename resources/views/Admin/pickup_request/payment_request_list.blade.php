@extends('Master.main')
@section('title')
    Payment Request List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">
                                    Payment Request List
                                </h1>

                            </div>
                        </div>



                        {{-- <div class="clearfix">
                            <form action="{{ route('order.list.order_list_date_wise') }}" method="GET">
                                @csrf

                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">From </label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="date" name="fromdate" value="" class="form-control"
                                                required />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">To :</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="date" name="todate" value="{{ $today }}"
                                                class="form-control" />
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Load</button>
                            </form>
                        </div> --}}
                        {{-- <div class="clearfix"> --}}


                        {{-- </div> --}}
                        <div id="PrimaryModalalert13" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('payment_destroy') }}" method="POST">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p>Are You Sure You Want To Payment Requested Accepted ??</p>
                                                        <input type="hidden" name="id" class="id">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-success btn-sm" type="submit">OK</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="PrimaryModalalert12" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('payment_rejects') }}" method="POST">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p>Are You Sure You Want To Payment Requested Rejected ??</p>
                                                        <input type="hidden" name="id" class="id">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-success btn-sm" type="submit">OK</button>
                                        </div>
                                    </form>
                                </div>
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
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="selectall" /></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="name" data-editable="false">Merchant Name</th>
                                            <th data-field="voucher" data-editable="false">Payment Method Name</th>
                                            <!--<th data-field="action" data-editable="false">Action</th>-->


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payment_list as $key => $data)
                                            <tr>
                                                <td><input id="trackings" type="checkbox" class="select_id" /></td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $data->business_name }}</td>
                                                <td>{{ $data->payment_method }}</td>

                                                <!--<td class="datatable-ct">-->


                                                <!--    @if ($data->status === null)-->
                                                <!--        <button class="btn btn-success ediT" type="btn"-->
                                                <!--            value="{{ $data->id }}" href="" data-toggle="modal"-->
                                                <!--            data-target="#PrimaryModalalert13">-->
                                                <!--            Accept-->
                                                <!--        </button>-->


                                                <!--        <button class="btn btn-danger ediT" type="btn"-->
                                                <!--            value="{{ $data->id }}" href="" data-toggle="modal"-->
                                                <!--            data-target="#PrimaryModalalert12">-->
                                                <!--            Reject-->
                                                <!--        </button>-->
                                                <!--    @endif-->

                                                <!--    @if ($data->status === 'Approve')                           -->
                                                <!--        <p style="color: green;">Accepted</p>-->
                                                <!--    @endif-->

                                                <!--    @if ($data->status === 'Reject')-->
                                                <!--        <p style="color: red;">Rejected</p>-->
                                                <!--    @endif-->



                                                <!--</td>-->
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
            $('#table').DataTable({
                paging: true,
                searching: true,
                // Add other DataTables options as needed
            });
        });
    </script>
    <script>
        $(document).on('click', '.ediT', function() {
            var id = $(this).val();


            $.ajax({
                type: "GET",
                url: "{{ route('payment_reject') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    //console.log(data);
                    $('.id').val(data[0]['id']);

                }
            });
        });
    </script>
@endsection
