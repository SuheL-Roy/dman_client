<!DOCTYPE html>
<html lang="en">

<head>
    <title>Amviness Logistics &mdash; Best courier service in bangladesh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta class="rounded float-right" property="og:image"
        content="https://logistic.amvines.com/public/FrontEnd/images/logisticnew.jpg">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700" />
    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/fonts/icomoon/style.css" />

    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/magnific-popup.css" />
    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/jquery-ui.css" />
    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/owl.theme.default.min.css" />

    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/bootstrap-datepicker.css" />

    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/aos.css" />

    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function resetfunc() {


            $('#weight').val('');

            // $('#sellprice').val('');

            $('#district').val('');

            $('#area').val('');


            $(".dlcl1").css("display", "none");
            $(".dlcl").css("display", "block");


        }
        $(document).ready(function() {




            $("#district").change(function() {
                $("#area").empty();
                $("#area").append($("<option>", {
                    value: "",
                    text: "Select Area"
                }));

                var district = $('select[name="district"] option:selected').text();

                var dt = $('select[name="delivery_type"] option:selected').val();



                $.ajax({
                    url: "{{ route('ajaxdata.area.data') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        district: district,
                        dt: dt,
                    },
                    cache: false,
                    dataType: "json",
                    success: function(dataResult) {
                        var resultData = dataResult.data;

                        $.each(resultData, function(index, row) {

                            var areaVal = row.inside;


                            $("#area").append($("<option>", {
                                value: areaVal,
                                text: row.area
                            }));


                        });
                    },
                });
            });




            $(".showdc").click(function() {




                var w = $('#weight').val();
                var weight = JSON.parse(w);
                hh = weight['title'];

                //var dt = $('#delivery_type').val();
                var dt = $('select[name="delivery_type"] option:selected').val();

                var d = $('select[name="district"] option:selected').text();

                var area = $('select[name="area"] option:selected').text();
                var a = $('select[name="area"] option:selected').val();



                var deliveryCharge = 0;

                if (a == 1) {
                    //Inside Dhaka
                    if (dt == 1) {
                        deliveryCharge = weight['ind_Re']
                    } else {
                        deliveryCharge = weight['ind_Ur']
                    }

                } else if (a == 2) {
                    //Sub Dhaka
                    if (dt == 1) {
                        deliveryCharge = weight['sub_Re']
                    } else {
                        deliveryCharge = weight['sub_Ur']
                    }
                } else {
                    //out Side Dhaka
                    if (dt == 1) {
                        deliveryCharge = weight['out_Re']
                    } else {
                        deliveryCharge = weight['out_Ur']
                    }

                }



                var title = weight['title'];




                if (w == '' || d == '' || a == '') {} else {

                    $(".dlcl").css("display", "none");
                    $(".dlcl1").css("display", "block");

                    $('.dlcl1').html('<div class="row"> <div class="col-sm-3" style=""> <p>Weight: ' +
                        title +
                        ' kg</p> </div> <div class="col-sm-2" style=""> <p> ' + '' +
                        ' </p></div><div class="col-sm-4" style=""> <p style="color: rgb(197, 52, 182);font-size:26px;font-weight:bold;">Delivery Chaarge : ' +
                        deliveryCharge +
                        ' Tk </p></div> <div class="col-sm-3" style="">     <button style="background-color: #fff; border-color: rgb(247 56 227);" type="button" class="btn resetcalc" onclick="resetfunc()">Reset</button> </div></div><div class="row"> <div class="col-sm-3" style=""> District: ' +
                        d + ' </div> <div class="col-sm-3" style=""> Area: ' + area +
                        ' </div><div class="col-sm-3" style=""> <p style=""> ' +
                        '' + '</p></div> </div>');

                }
            });
        });
    </script>

    {{-- <script>
        function resetfunc() {


            $('#weight').val('');

            $('#sellprice').val('');

            $('#district').val('');

            $('#area').val('');


            $(".dlcl1").css("display", "none");
            $(".dlcl").css("display", "block");


        }
        $(document).ready(function() {




            $("#district").change(function() {
                $("#area").empty();
                $("#area").append($("<option>", {
                    value: "",
                    text: "Select Area"
                }));

                var district = $('select[name="district"] option:selected').text();

                var dt = $('select[name="delivery_type"] option:selected').val();



                $.ajax({
                    url: "{{ route('ajaxdata.area') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        district: district,
                        dt: dt,
                    },
                    cache: false,
                    dataType: "json",
                    success: function(dataResult) {
                        var resultData = dataResult.data;

                        $.each(resultData, function(index, row) {

                            var areaVal = row.oneRe + "," + row.plusRe + "," + row
                                .oneUr + "," + row.plusUr;


                            $("#area").append($("<option>", {
                                value: areaVal,
                                text: row.area
                            }));


                        });
                    },
                });
            });





            $(".showdc").click(function() {




                var w = $('#weight').val();

                //var dt = $('#delivery_type').val();
                var dt = $('select[name="delivery_type"] option:selected').val();



                var sp1 = $('#sellprice').val();

                var sp = parseInt($('#sellprice').val());



                var d = $('select[name="district"] option:selected').text();

                var area = $('select[name="area"] option:selected').text();
                var a = $('select[name="area"] option:selected').val();
                var splits = a.split(",");
                var oner = parseInt(splits[0]);
                var plusRe = parseInt(splits[1]);
                var oneUr = parseInt(splits[2]);
                var plusUr = parseInt(splits[3]);


                var deliveryCharge = 0;

                if (w > 1) {
                    var weight = parseInt(w) - 1;

                    if (dt == 1) {
                        deliveryCharge = oner + (plusRe * weight);
                    } else {
                        deliveryCharge = oneUr + (plusUr * weight);
                        //alert(deliveryCharge);
                    }


                } else {
                    if (dt == 1) {
                        deliveryCharge = oner;
                    } else {
                        deliveryCharge = oneUr;
                        // alert(deliveryCharge);
                    }


                }
                var total = deliveryCharge + sp;



                if (w == '' || sp1 == '' || d == '' || a == '') {


                } else {

                    $(".dlcl").css("display", "none");
                    $(".dlcl1").css("display", "block");

                    $('.dlcl1').html('<div class="row"> <div class="col-sm-3" style=""> <p>Weight: ' + w +
                        ' kg</p> </div> <div class="col-sm-3" style=""> <p>Sell Price: ' + sp +
                        ' Tk</p></div><div class="col-sm-3" style=""> <p style="color: rgb(197, 52, 182);font-size:26px;font-weight:bold;">TOTAL: ' +
                        total +
                        ' Tk </p></div> <div class="col-sm-3" style="">     <button style="background-color: #fff; border-color: rgb(247 56 227);" type="button" class="btn resetcalc" onclick="resetfunc()">Reset</button> </div></div><div class="row"> <div class="col-sm-3" style=""> District: ' +
                        d + ' </div> <div class="col-sm-3" style=""> Area: ' + area +
                        ' </div><div class="col-sm-3" style=""> <p style="">Delivery charge: ' +
                        deliveryCharge + ' Tk</p></div> </div>');

                }





            });







        });
    </script> --}}

    <style>
        @media screen and (max-width: 1280px) {

            .track {
                margin-left: 0px !important;
                padding-left: 0px !important;
                width: 200px !important;
            }

        }

        @media screen and (max-width: 1024px) {

            .track {
                margin-left: 0px !important;
                padding-left: 0px !important;
                width: 170px !important;
            }

        }



        @media screen and (max-width: 912px) {

            .track {
                margin-left: 0px !important;
                padding-left: 0px !important;
                width: 130px !important;
            }

        }

        @media screen and (max-width: 820px) {

            .track {
                margin-left: 0px !important;
                padding-left: 0px !important;
                width: 100px !important;
            }

        }

        @media screen and (max-width: 768px) {

            .track {
                margin-left: 0px !important;
                padding-left: 0px !important;
                width: 80px !important;
            }

        }

        @media screen and (max-width: 540px) {

            .track {
                margin-left: 0px !important;
                width: 300px !important;
            }

        }

        @media screen and (max-width: 414px) {

            .track {
                margin-left: 0px !important;
                width: 250px !important;
            }

        }

        @media screen and (max-width: 2008px) and (min-width: 420px) {

            .track {
                margin-left: 0px !important;
                width: 200px !important;
            }

            @media screen and (max-width: 2008px) and (min-width: 420px) {

                .menubar {
                    visibility: hidden;
                }
    </style>
</head>

<body>

    <div class="site-wrap">
        <div class="site-mobile-menu">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        <header style="height: 100px;" class="site-navbar py-3" role="banner">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-11 col-xl-2">
                        <img src="{{ asset('/public/Superend/images/logo.png') }}" alt="Lamp" width="160"
                            height="60" />
                        <span class="menubar">
                            <a href="{{ route('register') }}" class="btn btn- btn-sm">register</a>
                            <p style="color: #C534B6; font-weight: 600">09613824466</p>

                        </span>

                    </div>


                    <div class="col-10 col-md-10 d-none d-xl-block">
                        <nav class="site-navigation position-relative text-right" role="navigation"
                            style="color: black;">
                            <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block mb-5">
                                @if (!auth()->check())
                                    <li>
                                        <a href="{{ route('register') }}""
                                            style="color: black; background-color: rgb(197, 52, 182); padding: 8px 10px; color: #fff; border-radius: 4px;">
                                            <b>Register</b> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('login') }}"
                                            style="color: black; padding: 2px solid red; background-color: rgb(197, 52, 182); padding: 8px 10px; color: #fff; border-radius: 4px;">
                                            <b>Login</b> </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}"
                                            style="color: black; padding: 2px solid red; background-color: rgb(197, 52, 182); padding: 8px 10px; color: #fff; border-radius: 4px;">
                                            <b>Dashboard</b> </a>
                                    </li>
                                @endif



                                <li>
                                    <a target="_blank"
                                        href="https://play.google.com/store/apps/details?id=com.amvines.grocery">
                                        <img style="width: 120px; height: 45px;"
                                            src="https://w7.pngwing.com/pngs/24/332/png-transparent-google-play-app-store-google-text-logo-banner.png"
                                            alt="" />
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank"
                                        href="https://play.google.com/store/apps/details?id=com.amvines.grocery">
                                        <img style="width: 120px; height: 45px;"
                                            src="https://w7.pngwing.com/pngs/422/842/png-transparent-apple-store-logo-app-store-android-google-play-get-started-now-button-text-logo-black.png"
                                            alt="" />
                                    </a>
                                </li>
                                <li>
                                    <span class="fa-stack fa-lg" style="opacity: 0.7    ;">
                                        <i style="color: #f89d13" class="fa fa-phone-square fa-stack-2x"></i>
                                    </span>
                                    <a href="tel:09613824466"
                                        style="color:#eb6c00;font-size:25px;font-weight:bold;">09613824466</a>


                                </li>

                            </ul>
                        </nav>
                    </div>

                    <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;">
                        <a href="#" class="site-menu-toggle js-menu-toggle text-white"><span
                                class="icon-menu h3"></span></a>
                    </div>
                </div>
            </div>
        </header>

        <div class="site-blocks-cover overlay"
            style="background-image: url({{ asset('/public/Superend/images/hero_bg_1.jpg') }});" data-aos="fade"
            data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
                        <h1 class="text-white font-weight-light mb-5 text-uppercase font-weight-bold">Reliable and
                            fastest logistics service.</h1>
                        <p><a href="{{ route('login') }}" class="btn  py-3 px-5 text-white"
                                style="background:rgb(197, 52, 182)">Get Started!</a></p>
                    </div>
                </div>
            </div>
        </div>


        <div style="background-color: #fff;" class="row">
            <div class="col-md-2"></div>


            <div style="padding-top: 50px; padding-bottom: 50px; padding-left: 0px;" class="col-md-4">
                <div style="background-color: #f8f9fa; border: 1px solid lightgray;"
                    class="feature-3 pricing h-100 text-center">
                    <div
                        style="border: 2px solid rgba(0, 0, 0, 0.6); width: 80px; height: 80px; line-height: 80px; position: relative; border-radius: 50%; margin: 0 auto !important;">
                        <img src="{{ asset('/public/Superend/images/tracking.png') }}" width="50"
                            height="45" />
                    </div>
                    <form action="{{ route('frontend.home.tracking_details') }}" method="GET">
                        <p class="control-label" style="color: black; padding-top: 10px;">Track Movement</p>
                        <div>
                            <div class="row">

                                <div class="col-md-12">
                                    <input type="text" name="tracking_id" style="" class="form-control"
                                        autofocus required autocomplete="null" placeholder="Enter Tracking No." />
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-6">
                                    <button
                                        style="margin-top: 30px; width: 150px; background-color: rgb(197, 52, 182); border-color: white; color: white;"
                                        type="submit" class="btn">Track</button>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>

            <div style="padding-top: 50px; padding-bottom: 50px; padding-left: 0px;" class="col-md-4">
                <form action="{{ route('otp.login.phone') }}" method="POST">
                    @csrf
                    <div style="background-color: #f8f9fa; border: 1px solid lightgray;"
                        class="feature-3 pricing h-100 text-center">
                        <div
                            style="border: 2px solid rgba(0, 0, 0, 0.6); width: 80px; height: 80px; line-height: 80px; position: relative; border-radius: 50%; margin: 0 auto !important;">
                            <img src="{{ asset('/public/Superend/images/phone_login.png') }}" width="50"
                                height="45" />
                        </div>
                        <p class="control-label" style="color: black; padding-top: 10px;">Phone Login</p>
                        <div class="row">

                            <select style="float: left; width: 100px;" class="form-control">
                                <option value="+880">BD+88</option>
                            </select>
                            <input type="text" name="mobile_no" class="form-control col-md-8" autofocus required
                                autocomplete="null" placeholder="Enter Phone No." />
                            @error('mobile_no')
                                <span style="color: rgb(227, 36, 36)">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <button
                                style="margin-top: 30px; width: 150px; background-color: rgb(197, 52, 182); border-color: white; color: white;"
                                type="submit" class="btn">Sign up</button>
                        </div>
                    </div>
            </div>
            </form>
            <div class="col-md-2"></div>
        </div>

        <div class="site-section block-13" style="margin-top: 0px; padding-top: 0px;">
            <!-- <div class="container"></div> -->

            <div class="owl-carousel nonloop-block-13">
                <div>
                    <a href="#" class="unit-1 text-center">
                        <img src="{{ asset('/public/Superend') }}/images/img_1.jpg" alt="Image"
                            class="img-fluid" />
                        <div class="unit-1-text">
                            <h3 class="unit-1-heading">Storage</h3>
                            <p class="px-5">
                                Save your product with best Storage.We are asure you 100% effort for save & put down
                                your destination. Our only goal is to get your product safely to the right place at the
                                right timeSo we are always
                                vigilant about stocking your product storage
                            </p>
                        </div>
                    </a>
                </div>

                <div>
                    <a href="#" class="unit-1 text-center">
                        <img src="{{ asset('/public/Superend') }}/images/img_2.jpg" alt="Image"
                            class="img-fluid" />
                        <div class="unit-1-text">
                            <h3 class="unit-1-heading">Air Transports</h3>
                            <p class="px-5">
                                Air transport which represents the next most substantial energy-consuming transport
                                sector includes passenger and freight airplanes that is aircraft configured for
                                transporting passengers freight or mail.
                            </p>
                        </div>
                    </a>
                </div>

                <div>
                    <a href="#" class="unit-1 text-center">
                        <img src="{{ asset('/public/Superend') }}/images/img_3.jpg" alt="Image"
                            class="img-fluid" />
                        <div class="unit-1-text">
                            <h3 class="unit-1-heading">Cargo Transports</h3>
                            <p class="px-5">
                                Cargo consists of bulk goods conveyed by water air or land. In economics freight is
                                cargo that is transported at a freight rate for commercial gain. Cargo was originally a
                                shipload but now covers all
                                types of freight including transport by rail van truck or intermodal container.
                            </p>
                        </div>
                    </a>
                </div>

                <div>
                    <a href="#" class="unit-1 text-center">
                        <img src="{{ asset('/public/Superend') }}/images/img_4.jpg" alt="Image"
                            class="img-fluid" />
                        <div class="unit-1-text">
                            <h3 class="unit-1-heading">Cargo Ship</h3>
                            <p class="px-5">
                                A cargo ship or freighter is a merchant ship that carries cargo goods and materials from
                                one port to another. Thousands of cargo carriers ply the world's seas and oceans each
                                year handling the bulk of
                                international trade.
                            </p>
                        </div>
                    </a>
                </div>

                <div>
                    <a href="#" class="unit-1 text-center">
                        <img src="{{ asset('/public/Superend') }}/images/img_5.jpg" alt="Image"
                            class="img-fluid" />
                        <div class="unit-1-text">
                            <h3 class="unit-1-heading">Ware Housing</h3>
                            <p class="px-5">
                                Warehousing is the act of storing goods that will be sold or distributed later While a
                                small home-based business might be warehousing products in a spare room basement or
                                garage larger businesses
                                typically own or rent space in a building that is specifically designed for storage
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="site-section bg-light delivery_calc">
            <div class="container delivery_calc">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-7 text-center border-primary">
                        <h2 class="font-weight-light text-primary">More Services</h2>
                        <p class="color-black-opacity-5">We Offer The Following Services</p>
                    </div>
                </div>
                <div class="row align-items-stretch">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                        <div class="unit-4 d-flex">
                            {{--
                                <div class="unit-4-icon mr-4"><span class="text-primary flaticon-travel"></span></div>
                                --}} {{--
                                <div class="unit-4-icon mr-4"><span class="text-primary flaticon-car"></span></div>
                                --}}

                            <div class="unit-4-icon mr-4">
                                <img src="{{ asset('/public/Superend') }}/images/express.png" alt="AAA"
                                    style="width: 70px; height: 70px;" />
                            </div>
                            <div>
                                <h3>One Hour Parcel Delivery</h3>

                                <button style="color: #f89d13 !important;" type="button"
                                    class="btn btn-info bg-transparent btn-primary" data-toggle="collapse"
                                    data-target="#demo">Learn More</button>

                                <div id="demo" class="collapse">
                                    <p>Only we give you the highest benifits.If you order any product at home, you will
                                        get delivery within one hour.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                        <div class="unit-4 d-flex">
                            <div class="unit-4-icon mr-4"><span class="text-primary flaticon-car"></span></div>
                            <div>
                                <h3>Regular Delivery</h3>

                                <button style="color: #f89d13 !important;" type="button"
                                    class="btn btn-info bg-transparent btn-primary" data-toggle="collapse"
                                    data-target="#demo1">Learn More</button>

                                <div id="demo1" class="collapse">
                                    <p>WE have arranged daily delivery for the convenience of the customer. Customer
                                        convenience is our only goal. so that customers are able to meet their needs
                                        with the products they need at home.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                        <div class="unit-4 d-flex">
                            <div class="unit-4-icon mr-4 mb-2">
                            </div>
                            <div>
                                <h3>Parcel Update</h3>
                                <button style="color: #f89d13 !important;" type="button"
                                    class="btn btn-info bg-transparent btn-primary" data-toggle="collapse"
                                    data-target="#demo2">Learn More</button>

                                <div id="demo2" class="collapse">
                                    <p>
                                        when you order a product the percel update will be sent to your mail or mobile
                                        immediately. we immediately update the parcel after the customer's order
                                        confirmation this is for the sake of
                                        customer certainty
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                        <div class="unit-4 d-flex">
                            <div class="unit-4-icon mr-4">
                                <img src="{{ asset('/public/Superend') }}/images/payment.png" alt="AAA"
                                    style="width: 70px; height: 70px;" />
                            </div>

                            <div>
                                <h3>Payment Update</h3>
                                <button style="color: #f89d13 !important;" type="button"
                                    class="btn btn-info bg-transparent btn-primary" data-toggle="collapse"
                                    data-target="#demo3">Learn More</button>

                                <div id="demo3" class="collapse">
                                    <p>
                                        When hauling a Coyote Logistics shipment, you can choose from any of the
                                        following payment options. Getting Paid within 48 Hours: 2-Day QuickPay*.Your
                                        payments will come from TriumphPay on behalf
                                        of Arrive Logistics (different name on the check), but otherwise, your payment
                                        process will not change.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                        <div class="unit-4 d-flex">
                            <div class="unit-4-icon mr-4"><span class="text-primary flaticon-platform"></span></div>
                            <div>
                                <h3>Bulk Shipment</h3>
                                <button style="color: #f89d13 !important;" type="button"
                                    class="btn btn-info bg-transparent btn-primary" data-toggle="collapse"
                                    data-target="#demo4">Learn More</button>

                                <div id="demo4" class="collapse">
                                    <p>
                                        Bulk shipping is a mass shipping technique where merchants ship large quantities
                                        of goods by loading unpackaged products onto shipping vessels. Bulk cargo is a
                                        shipping term for items that are
                                        shipped loosely and unpackaged as opposed to being shipped in packages or
                                        containers.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                        <div class="unit-4 d-flex">
                            <div class="unit-4-icon mr-4"><span class="text-primary flaticon-travel"></span></div>
                            <div>
                                <h3>International Services</h3>
                                <button style="color: #f89d13 !important;" type="button"
                                    class="btn btn-info bg-transparent btn-primary" data-toggle="collapse"
                                    data-target="#demo5">Learn More</button>

                                <div id="demo5" class="collapse">
                                    <p>
                                        To be the best resource for our clients in providing the most efficient and
                                        professional transportation and logistic services via Air and Truck. With the
                                        recent trend toward globalization, the
                                        interest in international logistics services to help businesses enter overseas
                                        markets is increasing.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-blocks-cover overlay inner-page-cover"
            style="background-image: url({{ asset('/public/Superend/images/c8066ad4-a7fd-4e2b-a53c-7fc5dc7f4192.jfif') }}); background-attachment: fixed;">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">

                    <div class="col-md-7" data-aos="fade-up" data-aos-delay="400">
                        <a href="https://www.youtube.com/watch?v=Jprb1NOtF40"
                            class="play-single-big mb-4 d-inline-block popup-vimeo"><span
                                class="icon-play"></span></a>
                        <h2 class="text-white font-weight-light mb-5 h1">Watching Our Services Video</h2>

                    </div>
                </div>
            </div>
        </div>

        <div class="site-section border-bottom ">
            <div class="container">
                <div class="row justify-content-center mb-2">
                    <div class="col-md-7 text-center">
                        <h2 class="font-weight-light text-primary">Delivery Calculator</h2>
                    </div>
                </div>

                <div class="container dlcl"
                    style="border: 1px solid lightgray;padding:30px;background-color: oldlace;">
                    <form id="frm1" method="post" onsubmit="return false;">
                        <div class="row">
                            <div class="col-sm-6" style="">
                                <div class="form-group">
                                    <label for="weight">Weight:</label>

                                    <select class="form-control" name="weight" id="weight">
                                        @foreach ($weights as $value)
                                            <option value="{{ $value }}">{{ $value->title }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6" style="">
                                <div class="form-group">
                                    <label for="delivery_type">Delivery Type</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" name="delivery_type" id="delivery_type"
                                            required>
                                            <option value="1">Regular</option>
                                            <option value="2">One Hour</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" style="">
                                <div class="form-group">
                                    <label for="district">District</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" name="district" id="district" required>
                                            <option value="">Select District</option>
                                            @foreach ($district as $value)
                                                <option value="{{ $value->id }}">{{ $value->district }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-6" style="">
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" name="area" id="area" required>
                                            <option value="">Select Area</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <div class="row">
                                <div class="col-sm-6" style="">
                                    <div class="form-group text-center">
                                        <button
                                            style="margin-left:15px;margin-top: 30px; background-color: #fff; border-color: rgb(247 56 227);"
                                            type="submit" class="btn showdc">Show Delivery Charge</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
                <div class="container dlcl1"
                    style="border: 1px solid lightgray;padding:30px;background-color: oldlace;display:none;">

                </div>
            </div>

            <div class="site-section">
                <div class="container">
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-7 text-center border-primary">
                            <h2 class="font-weight-light text-primary">Our Blog</h2>
                            <p class="color-black-opacity-5">See Our Daily News &amp; Updates</p>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-stretch">
                        <div class="col-md-6 col-lg-6 mb-4 mb-lg-4">
                            <div class="h-entry">
                                <img src="{{ asset('/public/Superend') }}/images/blog_1.jpg" alt="Image"
                                    class="img-fluid" style="height: 400px; width: 545px;" />
                                <h2 class="font-size-regular"><a href="#">Warehousing Your Packages</a></h2>
                                <!--<div class="meta mb-4">by Theresa Winston <span class="mx-2">&bullet;</span> Jan 18, 2019 at 2:00 pm <span class="mx-2">&bullet;</span> <a href="#">News</a></div>-->
                                <p>
                                    Warehousing allows for timely delivery and optimized distribution, leading to
                                    increased labor productivity and greater customer satisfaction. It also helps reduce
                                    errors and damage in the order
                                    fulfillment process. Plus, it prevents your goods from getting lost or stolen during
                                    handling.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-4 mb-lg-4">
                            <div class="h-entry">
                                <img src="{{ asset('/public/Superend') }}/images/blog_2.jpg" alt="Image"
                                    class="img-fluid" />
                                <h2 class="font-size-regular"><a href="#">Warehousing Your Packages</a></h2>
                                <!--<div class="meta mb-4">by Theresa Winston <span class="mx-2">&bullet;</span> Jan 18, 2019 at 2:00 pm <span class="mx-2">&bullet;</span> <a href="#">News</a></div>-->
                                <p>
                                    Warehousing allows for timely delivery and optimized distribution, leading to
                                    increased labor productivity and greater customer satisfaction. It also helps reduce
                                    errors and damage in the order
                                    fulfillment process. Plus, it prevents your goods from getting lost or stolen during
                                    handling.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="site-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <h2 class="footer-heading mb-4">Quick Links</h2>
                                    <ul class="list-unstyled">
                                        <li><a href="https://amvines.com/about" target="_blank"> About Us</a></li>
                                        <li><a href="https://amvines.com/conatct" target="_blank">Contact Us</a></li>
                                    </ul>
                                </div>

                                <div class="col-md-3">
                                    <!--<h2 class="footer-heading mb-4">Others</h2>-->
                                    <!--<ul class="list-unstyled">-->

                                    <!--    <li><a href="https://amvines.com/term-condition"  target="_blank"> Terms & Conditions</a></li>-->

                                    <!--    <li><a href="https://amvines.com/privacy-policy"  target="_blank"> Privacy Policy</a></li>-->
                                    <!--</ul>-->
                                </div>
                                <div class="col-md-3">
                                    <h2 class="footer-heading mb-4">Others</h2>
                                    <ul class="list-unstyled">
                                        <li><a href="https://amvines.com/term-condition" target="_blank"> Terms &
                                                Conditions</a></li>

                                        <li><a href="https://amvines.com/privacy-policy" target="_blank"> Privacy
                                                Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h2 class="footer-heading mb-4">Follow Us</h2>
                            <a href="https://www.facebook.com/Amvines-Logistic-104878982343586"
                                class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                            <a href="https://twitter.com/AmvinesDotCom" class="pl-3 pr-3"><span
                                    class="icon-twitter"></span></a>
                            <a href="https://www.facebook.com/amvinesdotcom/" class="pl-3 pr-3"><span
                                    class="icon-instagram"></span></a>
                            <a href="https://www.youtube.com/channel/UCB6CMBGznyKQ5PwdOvSGuag/videos"
                                class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                        </div>
                    </div>
                    <div class="row pt-5 mt-5 text-center">
                        <div class="col-md-12">
                            <div class="border-top pt-5">
                                <p>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    All rights reserved
                                    <!--| Made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://creativesoftware.com.bd" target="_blank">Creative Software</a>-->
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <script src="{{ asset('/public/Superend') }}/js/jquery-3.3.1.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/jquery-migrate-3.0.1.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/jquery-ui.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/popper.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/bootstrap.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/owl.carousel.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/jquery.stellar.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/jquery.countdown.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/jquery.magnific-popup.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/bootstrap-datepicker.min.js"></script>
        <script src="{{ asset('/public/Superend') }}/js/aos.js"></script>

        <script src="{{ asset('/public/Superend') }}/js/main.js"></script>
</body>

</html>
