@extends('Master.main')
@section('title')
    Weight & Price List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Weight & Price List</h1>
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
                                <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                    data-toggle="modal" onclick="window.location='{{ route('weight_price.add') }}'">Add
                                    Weight & Price
                                </button>
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
                                            <th data-field="sl">SL.</th>
                                            <th data-field="title" data-editable="false">Title</th>
                                            <th data-field="ind_Re" data-editable="false">Inside-Dhaka(Regular)</th>
                                            <th data-field="ind_city_Re" data-editable="false">Inside-City(Regular)</th>
                                            <th data-field="ind_Ur" data-editable="false">Inside-Dhaka(Express)</th>
                                            <th data-field="ind_city_Ur" data-editable="false">Inside-City(Express)</th>
                                            <th data-field="out_Re" data-editable="false">Outside-Dhaka(Regular)</th>
                                            <th data-field="out_city_Re" data-editable="false">Outside-City(Regular)</th>
                                            <th data-field="out_Ur" data-editable="false">Outside-Dhaka(Express)</th>
                                            <th data-field="out_city_Ur" data-editable="false">Outside-City(Express)</th>
                                            <th data-field="sub_Re" data-editable="false">Sub-Dhaka(Regular)</th>
                                            <th data-field="sub_city_Re" data-editable="false">Sub-City(Regular)</th>
                                            <th data-field="sub_Ur" data-editable="false">Sub-Dhaka(Express)</th>
                                            <th data-field="sub_city_Ur" data-editable="false">Sub-City(Express)</th>
                                            {{--      <th data-field="ind_ReC" data-editable="false">Inside-Dhaka(Return)</th>
                                        <th data-field="out_ReC" data-editable="false">outside-Dhaka(Return)</th>
                                        <th data-field="sub_ReC" data-editable="false">Sub-Dhaka(Return)</th> --}}
                                            <th data-field="insurance" data-editable="false">Insurance(%)</th>
                                            <th data-field="cod" data-editable="false">Inside Dhaka (COD %)</th>
                                            <th data-field="sub_dhaka_cod" data-editable="false">Sub Dhaka (COD %)</th>
                                            <th data-field="outside_dhaka_cod" data-editable="false">Outside Dhaka (COD %)

                                                <th data-field="cod1" data-editable="false">Inside City (COD %)</th>
                                                <th data-field="sub_dhaka_cod1" data-editable="false">Sub City (COD %)</th>
                                                <th data-field="outside_dhaka_cod1" data-editable="false">Outside City (COD %)    
                                            </th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($weight_prices as $data)
                                            <tr>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->title }}</td>
                                                <td>{{ $data->ind_Re }}</td>
                                                <td>{{ $data->ind_city_Re }}</td>
                                                <td>{{ $data->ind_Ur }}</td>
                                                <td>{{ $data->ind_city_Ur }}</td>
                                                <td>{{ $data->out_Re }}</td>
                                                <td>{{ $data->out_city_Re }}</td>
                                                <td>{{ $data->out_Ur }}</td>
                                                <td>{{ $data->out_City_Ur }}</td>
                                                <td>{{ $data->sub_Re }}</td>
                                                <td>{{ $data->sub_city_Re }}</td>
                                                <td>{{ $data->sub_Ur }}</td>
                                                <td>{{ $data->sub_city_Ur }}</td>
                                                {{--       <td>{{ $data->ind_ReC }}</td>
                                        <td>{{ $data->out_ReC }}</td>
                                        <td>{{ $data->sub_ReC }}</td> --}}
                                                <td>{{ $data->insurance }}</td>
                                                <td>{{ $data->cod }}</td>
                                                <td>{{ $data->sub_dhaka_cod }}</td>
                                                <td>{{ $data->outside_dhaka_cod }}</td>
                                                <td>{{ $data->inside_city_cod }}</td>
                                                <td>{{ $data->sub_city_cod }}</td>
                                                <td>{{ $data->outside_city_cod }}</td>
                                                <td class="datatable-ct">
                                                    <a href="{{ route('weight_price.edit', ['id' => $data->id]) }}"
                                                        class="btn">
                                                        {{-- <i class="fa fa-edit"></i> --}}
                                                        <button class="btn btn-primary"> <i class="fa fa-edit"></i></i> Edit
                                                        </button>

                                                    </a>

                                                    <a href="{{ route('weight_price.destroy', ['id' => $data->id]) }}"
                                                        class="btn"
                                                        onclick="return confirm('Are You Sure You Want delete This Weight and price ??')">
                                                        <button class="btn btn-danger"> <i class="fa fa-delete"></i></i>
                                                            Delete </button>

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
@endsection
