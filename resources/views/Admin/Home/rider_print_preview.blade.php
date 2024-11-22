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
​
    <div style="text-align:center;">
        @foreach ($company as $com)
        <h2>{{ $com->name }}</h2>
        <h6>Mobile No. : {{ $com->mobile }}</h6>
        <h6>{{ $com->address }}</h6>
        @endforeach       
        </div>
        <hr>
     
        <h4 style="text-align:center;">Rider Information</h4>
       
      
        <div style="width:100%; float:left;">
            <div style="width:50%; float:left;">
                <div style="width:40%; text-align:left; float:left;">
                    <b>
                   <p>Name</p>
                   <p>Mobile</p>
                   <p>District</p>
                   <p>Present Address</p>
                   <p>Voter ID No</p>
                   <p>Fathers Mobile No</p>
                   <p>Rider Photo</p>
                   <p>Riders Fathers Voter ID Photo</p>
                    </b>
                </div>
                <div style="width:5%; text-align:left; float:left;">
​
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                                        
​
                
                </div>
                
                <div style="width:55%; text-align:left; float:right;">
                         <p>{{ $user->name }}</p>
                         <p>{{ $user->mobile }}</p>
                         <p>{{ $rider->district }}</p>
                         <p>{{ $rider->present_address }}</p>
                         <p>{{ $rider->voter_id_no }}</p>
                         <p>{{ $rider->fathers_phone_no }}</p>
                         <p>  <img src="{{ asset('public/photo/'.$user->photo) }}" height="100px;" width="100px;">   </p>
                         <p><img src="{{ asset('public/VoterID/FathersvoterID/'.$rider->user_fathers_voter_id_photo) }}" height="100px;" width="200px;"></p>
                </div>
                
            </div>
            <div style="width:50%; float:right;">
                <div style="width:40%; float:left;">
                    <b>
                    <p>Email</p>
                    <p>Address</p>
                    <p>Area</p>
                    <p>Permanent Address</p>
                    <p>Fathers Name</p>
                    <p>Fathers Voter ID No</p>
                    <p>Rider Voter ID Photo</p>
                    </b>
                </div>
                <div style="width:5%; float:left;">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </div>
                
                <div style="width:55%; float:right;">
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->address }}</p>
                    <p>{{ $rider->area }}</p>
                    <p>{{ $rider->permanent_address }}</p>
                    <p>{{ $rider->fathers_name }}dd</p>
                    <p>{{ $rider->fathers_voter_id_no }}dsd</p>
                    <p><img src="{{ asset('public/VoterID/UservoterID/'.$rider->user_voter_id_photo) }}" height="100px;" width="200px;"></p>
                </div>
                
            </div>
        </div>
      
  
     
    </div>
</body>
</html>
