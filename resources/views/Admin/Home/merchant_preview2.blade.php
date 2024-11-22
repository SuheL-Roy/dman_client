@extends('Master.main')
@section('title')
    Merchant Preview
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-3">Merchant Preview</h1>
                            <form action="{{ route('shop.merchant.preview.print') }}" 
                                method="get" style="float:right; padding-right: 15px;" 
                                target="_blank"> @csrf
                                <input name="id" value="{{ $id }}" type="hidden"/>
                                <button type="submit"class="btn btn-primary btn-sm">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>

                    <div class="sparkline13-graph">
                        <div class="container-fluid">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th data-field="business_name" data-editable="false">Business Name</th>
                                        <th data-field="b_type" data-editable="false">Business Type</th>
                                        <th data-field="district" data-editable="false">District</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="status" data-editable="false">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($merchant as $data)
                                    <tr>
                                        <td>{{ $data->business_name }}</td>
                                        <td>{{ $data->b_type }}</td>
                                        <td>{{ $data->district }}</td>
                                        <td>{{ $data->area }}</td>
                                        <td>
                                            @if($data->status == 1) Active
                                            @elseif($data->status == 0) Inactive
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <thead>
                                    <tr>
                                        <th data-field="name" data-editable="false">Name</th>
                                        <th data-field="mobile" data-editable="false">Mobile</th>
                                        <th data-field="email" data-editable="false">Email</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $data)
                                    <tr>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        <td>{{ $data->email }}</td>
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