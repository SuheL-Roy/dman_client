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
                            <h1 class="col-lg-3 col-md-3 col-sm-3 col-xs-6">Merchant Payment Info</h1>
                             
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
                                @forelse ($payment as $data)
                                @empty
                                    <a href="{{ route('merchant.payment.info.add') }}" 
                                        style="float:right;" class="btn btn-danger col-lg-3 col-xs-6">
                                        Update Payment Info hh
                                    </a>
                                @endforelse
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="single-product-tab-area mg-t-15 mg-b-30">
                        <div class="container-fluid text-center">
                            @forelse ($payment as $data) 
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="single-product-details res-pro-tb">
                                    @if($data->bank_name == !null)
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
                                    @if($data->bkash_account == !null)
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection