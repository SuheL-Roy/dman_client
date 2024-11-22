@extends('Master.main')
@section('title')
    Assigned Delivery
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
                                  Transfer  Order List <small> </small>
                                </h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-info"
                                            style="padding-top:5px; 
                                    padding-bottom:5px; margin-top:0px; margin-bottom:0px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
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
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="date" data-editable="false">Date</th>
                                            <th data-field="tracking_id" data-editable="false">Invoice ID</th>
                                            <th data-field="order_id" data-editable="false">Pickup Address</th>
                                            <th data-field="customer_name" data-editable="false">Delivery Address</th>
                                            <th data-field="type" data-editable="false">Type</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $key => $transfer)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $transfer->created_at->format('d-m-Y') }}</td>
                                                <td>{{ $transfer->invoice_id }}</td>
                                                <td>{{ $transfer->sender->address ?? '' }}</td>
                                                <td>{{ $transfer->receiver->address ?? '' }}</td>
                                                <td>{{ $transfer->type }}</td>
                                                <td class="datatable-ct">
                                                    {{-- <a href="{{ route('delivery.assign.transfered.show', $transfer->id) }}"
                                                        class="btn btn-primary ">
                                                        <i class="fa fa-eye"></i>
                                                        view
                                                    </a> --}}
                                                    <a href="{{ route('delivery.assign.transfered.show',  $transfer->id) }}"
                                                        class="btn">
                                                        <button  class="btn btn-info" ><i class="fa fa-eye"></i> View  </button>
                                                    </a>

                                                    <a href="{{ route('delivery.assign.transfered', $transfer->id) }}"
                                                        class="btn " onclick="return confirm('Are You Sure ??')"
                                                        title="Reach to Fullfilment ??">

                                                        <button class="btn btn-success"><i class="fa fa-check"></i> Reach To
                                                        </button>
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
                    url: "{{ route('delivery.assign.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['tracking_id']);
                    }
                });
            });
            $('#updatE').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('delivery.assign.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'tracking_id': $(".id").val(),
                        'rider': $(".rider").val(),
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
