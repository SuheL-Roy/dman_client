@extends('Master.main')
@section('title')
    Merchant Preview
@endsection
<style>
    span.a {
        word-spacing: 5px;
    }

    .header {
        margin-top: 20px;
        margin-left: 50px;
        text-align: center;
        font-size: 30px;
    }

    .order_confirm {
        border: none;
    }
</style>
@section('content')
    ​<div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <h4 class="header">Marchent Information</h4>

            </div>
            <div class="col-xs-6 col-md-4">
                <form action="{{ route('shop.merchant.preview.print') }}" method="get"
                    style="float:right; padding-right: 15px; " target="_blank"> @csrf
                    <input name="id" value="{{ $id }}" type="hidden" />
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-print"></i>
                    </button>
                </form>

            </div>
        </div>
        <hr>
        <div class="container-fluid ">
            <div class="container-fluid">
                <div class="row">


                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6">
                        <div class="card order_confirm" style="width: 20rem;border: none;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Business Name</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                        </span>{{ $merchant->business_name ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Business Type</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                        </span>{{ $merchant->b_type ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Mobile</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                        </span>{{ $user->mobile ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Address</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                        </span>{{ $user->address ?? '-' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>NID Front</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">: </span>
                                        @if ($image)
                                            <img src="{{ asset($image->nid_front) }}" height="140px;" width="160px;">
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6">
                        <div class="card order_confirm" style="width: 20rem;border: none;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><b>Name</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><span class="a">:
                                        </span>{{ $user->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><b>Email</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 "><span class="a"> :
                                        </span>{{ $user->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><b>Area</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><span class="a">:
                                        </span>{{ $merchant->area }} </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><b>District</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><span class="a">:
                                        </span>{{ $merchant->district }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><b>NID Back</b> </div>
                                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6 mt-2"><span class="a">: </span>
                                        @if ($image)
                                            <img src="{{ asset($image->nid_back) }}" height="140px;" width="160px;">
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>



        </div>


    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h4 class="mt-5" style="text-align: center; margin-top:30px;">Payment Details</h4>
            </div>

        </div>
        <hr>
        <div class="container-fluid ">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($payment as $data)
                        @if ($data->p_type != 'Bank')
                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6">
                                <div class=" order_confirm" style="width: 18rem; ">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Mobile Banking</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->p_type }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Account Type</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->mb_type ?? '-' }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Number</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->mb_number ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($data->p_type == 'Bank')
                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6">
                                <div class=" order_confirm" style="width: 18rem; ">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Bank Name</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->bank_name ?? '-' }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Branch Name</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->branch_name ?? '-' }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Account Holder Name</b>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->account_holder_name ?? '-' }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Account Type</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->account_type ?? '-' }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6  col-lg-6"><b>Account Number</b> </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->account_number ?? '-' }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Routing Number</b> </div>
                                            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:
                                                </span>{{ $data->routing_number ?? '-' }}</div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

        </div>


    </div>


    {{-- <div class="container-fluid">
    <div class="row">
      <div class="col">
      <h4 class="mt-3" style="text-align: center; margin-top:30px;">Shop Details</h4>
      </div>

    </div>
    <hr>
      <div class="container-fluid ">
        <div class="container-fluid">
            <div class="table-responsive">          
                <table class="table table-striped table-hover">
            <thead>
              <tr >
                <th scope="col">Shop Name</th>
                <th scope="col">Shop Phone</th>
                <th scope="col">Shop Area</th>
                <th scope="col">Shop Address</th>
                <th scope="col">Pickup Address</th>
                <th scope="col">Shop Link</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
              <tr>
                <td class="table-info">{{ $shop->shop_name }}</td>
                <td class="table-info">{{ $shop->shop_phone }}</td>
                <td class="table-info">{{ $shop->shop_area }}</td>
                <td class="table-info">{{ $shop->shop_address }}</td>
                <td class="table-info">{{ $shop->pickup_address }}</td>
                <td class="table-info">{{ $shop->shop_link }}</td>
                <td class="table-info">                                                   
                    @if ($shop->status == 1)
                        <a href="{{ route('shop.status',
                            ['id'=>$shop->id])}}" 
                            class="btn btn-warning btn-xs"
                            onclick="return confirm('Are You Sure You Want To Inactivate This Shop ??')">
                            <i class="fa fa-arrow-down" 
                            title="Inactivate Shop ??"></i>
                        </a>
                    @elseif($shop->status == 0)
                        <a href="{{ route('shop.status',
                            ['id'=>$shop->id])}}" 
                            class="btn btn-success btn-xs"
                            onclick="return confirm('Are You Sure You Want To Activate This Shop ??')">
                            <i class="fa fa-arrow-up" 
                            title="Activate Shop ??"></i>
                        </a>
                     @endif
                </td>
                
              </tr>
            @endforeach
            </tbody>
          </table>
            </div>
        </div>
          
              
              
      </div>
      
    
  </div> --}}

    {{-- ================================================================================================
<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h2 class="col-lg-11 text-center">Merchant Information</h2>
                            <form action="{{ route('shop.merchant.preview.print') }}" 
                                method="get" style="float:right; padding-right: 15px;" 
                                target="_blank"> @csrf
                                <input name="id" value="{{ $id }}" type="hidden"/>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
​
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-2 text-right">
                                        <b>
                                            <p>Business Name</p>
                                            <p>Business Type</p>
                                            <p>Mobile</p>
                                            <p>Address</p>
                                            <p>NID Front</p>
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
                                        <p>{{ $merchant->business_name??'-' }}</p>
                                        <p>{{ $merchant->b_type??'-' }}</p>
                                        <p>{{ $user->mobile??'-' }}</p>
                                       
                                        <p>{{ $user->address??'-' }}</p>
                                        <p>
                                            
                                            @if ($image->nid_front)
                                            <img src="{{ asset($image->nid_front) }}" height="140px;" width="160px;">   
                                            @endif
                                        </p>
                                        
                                    </div>
                                    
                                    <div class="col-lg-2 text-right">
                                        <b>
                                            <p>Name</p>
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
                                        <p>{{ $user->name }}</p>
                                        <p>{{ $user->email }}</p>
                                        
                                        <p> 
                                            {{ $merchant->area }} 
                                        </p>
                                        <p>{{ $merchant->district }}</p>
                                        <p>
                                            @if ($image->nid_back)
                                            <img src="{{ asset($image->nid_back) }}" height="140px;" width="160px;">   
                                            @endif
                                           </p>
                                    </div>
                                    
                                </div>
                                <div class="clearfix"></div>
                                <br>
                                <br>
                                <br>
                                <h3 class="col-lg-12 text-center">Payment Details</h3>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="row">
                                    @foreach ($payment as $data)
                                    @if ($data->p_type != 'Bank')
                                    <div class="col-lg-2 text-right">
                                        <b>
                                            <p>Mobile Banking </p>
                                            <p> Account Type</p>
                                            <p> Number</p>
                                        </b>
                                    </div>
                                    <div class="col-lg-1 text-center">
                                        <p>:</p>
                                        <p>:</p>
                                    </div>
                                    <div class="col-lg-2 text-left">
                                        <p>{{ $data->p_type }}</p>
                                        <p>{{ $data->mb_type }}</p>
                                        <p>{{ $data->mb_number }}</p>
                                    </div>
                                    @elseif ($data->p_type == 'Bank')
                                    <div class="col-lg-2 text-right">
                                        <b>
                                            <p>Bank Name</p>
                                            <p>Branch Name</p>
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
                                        <p>{{ $data->bank_name }}</p>
                                        <p>{{ $data->branch_name }}</p>
                                        <p>{{ $data->account_holder_name }}</p>
                                        <p>{{ $data->account_type }}</p>
                                        <p>{{ $data->account_number }}</p>
                                        <p>{{ $data->routing_number }}</p>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>


                                <div class="clearfix"></div>
                                <br>
                                <br>
                                <br>
                                <h3 class="col-lg-12 text-center">Shop Details</h3>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="sparkline13-graph">
                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                     
                                        <table id="table" data-toggle="table" data-pagination="false" 
                                                data-search="false" data-show-columns="false" 
                                                data-show-pagination-switch="false" data-show-refresh="false" 
                                                data-key-events="false" data-show-toggle="false" 
                                                data-resizable="false" data-cookie="false"
                                                data-cookie-id-table="saveId" data-show-export="false" 
                                                data-click-to-select="false" data-toolbar="#toolbar">
                                            <thead>
                                                <tr>
                                                    <th>Shop Name</th>
                                                    <th>Shop Phone</th>
                                                    <th>Shop Area</th>
                                                    <th>Shop Address </th>
                                                    <th> Pickup Address</th>   
                                                    <th> Shop Link</th> 
                                                    <th> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                              
                                                @foreach ($shops as $shop)
                                                <tr>
                                                    <td>{{ $shop->shop_name }}</td>
                                                    <td>{{ $shop->shop_phone }}</td>
                                                    <td>{{ $shop->shop_area }}</td>
                                                    <td>{{ $shop->shop_address }}</td>
                                                    <td>{{ $shop->pickup_address }}</td>
                                                    <td>{{ $shop->shop_link }}</td>
                                                    <td class="datatable-ct">                                                   
                                                        @if ($shop->status == 1)
                                                            <a href="{{ route('shop.status',
                                                                ['id'=>$shop->id])}}" 
                                                                class="btn btn-warning btn-xs"
                                                                onclick="return confirm('Are You Sure You Want To Inactivate This Shop ??')">
                                                                <i class="fa fa-arrow-down" 
                                                                title="Inactivate Shop ??"></i>
                                                            </a>
                                                        @elseif($shop->status == 0)
                                                            <a href="{{ route('shop.status',
                                                                ['id'=>$shop->id])}}" 
                                                                class="btn btn-success btn-xs"
                                                                onclick="return confirm('Are You Sure You Want To Activate This Shop ??')">
                                                                <i class="fa fa-arrow-up" 
                                                                title="Activate Shop ??"></i>
                                                            </a>
                                                        @endif
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
​
                </div>
            </div>
        </div>
    </div>
</div>
​ --}}
@endsection
