@extends('Master.main')
@section('title')
    Order Return Report Date Wise
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
                                    Order Return Report <small>( Date Wise )</small>
                                </h1>
                                <form action="{{ route('order.report.return.datewise') }}" method="get">
                                    {{ csrf_field() }}
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="date" name="fromdate" required value="{{ $fromdate }}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm">Load</button>
                                </form>
                                {{--  <form action="{{ route('order.report.datewise.print') }}" method="get"
                                class="col-lg-1" style="float:right;" target="_blank"> 
                                @csrf
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}"/>
                                <input type="hidden" name="todate" value="{{ $todate }}"/>
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="float:right;">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>  --}}
                            </div>
                        </div>
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="create_date" data-editable="false">Create Date</th>
                                            <th data-field="invoice" data-editable="false">Invoice No</th>
                                            <th data-field="m_name" data-editable="false">Merchant Name</th>


                                            <th data-field="rider_name" data-editable="false">Rider Name</th>
                                            <th data-field="create_by" data-editable="false">Create By</th>
                                            <th data-field="update_by" data-editable="false">Update By</th>
                                            <th data-field="gg" data-editable="false">Security Code</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="actions" data-editable="false" style="width: 100px">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($payments as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>{{ $data->invoice_id }}</td>
                                                <td>{{ $data->merchant->name }}</td>

                                                <td>{{ $data->rider->name ?? '' }}</td>
                                                <td>{{ $data->creator->name }}</td>
                                                <td>{{ $data->updator->name ?? 'Not Yet' }}</td>
                                                <td>{{ $data->security_code ?? '' }}</td>
                                                <td>{{ $data->status }}
                                                </td>
                                                <td style="width: 100px">
                                                    <a class="btn btn-info"
                                                        href="{{ route('order.report.admin.rider.return.show', $data->id) }}"
                                                        class="btn">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Return to merchant
                                                confarmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('order.return.rider.merchant.store') }}"
                                                method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="security_code">Security Code</label>
                                                    <input type="hidden" name="invoice_id" id="invoice_id"
                                                        value="">
                                                    <input type="text" minlength="4" maxlength="4" required
                                                        name="security_code" id="security_code" class="form-control">
                                                </div>


                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
