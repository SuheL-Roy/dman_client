@extends('FrontEnd.loginMaster')
@section('title')
    Login
@endsection
@section('content')
<style>


.bgWhite{
  background:white;
  box-shadow:0px 3px 6px 0px #cacaca;
}

.title{
  font-weight:600;
  margin-top:20px;
  font-size:24px
}

.customBtn{
  border-radius:0px;
  padding:10px;
}

form input{
  display:inline-block;
  width:50px;
  height:50px;
  text-align:center;
}


</style>


<section class="container">
    <div class="col-lg-4"></div>
    
    <div class="col-lg-6">
      
        <form action="{{ route('otp.verification.confirm') }}" method="POST" 
            style="margin-top:120px; margin-bottom:67px; border: 1px solid #ab1099; 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px #888888;">
            @csrf
            <h3 class="text-center" style="color:#ab1099;"><b>OTP Verification</b></h3>
            <br>
            <div class="row">
                <div class="form-group col-lg-12">
                <div class="form-group col-lg-12">
                <div class="form-group col-lg-12">

               <p style="text-align:center">We sent your code to {{ session('mobile_no') }}</p>
               <p style="text-align:center">Code will expire in 3 minutes</p>

               
                          
            <input id="mobile" type="text" name="password"  placeholder="Enter OTP" class="form-control" maxlength="4" required>
            
            <input type="hidden" id="mobile" name="mobile" value="{{ session('mobile_no') }}">
            


                                        
             </div>
             
             
            </div>
            
             <div class="row">
                  <div class="form-group col-lg-2">
                  </div>
                <div class="form-group col-lg-6">
                    
                     @if(session('message'))
                                    <div class="alert alert-dismissible alert-danger"
                                        style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px;">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ session('message') }}</strong>
                                    </div>   
                    @endif
                 </div>
                <div class="form-group col-lg-2">
                </div>
                    
            </div>
          
            <div class="form-group text-center">
                <button type="submit" style="border-color:#ab1099;background-color:#ab1099;" class="col-lg-12 btn btn-success loginbtn">Continue</button>
            </div>
            <br>
            <br>
     
           
        </form>
    </div>
    <div class="col-lg-4"></div>
</section>

@endsection