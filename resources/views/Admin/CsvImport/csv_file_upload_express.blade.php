@extends('Master.main')
@section('title')
    CSV express Upload
@endsection
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <div class="dashtwo-order-area mg-tb-15">
        <div class="container-fluid p-5">
            <div class="row">

                <div style="" class="col-lg-1 col-md-1 col-sm-1 col-xs-12">



                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-3"></div>
                        <div style="" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <h3 style="background: rgb(72, 188, 220); padding: 8px; text-align: center">Upload Express csv file</h3>




                            <form action="{{ route('file-import-express-store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                {{-- @can('activeMerchant')
                                    <label class="col-lg-4">Select Shop *</label>
                                    <div class="form-group col-lg-8">
                                        <select id="shop" class="form-control" name="shop" title="Select Shop" required>
                                            @foreach ($shop as $data)
                                                <option value="{{ $data->shop_name }}">{{ $data->shop_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcannot --}}
                                @cannot('activeMerchant')
                                    {{-- @can('superAdmin') --}}
                                    <label class="col-lg-4">Select Merchant *</label>
                                    <div class="form-group col-lg-8">
                                        <select id="shop" class="form-control" name="merchant" title="Select Shop"
                                            required>
                                            @foreach ($merchants as $merchant)
                                                <option value="{{ $merchant->user_id }}">{{ $merchant->business_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcannot
                                <div class="form-group">
                                    <label for="csv_file">CSV file:</label>
                                    <input type="file" class="form-control" id="csv_file" name="csv_file">
                                </div>
                                <button type="submit" class="btn btn-primary col-lg-4"> Import</button>
                                <a style="background: var(--primary); color: var(--white);" class="btn btn-success"
                                    href="{{ route('csv-file-download') }}">Sample Download</a>

                            </form>



                        </div>
                        {{-- <div class="col-lg-2">
                            <a style="background: var(--primary); color: var(--white); margin-top:88px;" class="btn btn-sm"
                                href="{{ route('csv-file-download') }}">Sample
                                Download</a>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="row">

                <div style="" class="col-lg-1 col-md-1 col-sm-1 col-xs-12">



                </div>

                <div style="" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <br />

                    @if (session()->has('type_error_msg'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>


                            {{ Session::get('type_error_msg') }}<br />

                            @php
                                Illuminate\Support\Facades\Session::forget('type_error_msg');
                            @endphp

                        </div>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>



@endsection
