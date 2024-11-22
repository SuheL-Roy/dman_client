<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/bootstrap.min.css">
    
    <style type="text/css">
        @media print {
            @page {
                size: auto;
            }
        }
    </style>
</head>
<body onload="window.print();window.history.back()">
    <div class="container-fluid">
        <h2 style="text-align:center;">Merchant Information</h2>
        <hr>
        <br>
        <div style="width:100%; float:left;">
            <div style="width:50%; float:left;">
                <div style="width:40%; text-align:left; float:left;">
                    <b>
                        <p>Business Name</p>
                        <p>Business Type</p>
                        <p>District</p>
                        <p>Area</p>
                        <p>NID Front</p>
                    </b>
                </div>
                <div style="width:5%; text-align:left; float:left;">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </div>
                
                <div style="width:55%; text-align:left; float:right;">
                    <p>{{ $merchant->business_name }}</p>
                    <p>{{ $merchant->b_type }}</p>
                    <p>{{ $merchant->district }}</p>
                    <p>{{ $merchant->area }}</p>
                    <p><img src="{{ asset($image->nid_front) }}" height="50%;" width="60%;"></p>
                </div>
                
            </div>
            <div style="width:50%; float:right;">
                <div style="width:40%; float:left;">
                    <b>
                        <p>Name</p>
                        <p>Email</p>
                        <p>Mobile</p>
                        <p>Status</p>
                        <p>NID Back</p>
                    </b>
                </div>
                <div style="width:5%; float:left;">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </div>
                
                <div style="width:55%; float:right;">
                    <p>{{ $user->name }}</p>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->mobile }}</p>
                    <p> 
                        @if ( $merchant->status == 1 ) Active
                        @elseif ( $merchant->status == 0) Inactive
                        @endif
                    </p>
                    <p><img src="{{ asset($image->nid_back) }}" height="50%;" width="60%;"></p>
                </div>
                
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <h3 style="text-align:center; margin-top: 30px">Payment Details</h3>
        <hr>
        <div style="width:100%; float:left;">
            @foreach ($payment as $data)
            @if ($data->p_type != 'Bank')
            <div style="width:60%; float:left;">
                <div style="width:40%; text-align:left; float:left;">
                    <b>
                        <p>Mobile Banking</p>
                        <p> Account Type</p>
                        <p>Bkash Number</p>
                    </b>
                </div>
                <div style="width:5%; text-align:left; float:left;">
                    <p>:</p>
                    <p>:</p>
                </div>
                <div style="width:55%; text-align:left; float:right;">
                    <p>{{ $data->p_type }}</p>
                    <p>{{ $data->mb_type }}</p>
                    <p>{{ $data->mb_number }}</p>
                </div>
            </div>
            @elseif ($data->p_type == 'Bank')
            <div style="width:60%; float:left;">
                <div style="width:40%; float:left;">
                    <b>
                        <p>Bank Name</p>
                        <p>Hub Name</p>
                        <p>Account Holder Name</p>
                        <p>Account Type</p>
                        <p>Account Number</p>
                        <p>Routing Number</p>
                    </b>
                </div>
                <div style="width:5%; float:left;">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </div>
                <div style="width:55%; float:right;">
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
        </div>
    </div>
</body>
</html>
