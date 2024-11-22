@extends('Master.main')
@section('title')
    Rider Preview
@endsection
<style>
  span.a{
  word-spacing: 5px;
}
.header{
    margin-top: 20px;
    margin-left:50px; 
    text-align: center;
    font-size: 30px;
}
.order_confirm{
  border: none;
}
</style>
@section('content')
​<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-md-8">
    <h4 class="header">Rider Information</h4>
    
    </div>

    <div class="col-xs-6 col-md-4">
      <form action="{{ route('rider.preview.print') }}" 
                                method="get" style="float:right; padding-right: 15px;" 
                                target="_blank"> @csrf
                                <input name="id" value="{{ $id }}" type="hidden"/>
                                <button type="submit" class="btn btn-primary btn-sm" style="font-size:18px;">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>      
    </div>
  </div>
  </div>
  <hr>
    <div class="container-fluid ">
      <div class="container-fluid">
<div class="row">


            <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6">
              <div class="card order_confirm" style="width: 22rem; border: none;">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Name</b> </div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $user->name??'-' }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Mobile</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $user->mobile??'-' }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>District</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->district??'-' }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Present Address</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->present_address??'-' }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Voter ID No.</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->user_voter_id_no ??'-'}}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Fathers Phone No.</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->fathers_phone_no ??'-'}}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Riders Photo</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6" data-toggle="modal" data-target="#exampleModalCenter"><span class="a">:   </span><img src="{{ asset('/public/photo/'.$user->photo) }}" height="80px;" width="80px;"></div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Riders Fathers Voter Id Photo</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6" data-toggle="modal" data-target="#exampleModalCenter2"><span class="a">:   </span><img src="{{ asset('/public/VoterID/FathersvoterID/'.$rider->user_fathers_voter_id_photo) }}" height="80px;" width="80px;"></div>
                  </div>
                </div>
              </div>
    
            </div>
            
        <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6">
          <div class="card order_confirm" style="width: 22rem; border: none;">
            <div class="card-body">
              <div class="row">
              <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Email</b> </div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $user->email }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Address</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $user->address }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Area</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->area }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Permanent Address</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->permanent_address }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Fathers Name</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->fathers_name }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Fathers Voter Id No.</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><span class="a">:   </span>{{ $rider->fathers_voter_id_no }}</div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6"><b>Rider Voter Id Photo</b></div>
                    <div class="col-xs-12 col-sm-8 col-md-6  col-lg-6" data-toggle="modal" data-target="#exampleModalCenter3"><span class="a">:   <img src="{{ asset('/public/VoterID/UservoterID/'.$rider->user_voter_id_photo) }}" height="100px;" width="100px;"></div>
                  </div><br>
              
            </div>
          </div>
          
              </div>
            </div>
      </div>
        
            <hr>
            
            
    </div>
    
  
</div>
    
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">User Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="{{ asset('/public/photo/'.$user->photo) }}" height="400px;" width="400px;">
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
      <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
      <!--</div>-->
    </div>
  </div>
</div>
<!-- Modal2 -->
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">User Fathers Voter Id Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="{{ asset('/public/VoterID/FathersvoterID/'.$rider->user_fathers_voter_id_photo) }}" height="300px;" width="600px;">
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
      <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
      <!--</div>-->
    </div>
  </div>
</div>
<!-- Modal3 -->
<div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">User Voter Id Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="{{ asset('/public/VoterID/UservoterID/'.$rider->user_voter_id_photo) }}" height="300px;" width="600px;">
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
      <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
      <!--</div>-->
    </div>
  </div>
</div>
​
@endsection
