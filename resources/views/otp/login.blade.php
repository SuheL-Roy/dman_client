@extends('FrontEnd.loginMaster') @section('title') Login @endsection @section('content')
<section class="container">
    <div style="margin-left: 0px;" class="col-lg-4"></div>
    <div style="margin-left: 0px;" class="col-lg-4">
        <form action="{{ route('otp.login.phone') }}" method="POST" style="margin-top: 120px; margin-bottom: 67px; border: 1px solid #ab1099; padding: 30px; border-radius: 1%; box-shadow: 5px 7px #888888;">
            @csrf
            <h3 class="text-center" style="color: #ab1099;"><b>OTP Login</b></h3>
            <br />
            <div class="row">
                <div class="form-group col-lg-12">
                 
                    <p style="text-align: center;">We wil send OTP code to your mobile number</p>

                    <br />

                    <div class="row">
                        <div style="padding-right: 0px !important; padding-left: 0px !important;" class="col-lg-3">
                            <select style="width: 100px; float: left;" class="form-control">
                                <option value="+880">BD +88</option>
                            </select>
                        </div>
                        <div style="padding-left: 5px !important; padding-right: 0px !important; margin: 0px !important;" class="col-lg-9">
                            <input class="form-control" name="mobile_no" type="text" maxlength="11" placeholder="Enter Your Mobile Number" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button style="margin-bottom: 50px;  background-color: #ab1099; border-color: #ab1099;" type="submit" class="btn btn-success loginbtn col-lg-12">Continue</button>
            </div>
        </form>
    </div>
</section>

@endsection
