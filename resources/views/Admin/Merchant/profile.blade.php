@extends('Master.main') @section('title')
    Merchant Profile
    @endsection @section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="">
                        <div class="">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    {{ __('Merchant Profile') }}
                                </h1>
                                {{-- @forelse ($payment as $data)
                                @empty
                                    <a href="{{ route('merchant.payment.info.add') }}" style="float: right;"
                                        class="btn btn-primary col-lg-3 col-xs-6">
                                        Update Payment Info
                                    </a>
                                @endforelse  --}}
                                <a href="" class="btn btn-primary col-lg-3 col-xs-6" style="float: right;"
                                    data-toggle="modal" data-target="#DangerModalhdbgcl123">
                                    Update NID Info
                                </a>
                                @if (session('status'))
                                    <div class="text-center alert alert-dismissible alert-success"
                                        style="padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <strong>{{ session('status') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal modal-adminpro-general FullColor-popup-DangerModal fade" id="DangerModalhdbgcl123"
                        role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('merchant.merchant_profile_update') }}" method="POST" name="updatP"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                    <div class="modal-header header-color-modal bg-color-4">
                                        <h4 class="modal-title">Update Profile</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro"> NID Number <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <input name="nid_number" class="form-control" type="text" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro"> NID Font Side <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <input type="file" name="nid_font_side" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro">NID Back Side <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <input type="file" name="nid_back_side" class="form-control" />
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="notification-bt modal-footer footer-modal-admin">
                                        <button class="btn btn-warning btn -xs" type="button"
                                            data-dismiss="modal">Close</button>
                                        <button class="btn btn-success btn -xs" type="submit"
                                            onclick="return confirm('Are You Sure You Want To Update Merchant Profile ??')">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal modal-adminpro-general FullColor-popup-DangerModal fade" id="DangerModalhdbgcl"
                        role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('merchant.profile.update') }}" method="POST" name="updatP">
                                    @csrf
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                    <div class="modal-header header-color-modal bg-color-4">
                                        <h4 class="modal-title">Update Profile</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro"> Owner Name <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <input name="name" value="{{ Auth::user()->name }}"
                                                        class="form-control" type="text" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro"> Business Name <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <input type="text" name="business_name"
                                                        value="{{ Auth::user()->business_name }}" class="form-control"
                                                        required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro"> Business Type <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <select name="business_type" class="form-control business_type"
                                                        required>
                                                        <option value="">----- Select Business Type -----</option>
                                                        @foreach ($business as $bus)
                                                            <option value="{{ $bus->b_type }}">{{ $bus->b_type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                    <label class="login2 pull-right pull-right-pro"> Area <span
                                                            class="table-project-n">*</span> </label>
                                                </div>
                                                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                    <select name="area" class="form-control area" required>
                                                        <option value="">----- Select Area -----</option>
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->name }}">{{ $district->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="notification-bt modal-footer footer-modal-admin">
                                        <button class="btn btn-warning btn -xs" type="button"
                                            data-dismiss="modal">Close</button>
                                        <button class="btn btn-success btn -xs" type="submit"
                                            onclick="return confirm('Are You Sure You Want To Update Merchant Profile ??')">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="single-product-tab-area mg-t-15 mg-b-30">
                        <div class="container-fluid text-center">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{-- <h4>{{ $merchant }}</h4> --}}
                                {{--
                                <div class="single-product-details res-pro-tb">
                                    @if (Auth::user()->business_name == !null)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                                        <ul style="font-size: 25px; font-weight: bold;">
                                            <b style="align: left;"> Business Name : </b>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                                        <ul style="font-size: 25px; font-weight: bold;">
                                            {{ Auth::user()->business_name }}
                                        </ul>
                                    </div>
                                    @endif @if (Auth::user()->name)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Owner Name :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->name }}
                                        </ul>
                                    </div>
                                    @endif @if (Auth::user()->mobile)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Mobile :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->mobile }}
                                        </ul>
                                    </div>
                                    @endif @if (Auth::user()->email)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Email :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->email }}
                                        </ul>
                                    </div>
                                    @endif @if (Auth::user()->district)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            District :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->district }}
                                        </ul>
                                    </div>
                                    @endif @if (Auth::user()->area)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Area :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->area }}
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Business Type :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->b_type ?? 'NULL' }}
                                        </ul>
                                    </div>
                                </div>
                                --}}
                            </div>
                        </div>

                        <h2 class="col-lg-12 text-center"><u>Business Info</u></h2>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-2 text-right">
                                            <b>
                                                <p>Owner Name</p>
                                                <p>Business Type</p>
                                                <p>Mobile</p>
                                                <p>Address</p>
                                                {{-- <p>NID No</p> --}}
                                                <p>NID Front</p>
                                                {{-- <p>Bank Cheque</p> --}}
                                            </b>
                                        </div>
                                        <div class="col-lg-1 text-center">
                                            <p>:</p>
                                            <p>:</p>
                                            <p>:</p>
                                            <p>:</p>
                                            <p>:</p>
                                            {{-- <p>:</p> --}}
                                        </div>
                                        <div class="col-lg-3 text-left">
                                            <p> {{ $merchant->user->name ?? '-' }} </p>
                                            <p>{{ $merchant->b_type ?? '-' }} </p>
                                            <p>{{ $merchant->user->mobile ?? '-' }}</p>
                                            <p>{{ $merchant->user->address ?? '-' }}</p>
                                            {{-- <p>{{ $profile->nid_no ?? '-' }}</p> --}}
                                            {{-- <p><img src="{{ asset($profile->nid_front) }}" height="170px;"
                                                width="250px;" /></p> --}}
                                            <p> <img src="{{ !empty($profile->nid_front) ? asset($profile->nid_front) : 'default-image-path' }}"
                                                    height="170px;" width="250px;" /> </p>
                                            {{-- <img alt="Bank_Cheque" src="https://fastly.picsum.photos/id/6/5000/3333.jpg?hmac=pq9FRpg2xkAQ7J9JTrBtyFcp9-qvlu8ycAi7bUHlL7I"
                                                    height="170px;" width="250px;" /> --}}
                                        </div>
                                        <div class="col-lg-2 text-right">
                                            <b>
                                                <p>Business Name</p>
                                                <p>Email</p>
                                                <p>Area</p>
                                                <p>District</p>
                                                <p>NID Back</p>
                                            </b>
                                        </div>
                                        <div class="col-lg-1 text-center">
                                            <p>:</p>
                                            <p>:</p>
                                            <p>:</p>
                                            <p>:</p>
                                            <p>:</p>
                                        </div>
                                        <div class="col-lg-3 text-left">
                                            <p> {{ $merchant->business_name }}</p>
                                            <p>{{ $merchant->user->email }}</p>
                                            <p>
                                                {{ $merchant->area }}
                                            </p>
                                            <p>{{ $merchant->district }}</p>
                                            {{-- <p><img src="{{ asset($profile->nid_back) }}" height="170px;"
                                                        width="250px;" /></p> --}}
                                            <p> <img src="{{ !empty($profile->nid_back) ? asset($profile->nid_back) : 'default-image-path' }}"
                                                    height="170px;" width="250px;" /> </p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="col-lg-12 text-center">Payment Details</h3>
                    <div class="clearfix">
                        @forelse ($payment as $data)
                        @empty
                            <a href="{{ route('merchant.payment.info.add') }}" style="float: right;"
                                class="btn btn-primary col-lg-3 col-xs-6">
                                Update Payment Info
                            </a>
                        @endforelse
                        </a>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-lg-4 text-right">
                        </div>
                        @foreach ($payment as $data)
                            @if ($data->p_type != 'Bank')
                                <div class="col-lg-2 text-right">
                                    <b>
                                        <p class="text-left">Mobile Banking</p>
                                        <p class="text-left">Account Type</p>
                                        <p class="text-left">Number</p>
                                    </b>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <p>:</p>
                                    <p>:</p>
                                    <p>:</p>
                                </div>
                                <div class="col-lg-2 text-left">
                                    <p>{{ $data->p_type ?? '-' }}</p>
                                    <p>{{ $data->mb_type ?? '-' }}</p>
                                    <p>{{ $data->mb_number ?? '-' }}</p>
                                </div>
                            @elseif ($data->p_type == 'Bank')
                                <div class="col-lg-2 text-right">
                                    <b>
                                        <p>Bank Name</p>
                                        <p>Hub Name</p>
                                        <p>Account Holder Name</p>
                                        <p>Account Type</p>
                                        <p>Account Number</p>
                                        <p>Routing Number</p>
                                    </b>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <p>:</p>
                                    <p>:</p>
                                    <p>:</p>
                                    <p>:</p>
                                    <p>:</p>
                                    <p>:</p>
                                </div>
                                <div class="col-lg-2 text-left">
                                    <p>{{ $data->bank_name ?? '-' }}</p>
                                    <p>{{ $data->branch_name ?? '-' }}</p>
                                    <p>{{ $data->account_holder_name ?? '-' }}</p>
                                    <p>{{ $data->account_type ?? '-' }}</p>
                                    <p>{{ $data->account_number ?? '-' }}</p>
                                    <p>{{ $data->routing_number ?? '-' }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.forms["updatP"].elements["business_type"].value = "{{ Auth::user()->b_type }}";
        document.forms["updatP"].elements["area"].value = "{{ Auth::user()->area }}";
    </script>
@endsection
