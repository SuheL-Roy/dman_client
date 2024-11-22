@extends('Master.main')
@section('title')
    Branch Payment
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-2" style="padding:0px; margin-right:20px;">
                                    Branch Payment
                                </h1>

                                <form action="{{ route('accounts.branch.payment') }}" method="get">
                                    @csrf
                                    <div class="col-lg-2" style="padding:0px;">

                                        <select name="agent" class="selectpicker form-control" title="Select Branch"
                                            data-style="btn-info" data-live-search="true" required>
                                            @foreach ($user as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $agent == $data->id ? 'Selected' : '' }}>
                                                    {{ $data->name }} -
                                                    (A{{ $data->id }})
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" required value="{{ $fromdate }}"
                                                    class="form-control" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2" style="padding:0px;">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />

                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit"class="btn btn-primary btn-sm Primary">Load</button>
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('accounts.branch.payment.store') }}" method="post">
                            {{--  target="_blank">   --}}
                            @csrf
                            <input type="hidden" name="agent" value="{{ $agent }}" />
                            <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                            <input type="hidden" name="todate" value="{{ $todate }}" />
                            <p id="text" style="display:none">
                                <button type="submit" class="btn btn-success col-lg-1" style="float:right;"
                                    onclick="return confirm('Are You Sure ?')">Confirm
                                </button>
                            </p>

                            <div class="clearfix"></div>
                            <hr>

                            <div class="sparkline13-graph">

                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar">
                                        <select class="form-control">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="false" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="date" data-editable="false">Date</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                <th data-field="m_name" data-editable="false">Merchant Name</th>
                                                <th data-field="s_phone" data-editable="false">Rider Name</th>
                                                <th data-field="s_name" data-editable="false">Branch Name</th>
                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="collection" data-editable="false">Pickup commission</th>
                                                <th data-field="delivery" data-editable="false">Delivery commission</th>
                                                <th data-field="return_charge" data-editable="false">Return commission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @if (isset($order))
                                                @foreach ($order as $data)
                                                    <tr>
                                                        <td>&nbsp &nbsp<input type="checkbox" class="select_id"
                                                                value="{{ $data->tracking_id }}" name="tracking_ids[]" />
                                                        </td>
                                                        <td>{{ $i++ }}.</td>
                                                        <td>{{ $data->create_date }}</td>
                                                        <td>{{ $data->tracking_id }}</td>
                                                        <td>{{ $data->business_name }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td>{{ $data->area }}</td>
                                                        <td>{{ $data->status }}</td>
                                                        @if ($data->status == 'Pickup Done')
                                                            <td>{{ $data->a_pickup_charge }}</td>
                                                        @else
                                                            <td>0</td>
                                                        @endif
                                                        @if ($data->status == 'Successfully Delivered')
                                                            <td>{{ $data->a_delivery_charge }}</td>
                                                        @else
                                                            <td>0</td>
                                                        @endif

                                                        <td>{{ $data->a_return_charge }}</td>

                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" style="text-align:right;">Total : &nbsp;</td>

                                                <td> &nbsp;&nbsp; {{ $total_pick_charge ?? '' }}</td>
                                                <td> &nbsp;&nbsp; {{ $total_delivery_charge ?? '' }}</td>
                                                <td> &nbsp;&nbsp; {{ $total_return_charge ?? '' }}</td>


                                            </tr>

                                            <tr>
                                                <td colspan="9"> </td>
                                                <td><b>SubTotal:</b></td>

                                                <td colspan="6">
                                                    {{ $total ?? '' }}
                                                </td>

                                            </tr>

                                        </tfoot>


                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $(".selectall").click(function() {
                var text = document.getElementById("text");
                var checked = this.checked;

                if (checked == true) {
                    $('.select_id').prop('checked', true);
                    text.style.display = "block";
                } else {
                    $('.select_id').prop('checked', false);
                    text.style.display = "none";
                }
            });

        });
    </script>
@endsection
