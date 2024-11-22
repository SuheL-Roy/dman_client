@extends('FrontEnd.loginMaster')
@section('title')
    Login
@endsection
@section('content')
<section class="container">
    
    <div class="col-lg-6">
        <form action="{{ route('otp.user_info.store') }}" method="POST" 
            style="margin-top:120px; margin-bottom:67px; border: 1px solid #ab1099; 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px #888888;">
            @csrf
            <h3 class="text-center" style="color:#ab1099;"><b>Write your Business Information</b></h3>
            <br>
            <div class="row">
                                          
                <div class="form-group col-lg-12">


                                        <div class="row">
                                         <div style="padding-left:5px !important;padding-right:0px !important;margin: 0px !important" class="col-lg-2">
                                                <p>Name:</p>
                                          </div>
                                          <div style="padding-left:5px !important;padding-right:0px !important;margin: 0px !important" class="col-lg-6">
                                                <input class="form-control" name="name" type="text" placeholder="Enter your Name"  required/>
                                         </div>
                                        </div>

                                        <div class="row">
                                         <div style="padding-left:5px !important;padding-right:0px !important;margin: 0px !important" class="col-lg-2">
                                                <p>Business Name:</p>
                                          </div>
                                          <div style="padding-left:5px !important;padding-right:0px !important;margin: 0px !important" class="col-lg-6">
                                                <input class="form-control" name="business_name" type="text" placeholder="Enter your Business Name" required/>
                                         </div>
                                        </div>

                                        <div class="row">
                                         <div style="padding-left:5px !important;padding-right:0px !important;margin: 0px !important" class="col-lg-2">
                                                <p>Address:</p>
                                          </div>
                                          <div style="padding-left:5px !important;padding-right:0px !important;margin: 0px !important" class="col-lg-6">
                                                <input class="form-control" name="address" type="text" placeholder="Enter your Address" required/>
                                         </div>
                                        </div>

                                        
                  </div>
             
             
            </div>

            <div class="form-group text-center">
                <button type="submit" style="background-color:#ab1099;border-color:#ab1099" class="col-lg-12 btn btn-success loginbtn">Continue</button>
            </div>
           
     
           
        </form>
    </div>
   
</section>

@endsection