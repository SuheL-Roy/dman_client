@extends('FrontEnd.frontMaster')
@section('title')
    Welcome
@endsection
@section('content')
    <!--   start about top area-->
    <section class="about_top" id="about_top">
        <div class="container">
            <div class="row">

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="about_single_item">
                        <div class="item_icon">
                            <img src="{{ asset('/public/Welcome') }}/img/Urgent Delivery.png" alt="item">
                        </div>
                        <div class="about_single_item_content">
                            <h4>Urgent Delivery</h4>
                            <p>Fasted Same Day Delivery. Introducing App which gives you all features in one place. Now
                                where ever you are. if you have access to internet you are in.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="about_single_item">
                        <div class="item_icon">
                            <img src="{{ asset('/public/Welcome') }}/img/Cash on Delivery.jpg" alt="item">
                        </div>
                        <div class="about_single_item_content">
                            <h4>Cash on Delivery</h4>
                            <p>We provide the option of cash on delivery by collecting the payment in cash at the time of
                                delivery.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="about_single_item">
                        <div class="item_icon">
                            <img src="{{ asset('/public/Welcome') }}/img/Online parcels Tracking facility.png"
                                alt="item">
                        </div>
                        <div class="about_single_item_content">
                            <h4>Online parcels Tracking facility</h4>
                            <p>We provide real time parcel tracking facility to our merchants. So that they can easily
                                provide information with Customer.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--    end of about top area-->
    <!--    start about us area-->
    <!--<section class="about_us_area" id="about">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="about_us_content">
                                            <h2>about us</h2>
                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                            {{--  <a href="#">read more <span  class="fa fa-long-arrow-right"></span></a>  --}}
                                        </div>
                                    </div>
                                    <div class="col-md-offset-1 col-sm-6 col-md-5">
                                        <div class="about_car">
                                            <img src="{{ asset('/public/Welcome') }}/img/about_car.png" alt="car">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--   end of about us area-->
    <section class="price_area">

        <head>
            <style>
                table,
                th,
                td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 15px;
                    text-align: left;
                }

                #t01 {
                    width: 100%;
                    background-color: #f1f1c1;
                }
            </style>
        </head>

        <body>

    </section>
    <!--start counter up area-->
    <section class="couter_up_area">
        <div class="table">
            <div class="cell">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 text-center">
                            <div class="single_count">
                                <h1 class="counter">126</h1>
                                <h5>Satisfied clients</h5>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-md-offset-1 text-center">
                            <div class="single_count">
                                <h1 class="counter">34</h1>
                                <h5>Hubs</h5>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-md-offset-1 text-center">
                            <div class="single_count">
                                <h1 class="counter">120</h1>
                                <h5>Active workers</h5>
                            </div>
                        </div> -->
                        <div class="col-md-3 col-sm-3 col-md-offset-1 text-center">
                            <div class="single_count">
                                <h1 class="counter">3546</h1>
                                <h5>Product delivered s</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--    end of counter up area-->
    <!--        start calculate area-->
    <section class="calculate_area" id="tracking">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-6">
                    <div class="calculate_title">
                        <h2>Calculate your cost</h2>
                        <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat,</p>
                    </div>
                    <div class="calculate_form">
                        <form action="#">

                            <div class="single_calculate">
                                <label>weight</label>
                                <div class="calculate_option padding-riht">
                                    <select id="weight">
                                        <option value="#">Select Weignt</option>
                                        <option value="1">0.5 kg</option>
                                        <option value="2">1 kg</option>
                                    </select>
                                </div>
                            </div>
                            <div class="single_calculate">
                                <label>location</label>
                                <div class="calculate_option padding-riht">
                                    <select id="location">
                                        <option value="#" selected>Select Location</option>
                                        <option value="1">Dhaka</option>
                                        <option value="2">Outside</option>
                                    </select>
                                </div>
                            </div>

                            <div class="calculat-button">
                                <input type="button" id="calulate" class="calulate" value="Calculate your cost now">
                            </div>

                        </form>
                    </div>
                    <div class="totla-cost">
                        <h5>Total Cost: <span id="cost">$ 30</span></h5>
                    </div>
                    @push('js')
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#calulate').on('click', function() {
                                    var weight = $('#weight').val();
                                    var location = $('#location').val();
                                    if (weight == 1 && location == 1) {
                                        $('#cost').text('60');
                                    } else if (weight == 2 && location == 1) {
                                        $('#cost').text('70');
                                    } else if (weight == 1 && location == 2) {
                                        $('#cost').text('Comming Soon');
                                    } else if (weight == 2 && location == 2) {
                                        $('#cost').text('Comming Soon');
                                    } else {
                                        alert("Please select weight and location first !!!")
                                    }
                                });
                            });
                        </script>
                    @endpush
                </div>
            </div>
        </div>

    </section>
    <!--    end of calculate area-->
    <!--    start client say area-->
    <!-- <section class="client-area" id="service">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5 col-xs-12 col-sm-8">
                                        <div class="slients-title">
                                            <h2>What our clients say</h2>
                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat,</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="single-clients">
                                            <div class="client-img">
                                                <img src="{{ asset('/public/Welcome') }}/img/client.jpg" alt="client">
                                            </div>
                                            <div class="client-details">
                                                <p>“Lorem ipsum dolor sit amet, consectetuer adipis cing elit, sed diam nonummy nibh euismod tinci dunt ut laoreet dolore magna aliquam.”</p>
                                                <h4>John Doe<span>Student</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="single-clients">
                                            <div class="client-img">
                                                <img src="{{ asset('/public/Welcome') }}/img/client-2.jpg" alt="client">
                                            </div>
                                            <div class="client-details">
                                                <p>“Lorem ipsum dolor sit amet, consectetuer adipis cing elit, sed diam nonummy nibh euismod tinci dunt ut laoreet dolore magna aliquam.”</p>
                                                <h4>John Doe<span>Student</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--    end of client area-->
    <!--start Pricing Area -->
    <!-- <section class="pricing-area" id="pricing">
                            <div class="table">
                                <div class="cell">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-6">
                                                <div class="pricing-desc section-padding-two">
                                                    <div class="pricing-desc-title">
                                                        <div class="title">
                                                            <h2>Pricing & plans</h2>
                                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat,</p>
                                                        </div>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column-out">
                                <div class="pricing-slider">
                                    <ul class="carousel">
                                        <li class="items main-pos slides" id="1">
                                            <!-- Single Pricing Table -->
    <!-- <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Premium</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$450</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    </li>
    <!--    <li class="items right-pos slides" id="2">
                                            <!-- Single Pricing Table -->
    <!--    <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Basic</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$150</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    <!--       </li>
                                        <li class="items back-pos slides" id="3">
                                            <!-- Single Pricing Table -->
    <!--          <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Basic</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$150</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    <!--           </li>
                                        <li class="items back-pos slides" id="4">
                                            <!-- Single Pricing Table -->
    <!--             <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Premium</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$450</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    <!--            </li>
                                        <li class="items back-pos slides" id="5">
                                            <!-- Single Pricing Table -->
    <!--           <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Basic</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$150</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    <!--             </li>
                                        <li class="items back-pos slides" id="6">
                                            <!-- Single Pricing Table -->
    <!--              <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Basic</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$150</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    <!--             </li>
                                        <li class="items left-pos slides" id="7">
                                            <!-- Single Pricing Table -->
    <!--                 <div class="single-pricing-table">
                                                <div class="pricing-head">
                                                    <h6 class="price-title">Basic</h6>
                                                </div>
                                                <div class="price">
                                                    <p>$150</p>
                                                    <span class="pricing-status">per month</span>
                                                </div>
                                                <div class="pricing-body">
                                                    <ul>
                                                        <li>Full website maintance</li>
                                                        <li>Free domain & hosting</li>
                                                        <li>High quality product</li>
                                                        <li>24/7 Customer service</li>
                                                    </ul>
                                                    <a href="#" class="price-btn">Get started today</a>
                                                </div>
                                            </div>
                                            <!-- /.End Of Single Pricing Table -->
    </li>
    </ul>
    <div class="slider-navs">
        <div class="prev-nav" id="prev"><i class="fa fa-angle-left"></i></div>
        <div class="next-nav" id="next"><i class="fa fa-angle-right"></i></div>
    </div>
    </div>
    </div>
    </section>
    <!-- /.End Of Pricing Area -->
@endsection
