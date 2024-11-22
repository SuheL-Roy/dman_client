@extends('Master.main')
@section('title')
    Merchant Payment Info
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                {{ __('Merchant Payment Info') }}
                            </h1>
                            <a href="{{ route('merchant.payment.info.add') }}" style="float:right;" 
                                class="btn btn-danger col-lg-3 col-md-3 col-sm-3 col-xs-6 Primary">
                                Update Payment Info
                            </a> 
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                @if(session('status'))
                                    <div class="text-center alert alert-dismissible alert-success">
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

                    <div id="DangerModalhdbgcl" class="modal modal-adminpro-general FullColor-popup-DangerModal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form action="{{ route('merchant.payment.update') }}" method="POST" name="updateProfile">
                                @csrf
                                <div class="modal-close-area modal-close-df">
                                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                </div>
                                <div class="modal-header header-color-modal bg-color-4">
                                    <h4 class="modal-title">Merchant Bank Account Info</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Bank Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <input type="text" name="bank_name"
                                                    class="form-control bank_name" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Hub Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <input type="text" name="branch_name"
                                                    class="form-control branch_name" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Account Holder Name <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <input type="text" name="account_holder_name"
                                                    class="form-control account_holder_name" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Account Type <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <select name="account_type" 
                                                    class="form-control account_type" required>
                                                    <option value="">----- Select Account Type -----</option>
                                                    <option value="CURRENT">CURRENT</option>
                                                    <option value="SAVING">SAVING</option>
                                                    <option value="AWCDI">AWCDI</option>
                                                    <option value="SND">SND</option>
                                                    <option value="STD">STD</option>
                                                    <option value="AWCA">AWCA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Account Number <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <input type="text" name="account_number"
                                                    class="form-control account_number" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-inner">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <label class="login2 pull-right pull-right-pro">
                                                    Routing Number <span class="table-project-n">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <input type="text" name="routing_number"
                                                    class="form-control routing_number" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="notification-bt modal-footer footer-modal-admin">
                                    <button class="btn btn-warning btn -xs" type="button"
                                        data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success btn -xs" type="submit"
                                        onclick="return confirm('Are You Sure You Want To Update Payment Info ??')">
                                        Update
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="single-product-tab-area mg-t-15 mg-b-30">
                        <div class="container-fluid text-center">
                            
                            @forelse ($data as $data) 
                            {{--  <div class="" style="font-size:15px; font-weight:bold; float:left;">
                                    Merchant Bank Info :
                            </div>  --}}
                            <br>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="single-product-details res-pro-tb">
                                    @if($data->bank_name)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Bank Name :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->bank_name }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Hub Name :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->branch_name }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Account Holder Name :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->account_holder_name }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Account Type :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->account_type }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Account Number :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->account_number }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Routing Number :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->routing_number }}
                                        </ul>
                                    </div>
                                    @endif
                                    @if($data->bkash_account)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Account Type :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->bkash_account }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                        <li>
                                            Bkash Number :
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->bkash_number }}
                                        </ul>
                                    </div>
                                    @endif
                                    @empty
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                        <b>No Payment Info Available Yet .</b>
                                    </div> 
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    {{-- <div class="single-product-tab-area mg-t-15 mg-b-30"> --}}
                        {{-- <div class="container-fluid text-center"> --}}
                            {{--  @elseif($data->bkash_number != null)  --}}
                            {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline text-left"> --}}
                                {{--  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6 text-right">
                                        <li>
                                            Bkash Number :
                                        </li>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 text-left">
                                        <ul>
                                            {{ $data->bkash }}
                                        </ul>
                                    </div>
                                </div>  --}}
                                {{--  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-inline">  --}}
                                    {{--  <form action="{{ route('merchant.payment.update') }}" id="NEw" 
                                            method="POST" enctype="multipart/form-data"> @csrf
                                        <label style="font-size:15px;"> Bkash Number &nbsp; : &nbsp;</label>
                                        <input class="form-control bkash_number @error('bkash_number') is-invalid @enderror" 
                                            type="text" name="bkash_number" required/> &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Update Bkash Number
                                        </button>
                                        @error('bkash_number')
                                            <span class="invalid-feedback help-block small" role="alert">
                                                <strong style="color:red;">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </form>  --}}
                                {{--  </div>  --}}
                            {{-- </div> --}}
                        {{-- </div> --}}
                    {{-- </div> --}}

                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    document.forms['updateProfile'].elements['bank_name'].value = '{{ $data->bank_name }}';
    document.forms['updateProfile'].elements['_name'].value = '{{ $data->branch_name }}';
    document.forms['updateProfile'].elements['account_holder_name'].value = '{{ $data->account_holder_name }}';
    document.forms['updateProfile'].elements['account_type'].value = '{{ $data->account_type }}';
    document.forms['updateProfile'].elements['account_number'].value = '{{ $data->account_number }}';
    document.forms['updateProfile'].elements['routing_number'].value = '{{ $data->routing_number }}';
    document.forms['NEw'].elements['bkash_number'].value = '{{ $data->bkash_number }}';
</script>
@endsection