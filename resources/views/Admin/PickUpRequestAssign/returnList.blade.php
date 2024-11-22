@extends('Master.main')
@section('title')
    Rider | Return
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-3" style="padding:0px;">
                                    Rider Return list
                                </h1>
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
                                            <th data-field="sfesr" data-editable="false">Merchant Phone</th>
                                            <th data-field="werwe" data-editable="false">Merchant Address</th>
                                            <th data-field="rider_name" data-editable="false">Rider Name</th>
                                            <th data-field="create_by" data-editable="false">Create By</th>
                                            {{-- <th data-field="update_by" data-editable="false">Update By</th> --}}
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
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->address }}</td>
                                                <td>{{ $data->rider->name ?? '' }}</td>
                                                <td>{{ $data->creator->name }}</td>
                                                <td>{{ $data->status }}
                                                </td>
                                                <td style="width: 100px">
                                                    <a href="{{ route('order.report.admin.rider.return.show', $data->id) }}"
                                                        class="btn">

                                                        <button class="btn btn-info"><i class="fa fa-eye"></i> View
                                                        </button>
                                                    </a>


                                                    <a class="btn " title="Order Return Delivery ??" type="button"
                                                        onclick="sumbitB('{{ $data->invoice_id }}')">
                                                        <button class="btn btn-success"><i class="fa fa-check"></i>
                                                            Confirm</button>
                                                    </a>


                                                    {{-- <button onclick="sumbitB('{{ $data->invoice_id }}')" type="button"
                                                        class="btn btn-primary btn-xs" data-toggle="modal"
                                                        data-target="#exampleModalCenter">
                                                        <i class="fa fa-check"></i>
                                                    </button> --}}

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
                                            <form action="{{ route('order.return.rider.merchant.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="security_code">Security Code</label>
                                                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
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

    <script>
        function sumbitB(invoice_id) {

            let modal = $('#exampleModalCenter');

            document.getElementById("invoice_id").value = invoice_id;

            $('#exampleModalCenter').modal("show");
        }
    </script>
@endsection
