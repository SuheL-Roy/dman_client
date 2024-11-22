@extends('FrontEnd.loginMaster')
@section('title')
    Registration
@endsection
@section('content')

<section class="contact-page-area">
    {{--  <div class="Modern-Slider">
        <!-- Item -->
        @foreach ($slider as $data)
            <div class="item">
                <div class="img-fill">
                    <img src="{{ asset($data->image) }}" alt="#">
                    <div class="info">
                        <div>
                            <h1>{{ $data->title }}</h1>
                            <h1>{{ $data->title2 }}</h1>
                            <h5>{{ $data->description }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- // Item -->
    </div>  --}}
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3"></div>
            <div class="col-md-6 col-sm-6">
                <div class="contact-form">
                    <div class="forms">
                        <ul class="tab-group">
                            <li class="tab active"><a href="#login">Log In</a></li>
                            <li class="tab"><a href="#signup">Sign Up</a></li>
                        </ul>
                        <form action="#" id="login">
                              <h1>Login on w3iscool</h1>
                              <div class="input-field">
                                <label for="email">Email</label>
                                <input type="email" name="email" required="email" />
                                <label for="password">Password</label> 
                                <input type="password" name="password" required/>
                                <input type="submit" value="Login" class="button"/>
                                <p class="text-p tab"> <a href="#">Forgot password?</a> </p>
                              </div>
                          </form>
                          <form action="#" id="signup">
                              <h1>Sign Up on w3iscool</h1>
                              <div class="input-field">
                                <label for="email">Email</label> 
                                <input type="email" name="email" required="email"/>
                                <label for="password">Password</label> 
                                <input type="password" name="password" required/>
                                <label for="password">Confirm Password</label> 
                                <input type="password" name="password" required/>
                                <input type="submit" value="Sign up" class="button" />
                              </div>
                          </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3"></div>
        </div>
    </div>
</section>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.tab a').on('click', function (e) {
        e.preventDefault();
        
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        
        var href = $(this).attr('href');
        $('.forms > form').hide();
        $(href).fadeIn(500);
        });
    });
</script>

@endsection
