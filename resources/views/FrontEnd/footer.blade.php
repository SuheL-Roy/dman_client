<!--start footer area-->
<section class="footer-area" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3 col-xs-12 col-lg-4">
                <div class="single-footer">
                    <h2>Contact Us</h2>
                    <p>
                        @php
                            $data = App\Admin\Company::first();
                        @endphp
                        <img src="{{ asset($data->logo) }}" alt="logo" height="100px;" width="auto;">
                    </p>
                    <p>
                        Office Address : {{ $data->address }}
                    </p>
                    <p>
                        Phone No. : {{ $data->mobile }}.
                    </p>
                    <p>
                        E-mail : {{ $data->email }}
                    </p>
                    <p>
                        Visit us : {{ $data->website }}
                    </p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12 col-lg-2">
                <div class="single-footer">
                    <h2>More links</h2>
                    <ul class="list">
                        <li><a href="#about" style="color:black">About Us</a></li>
                        <li><a href="#tracking" style="color:black">Cost Calculation</a></li>
                        <li><a href="#service" style="color:black">Clients SAY</a></li>
                        <li><a href="#pricing"style="color:black">Pricing & Planning</a></li>
                        <li><a href="#contact"style="color:black">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
                <div class="single-footer">
                    <h2>Admin Panel links</h2>
                    <ul class="list">
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li><a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <li><a href="{{ route('admin.panel.login') }}" style="color:black">Admin Panel Login</a>
                                </li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('agent.register') }}" style="color:black">Agent
                                            Registration</a></li>
                                    <li><a href="{{ route('rider.register') }}" style="color:black">Rider
                                            Registration</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
            {{--  <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
                <div class="single-footer">
                    <h2>We Accepts</h2>
                    <a href="#"><img src="{{asset('/public/Welcome')}}/img/cards_credt_1.png" alt="#"></a>
                </div>
            </div>  --}}
            <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
                <div class="single-footer clearfix">
                    <h2>news letters</h2>
                    <input type="text" class="form-control">
                    <input type="submit" class="submt-button" value="submit">
                </div>
                <h2> Download Apps</h2>


                <a href="https://drive.google.com/file/d/1d3i0XvSWbasT5a5yrbMNFaHHp2FPI_4m/view?usp=sharing"
                    target="_self">
                    <img src="{{ asset('/public/Welcome') }}/img/apps.jpg" border="0" />
            </div>
        </div>
    </div>
</section>
<!--end of fotter area-->
<!--   start copyright text area-->
<div class="copyright-area">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-md-8 text-left">
            <div class="footer-text">
                <p>
                     © {{ $data->name }}</a></u>
                    All Rights Reserved. || Develop by
                    <u><a href="www.creativesoftware.com.bd">Creative Software Ltd</a></u>.
                </p>
                
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 text-right">
            <div class="footer-text">
                <a href="#" class="btn btn-xs"><i class="fa fa-facebook"></i></a>
                <a href="#" class="btn btn-xs"><i class="fa fa-twitter"></i></a>
                <a href="#" class="btn btn-xs"><i class="fa fa-linkedin"></i></a>
                <a href="#" class="btn btn-xs"><i class="fa fa-google-plus"></i></a>
            </div>
        </div>
    </div>
</div>
<!--    end of copyright text area-->
