<!--start header area-->

<section class="header_area five" id="home">
    <div class="logo_menu" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-6">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            @php
                               $data = App\Admin\Company::first();
                            @endphp
                            <img src="{{ asset($data->logo) }}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-md-9 col-xs-6 col-md-offset-1 col-sm-9 col-lg-offset-1 col-lg-9 mobMenuCol">
                    <nav class="navbar">
                        <ul class="nav navbar-nav navbar-right menu">
                            {{-- <li><a href="#">home<span class="caret"></span></a>
                                <ul class="dropdownMenu">
                                    <li><a href="index-2.html">Home 2</a></li>
                                    <li><a href="index-3.html">Home 3</a></li>
                                    <li class="current-menu-item"><a href="index-4.html">Home 4</a></li>
                                    <li><a href="index-5.html">Home 5</a></li>
                                    <li><a href="index-6.html">Home 6</a></li>
                                </ul>
                            </li> --}}
                            <li><a href="#home">home</a></li>
                            <li><a href="#about">about</a></li>
                            <li><a href="#tracking">Cost Calculation</a></li>
                            <li><a href="#service">CLIENTS SAY</a></li>
                            <li><a href="#pricing">pricing</a></li>
                            <li><a href="#contact">contact</a></li>
                            @if (Route::has('login')) 
                                @auth
                                    <li><a href="{{ url('/home') }}">Dashboard</a></li>
                                    @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    @if (Route::has('admin.merchant.registration'))
                                    <li><a href="{{ route('admin.merchant.registration') }}">Register</a></li>
                                    @endif
                                @endauth
                            @endif
                        </ul>
                        <!-- /.navbar-collapse -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="Modern-Slider">
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
    </div>
</section>
<!--end of header area-->