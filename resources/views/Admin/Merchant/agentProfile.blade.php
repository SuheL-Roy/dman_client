@extends('Master.main')
@section('title')
    Agent Profile
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                {{ __('Agent Profile') }}
                            </h1>
                            {{--  <button type="button" style="float:right;" data-toggle="modal" 
                                class="btn btn-danger col-lg-2 col-md-2 col-sm-4 col-xs-6 Primary" 
                                data-target="#DangerModalhdbgcl">Update Profile
                            </button>  --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                @if(session('status'))
                                    <div class="text-center alert alert-dismissible alert-success"
                                        style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px;">
                                        <button type="button" class="close" data-dismiss="alert" 
                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>{{ session('status') }}</strong>
                                    </div>      
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="modal modal-adminpro-general FullColor-popup-DangerModal fade" 
                        id="DangerModalhdbgcl" role="dialog">
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
                                                <label class="login2 pull-right pull-right-pro">
                                                    Owner Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                <input name="name" value="{{ Auth::user()->name }}" 
                                                    class="form-control" type="text" required/>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-2">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Area <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10">
                                                <select name="area" class="form-control area" required>
                                                    <option value="">----- Select Area -----</option>
                                                    @foreach ($districts as $district)
                                                    <option value="{{ $district->name }}">{{ $district->name }}</option>
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
                                        onclick="return confirm('Are You Sure You Want To Update Merchant Profile ??')">Submit
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="single-product-tab-area mg-t-15 mg-b-30">
                        <div class="container-fluid text-center">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="single-product-details res-pro-tb">
                                    
                                    @if (Auth::user()->name)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Name :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ Auth::user()->name }}
                                        </ul>
                                    </div>
                                    @endif
                                    @if (Auth::user()->mobile)
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
                                    @endif
                                    @if (Auth::user()->email)
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
                                    @endif
                                    @foreach ($agent as $data)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            District :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->district }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Area :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->area }}
                                        </ul>
                                    </div>
                                    @endforeach                                    
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
    document.forms['updatP'].elements['business_type'].value = '{{ Auth::user()->b_type }}';
    document.forms['updatP'].elements['area'].value = '{{ Auth::user()->area }}';
</script>
@endsection