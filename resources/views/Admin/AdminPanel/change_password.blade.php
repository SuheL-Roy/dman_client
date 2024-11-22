@extends('FrontEnd.loginMaster')
@section('title')
    Change Password
@endsection
@section('content')
    <style>
        .btn-success {
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        button:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }
    </style>
    <section class="container">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form action="{{ route('change.new.password') }}" method="POST"
                style="margin-top:150px; margin-bottom:145px; border: 1px solid var(--primary); 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px var(--primary);">
                @csrf
                <h3 class="text-center" style="color: var(--primary);"><b>Change Password</b></h3>
                <br>
                <div class="row">
                    {{--  <div class="form-group col-lg-12">
                    <label class="control-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"  
                        class="form-control @error('email') is-invalid @enderror" autofocus
                        required autocomplete="null" placeholder="Enter Email">
                    @error('email')
                        <span class="invalid-feedback help-block small" role="alert">
                            <strong style="color:red;">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  --}}
                    {{--  <div class="form-group col-lg-12">
                    <label class="control-label" for="password">Old Password</label>
                    <input id="old_password" type="password" name="old_password" 
                        autocomplete="current-password" placeholder="Enter Old Password"
                        class="form-control @error('old_password') is-invalid @enderror" required>
                    @error('old_password')
                        <span class="invalid-feedback help-block small" role="alert">
                            <strong style="color:red;">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  --}}
                    <div class="form-group col-lg-12">
                        <label class="control-label" for="password">New Password</label>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                            placeholder="New Password at-least 6 Character"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label class="control-label" for="password">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control"
                            placeholder="Re-write New Password" name="password_confirmation" autocomplete="new-password"
                            minlength="6" required>
                    </div>
                </div>
                <br>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <label><input id="show" type="checkbox" onclick="myFunction()" /></label><label
                        for="show">&nbsp;Show Password</label>
                </div>
                <div class="form-group text-center" style="margin-top: 10px">
                    <button type="submit" class="btn btn-block btn-success"
                        onclick="return confirm('Are You Sure You Want to Change Your Password ??');">
                        Confirm New Password
                    </button>
                </div>

            </form>
        </div>
        <div class="col-lg-4"></div>
    </section>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("password-confirm");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection
