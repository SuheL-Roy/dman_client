<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edak Courier:: door to door Courier Service in Bangladesh</title>
    <meta content="" name="description">

    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('/public/edak') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ asset('/public/edak') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/public/edak') }}/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('/public/edak') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/public/edak') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('/public/edak') }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('/public/edak') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ asset('/public/edak') }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('/public/edak') }}/assets/css/style.css" rel="stylesheet">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700" />
    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/fonts/icomoon/style.css" />

    <link rel="stylesheet" href="{{ asset('/public/Superend') }}/css/bootstrap.min.css" />
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
                        ' </p></div><div class="col-sm-4" style=""> <p style="color: #00557A;font-size:26px;font-weight:bold;">Delivery Chaarge : ' +
                        deliveryCharge +
                        ' Tk </p></div> <div class="col-sm-3" style="">     <button style="background-color: #00557A; color: #ffffff; border-color: #00557A;" type="button" class="btn resetcalc" onclick="resetfunc()">Reset</button> </div></div><div class="row"> <div class="col-sm-3" style=""> District: ' +
                        d + ' </div> <div class="col-sm-3" style=""> Area: ' + area +
                        ' </div><div class="col-sm-3" style=""> <p style=""> ' +
                        '' + '</p></div> </div>');

                }
            });
        });
    </script>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('/public/edak') }}/assets/img/logo.png" alt="" width="200"
                    height="600">
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#features">Services</a></li>

                    <!--  <li><a class="nav-link scrollto" href="#team">Team</a></li> -->
                    <li><a class="nav-link scrollto" href="#blog">Blog</a>
                        <!--  <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>  -->
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                    <li><a class="getstarted scrollto" href="{{ route('login') }}">Login</a></li>
                    <li><a class="getstarted scrollto" href="{{ route('register') }}">Registration</a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h2 data-aos="fade-up">আপনার প্রতিটি পার্সেল/ডকুমেন্ট আমাদের কাছে আমানত। তাই দ্রুত, ঝামেলা মুক্ত
                        ডেলিভারির জন্য সর্বদা আপনার পাশে আছি ।</h2><br>
                    <div> <b style="color:#CF1C21; font-size: 30px"; data-aos="fade-up">ই-ডাক</b> <b
                            style="color:#00557A;font-size: 30px"; data-aos="fade-up"> কুরিয়ার লিমিটেড</b> </div>

                    <h6 data-aos="fade-up" style="font-size: 22px";>"আপনার আমানত পৌঁছাব নিরাপদ"</h6><br>
                    <h3 data-aos="fade-up">প্রাপক যেখানেই থাকুন না কেন পৌঁছে যাব সময় মতো পণ্য নিয়ে তার দরজায় ।</h3>
                    <h2 data-aos="fade-up" data-aos-delay="400"></h2>
                    <div data-aos="fade-up" data-aos-delay="600">
                        <div class="text-center text-lg-start">
                            <a href="{{ route('register') }}"
                                class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>মার্চেন্ট হিসেবে যোগ দিন</span>
                                <i class="bi bi-arrow-right"></i>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="{{ asset('/public/edak') }}/assets/img/hero-img.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->


    <div class="jumbotron jumbotron-fluid mb-5 col-12 row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 justify-content-center">
            <div class="container text-center py-5">

                <h1 class="text-white mb-4 text-dark">Grow Business Together</h1>
                <div class="mx-auto" style="width: 100%; max-width: 700px;">
                    <form action="{{ route('frontend.home.tracking_details') }}" method="GET">
                        @csrf

                        <div class="input-group">
                            <input type="text" name="tracking_id" class="form-control border-light"
                                style="padding: 30px;" autofocus required autocomplete="null"
                                placeholder="Enter Tracking No." />
                            <div class="input-group-append">
                                <button class="btn px-3" style="background-color: #00557A; color: #ffffff;">Track
                                    Here</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>আমাদের ক্লাইন্ট</h2>
                <p>হাজারো ব্যবসা কে ডেলিভারি সাপোর্ট দিয়ে এগিয়ে নিয়ে যাচ্ছি আমরা</p>
            </header>

            <div class="clients-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/0.jpg"
                            class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/1.jpg"
                            class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/2.jpg"
                            class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/3.jpg"
                            class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/4.jpg"
                            class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/5.jpg"
                            class="img-fluid" alt="">
                    </div>
                    <!--  <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('/public/edak') }}/assets/img/clients/client-8.png" class="img-fluid" alt=""></div> -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

    </section><!-- End Clients Section -->
    <!-- ======= Values Section ======= -->
    <section id="values" class="values">

        <div class="container" data-aos="fade-up">

            <header class="section-header">
                <h2>আমাদের মান</h2>
                <p>আমাদের সুবিধা সমূহ</p>
            </header>

            <div class="row">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="box">
                        <img src="{{ asset('/public/edak') }}/assets/img/values-1.png" class="img-fluid"
                            alt="">
                        <h3>লাইভ প্রোডাক্ট ট্র্যাক</h3>
                        <p>ডেলিভারকৃত প্রোডাক্টের রিয়েল টাইম স্ট্যাটাস জানার সুযোগ। প্রোডাক্ট ডেলিভারি স্ট্যাটাস আপনি
                            জানতে পারবেন নিমিষেই!</p>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                    <div class="box">
                        <img src="{{ asset('/public/edak') }}/assets/img/values-2.png" class="img-fluid"
                            alt="">
                        <h3>কল সেন্টার সাপোর্ট</h3>
                        <p>আপনার সকল প্রয়োজনে অথবা জিজ্ঞাসায় আছে কল সেন্টার সাপোর্ট সেন্টার। কী একাউন্ট ম্যানেজার দ্বারা
                            সাপোর্টের ব্যবস্থা।</p>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600">
                    <div class="box">
                        <img src="{{ asset('/public/edak') }}/assets/img/values-3.png" class="img-fluid"
                            alt="">
                        <h3>১০০% ইনস্যুরেন্স কভারেজ</h3>
                        <p>প্রতিটি ডেলিভারিতে আমরা ১০০% ইনস্যুরেন্স কভারেজ প্রদান করে থাকি।</p>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- End Values Section -->

    <main id="main">
        <!-- ======= About Section ======= -->
        <section id="about" class="about">

            <div class="container" data-aos="fade-up">
                <div class="row gx-0">

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="content">
                            <h1>আমারা কেন সেরা </h1>
                            <h2></h2>
                            <p> ই-ডাক কুরিয়ার সারা দেশে চিঠি,ডকুমেন্ট, ইলেকট্রিক্যাল, ইলেকট্রনিক্স, ফ্যাশন এক্সেসরিজ,
                                কসমেটিকস, মেশিনারিজ, ফ্রুটস, এবং ঢাকা সিটিতে বেবি ফুড, রান্নাকরা খাবার, ফ্রোজেন ফুড,
                                ডেলিভারি করে থাকে। ই-ডাক কুরিয়ার খুব কম সময়ে নিরাপত্তার সাথে, সময়মতো ডেলিভারি এবং
                                গুরুত্বপূর্ণ নথি সরবরাহের জন্য জনপ্রিয় হয়ে উঠেছে। এটি বাংলাদেশের অন্যান্য কুরিয়ার
                                সার্ভিস এর তুলনায় এর গ্রাহকদের কাছে বিশ্বস্ত এবং নির্ভরযোগ্য হয়ে উঠেছে। ই-ডাক কুরিয়ার
                                সার্ভিসের মাধ্যমে ঢাকাসহ ৬৪টি জেলা শহর ও ৪৯৫ টি উপজেলায় এবং হাজার গ্রামে ডেলিভারি
                                সুবিধা দেওয়া হচ্ছে। ই-ডাক কুরিয়ার সার্ভিস তার শক্তিশালী ডেলিভারি নেটওয়ার্কের মাধ্যমে
                                মার্চেন্ট ও কাস্টমারদের বিশ্বস্ততার মাধ্যমে এখন এটি দেশের প্রথম শ্রেণীর বৃহত্তম কুরিয়ার
                                সার্ভিস হিসেবে পরিচিত। </p>
                            <div class="text-center text-lg-start">
                                <a href="#"
                                    class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Read More</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                        <img src="{{ asset('/public/edak') }}/assets/img/about.jpg" class="img-fluid"
                            alt="">
                    </div>

                </div>
            </div>

        </section><!-- End About Section -->



        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">

                <div class="row gy-4">



                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-people" style="color: #bb0852;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="665"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>রেজিস্টার্ড মার্চেণ্টস</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="821000"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>পার্সেল ডেলিভারি হয়েছে </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-headset" style="color: #15be56;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="24"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>ঘণ্টা সাপোর্ট</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-emoji-smile"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="26"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>জেলা কভারেজ</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Counts Section -->

        <!-- ======= Features Section ======= -->
        <section id="features" class="features">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <!-- <h2>Features</h2> -->
                    <h3>আপনার লজিস্টিক পার্টনার ই-ডাক কুরিয়ারের ৬৪ জেলা শহর ও ৪৯২ উপজেলায় এবং কয়েক হাজার গ্রামে
                        ডেলিভারি কভারেজ এরিয়া</h3>
                </header>

                <div class="row">

                    <div class="col-lg-6">
                        <img src="{{ asset('/public/edak') }}/assets/img/features.png" class="img-fluid"
                            alt="">
                    </div>

                    <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
                        <div class="row align-self-center gy-4">

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>ঢাকা</h3>

                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>বরিশাল</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>খুলনা</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>চট্টগ্রাম </h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>রাজশাহী</h3>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>সিলেট</h3>
                                </div>
                            </div>
                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>ময়মনসিংহ</h3>
                                </div>
                            </div>
                            <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
                                <div class="feature-box d-flex align-items-center">
                                    <i class="bi bi-check"></i>
                                    <h3>রংপুর</h3>
                                </div>
                            </div>

                        </div>
                    </div>

                </div> <!-- / row -->




                <!-- End  Tabs -->

                <!-- Feature Tabs -->
                <div class="row feture-tabs" data-aos="fade-up">
                    <div class="col-lg-6">
                        <h3>এখন হাতের মুঠোয় আপনার ব্যবসা, বিশ্বস্ত ও আদর্শ স্মার্ট ডেলিভারি সিস্টেম নিয়ে আপনার পাশে আছে
                            সর্বদা ই-ডাক কুরিয়ারের এপস ও ওয়েব সিস্টেম। </h3>

                        <!-- Tabs -->
                        <ul class="nav nav-pills mb-3">
                            <li>
                                <a class="nav-link active" data-bs-toggle="pill" href="#tab1">পার্সেল ট্রাকিং</a>
                            </li>
                            <li>
                                <a class="nav-link" data-bs-toggle="pill" href="#tab2">এপস সুবিধা</a>
                            </li>
                            <li>
                                <a class="nav-link" data-bs-toggle="pill" href="#tab3">ডেলিভারি সিস্টেম
                                </a>
                            </li>
                        </ul><!-- End Tabs -->

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="tab1">
                                <p>কাস্টমার তার পার্সেল এর অবস্থান অনলাইনের মাধ্যমে দেখতে পারবেন।
                                </p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check2"></i>
                                    <h4>খুব সহজে এবং আপনিও যে কোন পন্য পরিষেবার ডেলিভারি করাতে পারেন
                                    </h4>
                                </div>
                                <p>ই-ডাক কুরিয়ারের সিস্টেম অনেক স্মার্ট এবং অনেক সিকিউড ও পার্সেল সহযোগী । তাই এখানে
                                    মার্চেন্ট অথবা গ্রাহকের পন্য হারানো বা নস্ট হওয়ার কোন ভয় নাই, ইনশাআল্লাহ।
                                </p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check2"></i>
                                    <h4>সর্বোচ্চ পার্সেল ডেলিভারি সহযোগী ই-ডাক কুরিয়ার আপনার সেবায় ।
                                    </h4>
                                </div>
                                <p>এই স্মার্ট সিস্টেম এর মাধ্যমে পন্যর আসল লোকেশন, ডিজিটাল কাস্টমার, মার্চেন্ট পেমেন্ট,
                                    এবং ড্রোনের মাধ্যমে ডেলিভারি সুবিধা রয়েছ।
                                </p>
                            </div><!-- End Tab 1 Content -->

                            <div class="tab-pane fade show" id="tab2">
                                <p>Consequuntur inventore voluptates consequatur aut vel et. Eos doloribus expedita.
                                    Sapiente atque consequatur minima nihil quae aspernatur quo suscipit voluptatem.</p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check2"></i>
                                    <h4>Repudiandae rerum velit modi et officia quasi facilis</h4>
                                </div>
                                <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                    dolorum non eveniet magni quaerat nemo et.</p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check2"></i>
                                    <h4>Incidunt non veritatis illum ea ut nisi</h4>
                                </div>
                                <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                    tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                    Dolorem quo tempora. Quia et perferendis.</p>
                            </div><!-- End Tab 2 Content -->

                            <div class="tab-pane fade show" id="tab3">
                                <p>Consequuntur inventore voluptates consequatur aut vel et. Eos doloribus expedita.
                                    Sapiente atque consequatur minima nihil quae aspernatur quo suscipit voluptatem.</p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check2"></i>
                                    <h4>Repudiandae rerum velit modi et officia quasi facilis</h4>
                                </div>
                                <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                    dolorum non eveniet magni quaerat nemo et.</p>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check2"></i>
                                    <h4>Incidunt non veritatis illum ea ut nisi</h4>
                                </div>
                                <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                    tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                    Dolorem quo tempora. Quia et perferendis.</p>
                            </div><!-- End Tab 3 Content -->

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <img src="{{ asset('/public/edak') }}/assets/img/features-2.png" class="img-fluid"
                            alt="">
                    </div>

                </div><!-- End Feature Tabs -->

                <!-- Feature Icons -->
                <div class="row feature-icons" data-aos="fade-up">
                    <h3>ই-ডাক লজিস্টিকস সেবা
                    </h3>

                    <div class="row">

                        <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100">
                            <img src="{{ asset('/public/edak') }}/assets/img/features-3.png" class="img-fluid p-4"
                                alt="">
                        </div>

                        <div class="col-xl-8 d-flex content">
                            <div class="row align-self-center gy-4">

                                <div class="col-md-6 icon-box" data-aos="fade-up">
                                    <i class="ri-line-chart-line"></i>
                                    <div>
                                        <h4>সড়ক পরিবহণ</h4>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                    <i class="ri-stack-line"></i>
                                    <div>
                                        <h4>গুদামজাত করণ</h4>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                    <i class="ri-brush-4-line"></i>
                                    <div>
                                        <h4>জাহাজ পরিবহণ</h4>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                    <i class="ri-magic-line"></i>
                                    <div>
                                        <h4>ট্রেন পরিবহণ
                                        </h4>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                    <i class="ri-command-line"></i>
                                    <div>
                                        <h4>বিমান পরিবহণ</h4>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                    <i class="ri-radar-line"></i>
                                    <div>
                                        <h4> ড্রোন ডেলিভারি</h4>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                    <i class="ri-radar-line"></i>
                                    <div>
                                        <h4> ডোর টু ডোর ডেলিভারি</h4>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                    <i class="ri-radar-line"></i>
                                    <div>
                                        <h4> সাইকেল ডেলিভারি</h4>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div><!-- End Feature Icons -->

            </div>

        </section><!-- End Features Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>সেবা</h2>
                    <p>আপনার লজিস্টিক পার্টনার হিসেবে edak Courier বেছে নিন
                    </p>
                </header>

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-box blue">
                            <i class="ri-discuss-line icon"></i>
                            <h3>৩ দিনে ডেলিভারি গ্যারান্টিড</h3>
                            <p>মাত্র ৩ দিনে বাংলাদেশের যেকোনো প্রান্তে পার্সেল ডেলিভারির নিশ্চয়তা</p>
                            <a href="#" class="read-more"><span>Read More</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-box orange">
                            <i class="ri-discuss-line icon"></i>
                            <h3>পরের দিনই পেমেন্ট</h3>
                            <p>
                                ডেলিভারি সম্পূর্ণ হলে পরের দিনই পেমেন্ট পেয়ে যাবেন</p>
                            <a href="#" class="read-more"><span>Read More</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-box green">
                            <i class="ri-discuss-line icon"></i>
                            <h3>ডোরস্টেপ পিকআপ ও ডেলিভারি</h3>
                            <p>
                                আপনার দরজা থেকে কাঙ্ক্ষিত গন্তব্যে পার্সেল পৌঁছে যাবে নির্বিঘ্নে</p>
                            <a href="#" class="read-more"><span>Read More</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-box red">
                            <i class="ri-discuss-line icon"></i>
                            <h3>সেরা ক্যাশ অন ডেলিভারি রেট</h3>
                            <p>
                                ঢাকার ভিতর ক্যাশ অন ডেলিভারি চার্জ ০%, ঢাকার বাইরে ১%</p>
                            <a href="#" class="read-more"><span>Read More</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-box purple">
                            <i class="ri-discuss-line icon"></i>
                            <h3>এসএমএস আপডেট</h3>
                            <p>
                                পার্সেল বুকিং এবং ডেলিভারির সময় পাবেন আপনার নিবন্ধিত মোবাইল নম্বরে এসএমএস আপডেট</p>
                            <a href="#" class="read-more"><span>Read More</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
                        <div class="service-box pink">
                            <i class="ri-discuss-line icon"></i>
                            <h3>সিকিউর হ্যান্ডলিং</h3>
                            <p>
                                সর্বোচ্চ নিরাপদে শিপমেন্টের নিশ্চয়তা ও ক্ষতিপূরণ সুবিধা</p>
                            <a href="#" class="read-more"><span>Read More</span> <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End Services Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>চার্জ</h2>
                    <p>আমাদের ডেলিভারি চার্জ সমূহ</p>
                </header>

                <div class="row gy-4" data-aos="fade-left">

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="box">
                            <h3 style="color: #07d5c0;">ঢাকা সিটি</h3>
                            <div class="price">৳<sup></sup>৫০<span> / শুরু</span></div>
                            <img src="{{ asset('/public/edak') }}/assets/img/pricing-free.png" class="img-fluid"
                                alt="">
                            <ul>
                                <li>নেক্সট ডে ডেলিভারি</li>
                                <li>সি ও ডি চার্জ ফ্রি</li>
                                <li>১২/৭ সাপোর্ট</li>
                                <li>ঢাকা সিটির মধ্যে সেইম ডে সুবিধা</li>
                                <li>সর্বোচ্চ ১০ কেজি</li>
                            </ul>
                            <a href="#" class="btn-buy">রেগুলার</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <div class="box">
                            <span class="featured">Featured</span>
                            <h3 style="color: #65c600;">সাব সিটি</h3>
                            <div class="price"><sup>৳</sup>১১০<span> / শুরু</span></div>
                            <img src="{{ asset('/public/edak') }}/assets/img/pricing-starter.png" class="img-fluid"
                                alt="">
                            <ul>
                                <li>২/৩ দিনে ডেলিভারি</li>
                                <li>১% সি ও ডি চার্জ </li>
                                <li>১২/৭ সাপোর্ট</li>
                                <li>ঢাকা সাব সিটিতে এক্সপ্রেস ডেলিভারি</li>
                                <li>সর্বোচ্চ ১০ কেজি</li>
                            </ul>
                            <a href="#" class="btn-buy">রেগুলার</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                        <div class="box">
                            <h3 style="color: #ff901c;">সারা দেশে</h3>
                            <div class="price"><sup>৳</sup>১৩০<span> / শুরু</span></div>
                            <img src="{{ asset('/public/edak') }}/assets/img/pricing-business.png" class="img-fluid"
                                alt="">
                            <ul>
                                <li>৪৮ ঘন্টায় ডেলিভারি</li>
                                <li>১% সি ও ডি চার্জ </li>
                                <li>১২/৭ সাপোর্ট</li>
                                <li>সারা দেশে</li>
                                <li>সর্বোচ্চ ১০ কেজি</li>
                            </ul>
                            <a href="#" class="btn-buy">রেগুলার</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                        <div class="box">
                            <h3 style="color: #ff0071;">ফুড ডেলিভারি </h3>
                            <div class="price"><sup>৳</sup>১৫০<span> / শুরু</span></div>
                            <img src="{{ asset('/public/edak') }}/assets/img/pricing-ultimate.png" class="img-fluid"
                                alt="">
                            <ul>
                                <li>২/৪ ঘণ্টায় ডেলিভারি</li>
                                <li>সি ও ডি চার্জ ফ্রি</li>
                                <li>১২/৭ সাপোর্ট</li>
                                <li>শুধু ঢাকা সিটির মধ্যে</li>
                                <li>সর্বোচ্চ ১০ কেজি</li>
                            </ul>
                            <a href="#" class="btn-buy">ইমারজেন্সি</a>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End Pricing Section -->


        <div class="site-wrap">
            <div class="site-section border-bottom ">
                <div class="container">
                    <div class="row justify-content-center mb-2">
                        <div class="col-md-7 text-center">
                            <h2 class="font-weight-light" style="color:#00557A ">Delivery Calculator</h2>
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
                                                    <option value="{{ $value->id }}">{{ $value->district }}
                                                    </option>
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
                                                style="margin-left:15px;margin-top: 30px; background-color: #00557A; border-color: #00557A; color:#ffffff"
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
            </div>
        </div>


        <!-- ======= F.A.Q Section ======= -->
        <section id="faq" class="faq">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <!--  <h2>F.A.Q</h2> -->
                    <p>আপনার সকল জিজ্ঞাসা</p>
                </header>

                <div class="row">
                    <div class="col-lg-6">
                        <!-- F.A.Q List 1-->
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                                        আমি কিভাবে ই-ডাক কুরিয়ারে একজন মার্চেন্ট হতে পারি?
                                    </button>
                                </h2>
                                <div id="faq-content-1" class="accordion-collapse collapse"
                                    data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        উত্তরঃ ই-ডাক কুরিয়ারে মার্চেন্ট হতে চাইলে এখানে রেজিস্ট্রেশন করুনঃ লিংক
                                        অথবা আমাদের কল করুন 01845522500
                                        অথবা আমাদের ফেইসবুক এ যোগাযোগ করতে পারেন। অথবা ই-মেইল
                                        করুনঃcontact@edakcourier.com
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                                        ই-ডাক কুরিয়ার কি কি ধরনের পন্য ডেলিভারি করেন ? </button>
                                </h2>
                                <div id="faq-content-2" class="accordion-collapse collapse"
                                    data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        উত্তরঃ ই-ডাক কুরিয়ার সারা দেশে চিঠি,ডকুমেন্ট, ইলেকট্রিক্যাল, ইলেকট্রনিক্স,
                                        ফ্যাশন এক্সেসরিজ, কসমেটিক্স, মেশিনারিজ, ফ্রুটস, এবং ঢাকা সিটিতে বেবি ফুড,
                                        রান্নাকরা খাবার, ফ্রোজেন ফুড, ডেলিভারি করে থাকে।
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                                        কোন কোন জায়গায় ই-ডাক কুরিয়ার সার্ভিস পন্য ডেলিভারি করেন ? </button>
                                </h2>
                                <div id="faq-content-3" class="accordion-collapse collapse"
                                    data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        উত্তরঃ ই-ডাক কুরিয়ার দেশের ৬৪ জেলায় পন্য ডেলিভারি করে থাকে। আপনার নিকটস্থ ই-ডাক
                                        হাবে/শাখায় যোগাযোগ করে আজই ডেলিভারি বুক করুন। ই-ডাক কুরিয়ার হাব/শাখার সম্পূর্ণ
                                        লিস্ট দেখতেঃ এখানে ক্লিক করুন |
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq2-content-1">
                                        ডেলিভারি হওয়ার পর কখন পেমেন্ট পাব ? </button>
                                </h2>
                                <div id="faq2-content-1" class="accordion-collapse collapse"
                                    data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        উত্তরঃ ডেলিভারি সাকসেসফুল হওয়ার পরদিন রাত ১২ টা মধ্যে ব্যাংকে / বিকাশ/ নগদের
                                        পেয়ে যাবেন।
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <!-- F.A.Q List 2-->
                        <div class="accordion accordion-flush" id="faqlist2">



                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq2-content-2">
                                        আমি কিভাবে ডেলিভারি ইস্যু নিয়ে কমপ্লেইন করব এবং ডেলিভারির সময় আমার প্রোডাক্ট
                                        ক্ষতিগ্রস্থ হয়েছে/হারিয়ে গিয়েছে। আমার করণীয় কি? </button>
                                </h2>
                                <div id="faq2-content-2" class="accordion-collapse collapse"
                                    data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        উত্তরঃ আপনার ডেলিভারি এজেন্ট কিংবা অন্য ডেলিভারি ইস্যু নিয়ে কমপ্লেইন করতে
                                        অনুগ্রহ করে কাস্টমার ডিটেলস, চালান আইডি, প্রয়োজনীয় কাগজপত্র মেইল করুন
                                        support@edakcourier.com

                                        অথবা আমাদের হেল্প লাইনে কল করুন
                                        01845522500

                                        অথবা মার্চেন্ট প্যানেল থেকে হেল্প লাইনে যোগাযোগ করুন।

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq2-content-3">
                                        ই-ডাক কুরিয়ারের সার্ভিস সম্পর্কে কিছু ইনফরমেশন জানতে চাই। কিভাবে যোগাযোগ করতে
                                        পারি? </button>
                                </h2>
                                <div id="faq2-content-3" class="accordion-collapse collapse"
                                    data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        উত্তরঃ ই-ডাক কুরিয়ারের কভারেজ এরিয়া, ডেলিভারি চার্জ,পিকআপ/ডেলিভারি সময়,
                                        পেমেন্ট মেথড সহ সকল কিছু নিয়ে বিস্তারিত জানতে কল করুন :01845522500
                                        অথবা মেইল করুন
                                        support@edakcourier.com

                                        আমরা ২৪ ঘন্টার মধ্যে আপনার সাথে যোগাযোগ করব ইনশাআল্লাহ।
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End F.A.Q Section -->

        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>পোর্টফোলিও</h2>
                    <p>আমাদের ছবি সমূহ</p>
                </header>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">সব</li>
                            <li data-filter=".filter-app">আপস</li>
                            <li data-filter=".filter-card">ডেলিভারি</li>
                            <li data-filter=".filter-web">রাইডার</li>
                        </ul>
                    </div>
                </div>

                <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-1.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>App 1</h4>
                                <p>App</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-1.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="App 1"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-2.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Web 3</h4>
                                <p>Web</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-2.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="Web 3"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-3.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>App 2</h4>
                                <p>App</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-3.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="App 2"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-4.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Card 2</h4>
                                <p>Card</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-4.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="Card 2"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-5.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Web 2</h4>
                                <p>Web</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-5.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="Web 2"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-6.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>App 3</h4>
                                <p>App</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-6.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="App 3"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-7.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Card 1</h4>
                                <p>Card</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-7.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="Card 1"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-8.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Card 3</h4>
                                <p>Card</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-8.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="Card 3"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-wrap">
                            <img src="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-9.jpg"
                                class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>Web 3</h4>
                                <p>Web</p>
                                <div class="portfolio-links">
                                    <a href="{{ asset('/public/edak') }}/assets/img/portfolio/portfolio-9.jpg"
                                        data-gallery="portfolioGallery" class="portfokio-lightbox" title="Web 3"><i
                                            class="bi bi-plus"></i></a>
                                    <a href="portfolio-details.html" title="More Details"><i
                                            class="bi bi-link"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section> <!-- End Portfolio Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <!--  <h2>Testimonials</h2> -->
                    <p>ই-ডাক এর প্রতি গ্রাহকদের ভালোবাসা</p>
                </header>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit
                                    rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam,
                                    risus at semper.
                                </p>
                                <div class="profile mt-auto">
                                    <img src="{{ asset('/public/edak') }}/assets/img/testimonials/testimonials-1.jpg"
                                        class="testimonial-img" alt="">
                                    <h3>Saul Goodman</h3>
                                    <h4>Ceo &amp; Founder</h4>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid
                                    cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet
                                    legam anim culpa.
                                </p>
                                <div class="profile mt-auto">
                                    <img src="{{ asset('/public/edak') }}/assets/img/testimonials/testimonials-2.jpg"
                                        class="testimonial-img" alt="">
                                    <h3>Sara Wilsson</h3>
                                    <h4>Designer</h4>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem
                                    veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint
                                    minim.
                                </p>
                                <div class="profile mt-auto">
                                    <img src="{{ asset('/public/edak') }}/assets/img/testimonials/testimonials-3.jpg"
                                        class="testimonial-img" alt="">
                                    <h3>Jena Karlis</h3>
                                    <h4>Store Owner</h4>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim
                                    fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem
                                    dolore labore illum veniam.
                                </p>
                                <div class="profile mt-auto">
                                    <img src="{{ asset('/public/edak') }}/assets/img/testimonials/testimonials-4.jpg"
                                        class="testimonial-img" alt="">
                                    <h3>Matt Brandon</h3>
                                    <h4>Freelancer</h4>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                        class="bi bi-star-fill"></i>
                                </div>
                                <p>
                                    Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster
                                    veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam
                                    culpa fore nisi cillum quid.
                                </p>
                                <div class="profile mt-auto">
                                    <img src="{{ asset('/public/edak') }}/assets/img/testimonials/testimonials-5.jpg"
                                        class="testimonial-img" alt="">
                                    <h3>John Larson</h3>
                                    <h4>Entrepreneur</h4>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section><!-- End Testimonials Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <h2>টিম</h2>
                    <p>আমাদের পরিশ্রমী দলের সদস্যরা </p>
                </header>

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="100">
                        <div class="member">
                            <div class="member-img">
                                <img src="{{ asset('/public/edak') }}/assets/img/team/team-1.jpg" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>আলীমুশ্বান সাইমুন</h4>
                                <span>ব্যবস্থাপনা পরিচালক</span>
                                <p></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="member">
                            <div class="member-img">
                                <img src="{{ asset('/public/edak') }}/assets/img/team/team-2.jpg" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>রাহাত ইবনে মিজান</h4>
                                <span>ডেপুটি ব্যবস্থাপনা পরিচালক</span>
                                <p></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="300">
                        <div class="member">
                            <div class="member-img">
                                <img src="{{ asset('/public/edak') }}/assets/img/team/team-3.jpg" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>মোঃ রাসেল হুসেইন</h4>
                                <span>মার্কেটিং পরিচালক</span>
                                <p></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="400">
                        <div class="member">
                            <div class="member-img">
                                <img src="{{ asset('/public/edak') }}/assets/img/team/team-4.jpg" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>মোহাম্মাদ শামিম খান</h4>
                                <span>নির্বাহী পরিচালক</span>
                                <p></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End Team Section -->



        <!-- ======= Recent Blog Posts Section ======= -->
        <section id="blog" class="recent-blog-posts">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <!-- <h2>Blog</h2> -->
                    <p>আমাদের নিয়ে মিডিয়াতে লেখা হয়েছে</p>
                </header>

                <div class="row">

                    <div class="col-lg-4">
                        <div class="post-box">
                            <div class="post-img"><img src="{{ asset('/public/edak') }}/assets/img/blog/blog-1.jpg"
                                    class="img-fluid" alt=""></div>
                            <span class="post-date">Tue, September 15</span>
                            <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur
                                sit</h3>
                            <a href="blog-single.html" class="readmore stretched-link mt-auto"><span>Read
                                    More</span><i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="post-box">
                            <div class="post-img"><img src="{{ asset('/public/edak') }}/assets/img/blog/blog-2.jpg"
                                    class="img-fluid" alt=""></div>
                            <span class="post-date">Fri, August 28</span>
                            <h3 class="post-title">Et repellendus molestiae qui est sed omnis voluptates magnam</h3>
                            <a href="blog-single.html" class="readmore stretched-link mt-auto"><span>Read
                                    More</span><i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="post-box">
                            <div class="post-img"><img src="{{ asset('/public/edak') }}/assets/img/blog/blog-3.jpg"
                                    class="img-fluid" alt=""></div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Quia assumenda est et veritatis aut quae</h3>
                            <a href="blog-single.html" class="readmore stretched-link mt-auto"><span>Read
                                    More</span><i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End Recent Blog Posts Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <!--  <h2>Contact</h2> -->
                    <p>যোগাযোগ করুন </p>
                </header>

                <div class="row gy-4">

                    <div class="col-lg-6">

                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>অফিসঃ</h3>
                                    <p>৩৪/সি/১, পূর্ব নয়াটোলা, মগবাজার, ঢাকা-১২১৭ [ আবুল হোটেলের পিছনের সাইডে, পূর্ব
                                        নয়াটোলা জামে মসজিদ এর নিকটে ] </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-telephone"></i>
                                    <h3>আমাদের কল করুন</h3>
                                    <p>01322666310
                                        <br>01845522500<br>
                                        01777524090
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-envelope"></i>
                                    <h3>
                                        আমাদের ইমেইল করুন</h3>
                                    <p> contact@edakcourier.com<br>
                                        info.edakcourier@gmail.com<br>
                                        delivery.edakcourier@gmail.com</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-clock"></i>
                                    <h3>খোলা ঘন্টা</h3>
                                    <p>শনিবার - শুক্রবার<br>৮.০০ AM - ৮. ০০ PM</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <form action="forms/contact.php" method="post" class="php-email-form">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Your Name" required>
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Your Email" required>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>

            </div>

        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5 col-md-12 footer-info">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <img src="{{ asset('/public/edak') }}/assets/img/logo.png" alt=""
                                width="100" height="600">

                        </a>
                        <p>ই-ডাক কুরিয়ার সারা দেশে চিঠি,ডকুমেন্ট, ইলেকট্রিক্যাল, ইলেকট্রনিক্স, ফ্যাশন এক্সেসরিজ,
                            কসমেটিকস, মেশিনারিজ, ফ্রুটস, এবং ঢাকা সিটিতে বেবি ফুড, রান্নাকরা খাবার, ফ্রোজেন ফুড,
                            ডেলিভারি করে থাকে।</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Registration Form</h4>

                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a
                                    href="https://edakcourier.com/system/register">Merchant Registration</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a
                                    href="https://edakcourier.com/system/agent-registration">Agent Registration</a>
                            </li>
                            <li><i class="bi bi-chevron-right"></i> <a
                                    href="https://edakcourier.com/system/rider-registration">Rider Registration</a>
                            </li>
                            <!-- <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li> -->
                        </ul>
                    </div>
                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Food Delivery</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Parcel Delivery</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Parcel On Demand</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Courier Delivery</a></li>

                        </ul>
                    </div>

                    <!--    <div class="col-lg-2 col-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div> -->
                    <!--
          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br><br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>

          </div> -->

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                <b> &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script> <strong><span><b>edak Courier</span></strong>. All Rights Reserved. |
                    Develop by <a href="https://creativesoftware.com.bd">Creative Software</a>.
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->

            </div>
        </div>
    </footer><!-- End Footer -->

    <script src="{{ asset('/public/Superend') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('/public/Superend') }}/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="{{ asset('/public/Superend') }}/js/jquery-ui.js"></script>
    <script src="{{ asset('/public/Superend') }}/js/popper.min.js"></script>
    <script src="{{ asset('/public/Superend') }}/js/bootstrap.min.js"></script>





    <!-- Vendor JS Files -->
    <script src="{{ asset('/public/edak') }}/assets/vendor/purecounter/purecounter.js"></script>
    <script src="{{ asset('/public/edak') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('/public/edak') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/public/edak') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('/public/edak') }}/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('/public/edak') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('/public/edak') }}/assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('/public/edak') }}/assets/js/main.js"></script>
</body>

</html>
