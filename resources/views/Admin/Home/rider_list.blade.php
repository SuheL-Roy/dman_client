@extends('Master.main')
@section('title')
    Rider List
@endsection
@section('content')
    <style>
        .btn-success {
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        button:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }
    </style>
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Rider List</h1>
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
                                <a class="btn btn-success" href="{{ route('rider.register') }}" class="btn col-lg-3">
                                    <i class="fa fa-plus"></i> Rider Register
                                </a>
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
                                            {{-- <th data-field="id" data-editable="false">Rider ID</th> --}}
                                            <th data-field="name" data-editable="false">Name</th>
                                            <th data-field="email" data-editable="false">Email</th>
                                            <th data-field="mobile" data-editable="false">Mobile</th>
                                            <th data-field="district" data-editable="false">District</th>
                                            <th data-field="area" data-editable="false">Branch</th>
                                          
                                            <th data-field="r_delivery_charge" data-editable="false">Delivery Charge(TK)
                                            </th>
                                            <th data-field="r_pickup_charge" data-editable="false">Pickup Charge(Tk)</th>
                                            <th data-field="r_return_charge" data-editable="false">Return Charge(TK)</th>
                                          
                                           
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                {{--  <td>R{{ $data->od }}{{ $data->id }}</td>  --}}
                                                {{-- <td>R{{ $data->id }}</td> --}}
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->district }}</td>
                                                <td>{{ $data->area }}</td>
                                                <td>{{ $data->r_delivery_charge }}</td>
                                                <td>{{ $data->r_pickup_charge }}</td>
                                                <td>{{ $data->r_return_charge }}</td>
                                               
                                                <td>
                                                    @if ($data->role == 10)
                                                        Active
                                                    @elseif($data->role == 11)
                                                        Inactive
                                                    @endif
                                                </td>
                                                <td class="datatable-ct">


                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a class="btn btn-info"
                                                            href="{{ route('rider.preview', ['id' => $data->user_id]) }}"
                                                            class="btn">

                                                            View
                                                        </a>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('rider.edit', ['id' => $data->user_id]) }}"
                                                            class="btn">

                                                            Edit
                                                        </a>


                                                        @if ($data->role == 10)
                                                            <a class="btn" style="color: #fff; background: green"
                                                                href="{{ route('rider.status', ['id' => $data->user_id]) }}"
                                                                class="btn"
                                                                onclick="return confirm('Are You Sure You Want To Inactivate This Rider ??')">
                                                                Active
                                                            </a>
                                                        @elseif($data->role == 11)
                                                            <a class="btn btn-warning"
                                                                href="{{ route('rider.status', ['id' => $data->user_id]) }}"
                                                                class="btn"
                                                                onclick="return confirm('Are You Sure You Want To Activate This Rider ??')">

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
@endsection
