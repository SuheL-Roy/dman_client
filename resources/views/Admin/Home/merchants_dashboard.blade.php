<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name') }} || Merchant Dashboard</title>
    @php
        $data = App\Admin\Company::first();
    @endphp
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($data->logo) }}">
    <link rel="stylesheet" href="style.css" />
    <!-- Boxiocns CDN Link -->



    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        /* Google Fonts Import Link */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        .card {
            margin-bottom: 15px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            background: #11101d;
            z-index: 100;
            transition: all 0.5s ease;
        }

        .sidebar.close {
            width: 78px;
        }

        /* Add this CSS */

        .sidebar:hover {
            width: 260px;
        }

        .sidebar.close:hover .logo-details .logo_name,
        .sidebar.close:hover .nav-links li a .link_name {
            opacity: 1;
            pointer-events: auto;
        }

        .sidebar .logo-details {
            height: 60px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .sidebar .logo-details i {
            font-size: 30px;
            color: #fff;
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
        }

        .sidebar .logo-details .logo_name {
            font-size: 18px;
            color: #fff;
            font-weight: 600;
            transition: 0.3s ease;
            transition-delay: 0.1s;
        }

        .sidebar.close .logo-details .logo_name {
            transition-delay: 0s;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links {
            height: 100%;
            padding: 30px 0 150px 0;
            overflow: auto;
        }

        .sidebar.close .nav-links {
            overflow: visible;
        }

        .sidebar .nav-links::-webkit-scrollbar {
            display: none;
        }

        .sidebar .nav-links li {
            position: relative;
            list-style: none;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li:hover {
            background: #1d1b31;
        }

        .sidebar .nav-links li .iocn-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar.close .nav-links li .iocn-link {
            display: block;
        }

        .sidebar .nav-links li i {
            height: 50px;
            min-width: 78px;
            text-align: center;
            line-height: 50px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li.showMenu i.arrow {
            transform: rotate(-180deg);
        }

        .sidebar.close .nav-links i.arrow {
            display: none;
        }

        .sidebar .nav-links li a {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-links li a .link_name {
            font-size: 14px;
            font-weight: 400;
            color: #fff;
            transition: all 0.4s ease;
        }

        .sidebar.close .nav-links li a .link_name {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li .sub-menu {
            padding: 6px 6px 14px 80px;
            margin-top: -10px;
            background: #1d1b31;
            display: none;
        }

        .sidebar .nav-links li.showMenu .sub-menu {
            display: block;
        }

        .sidebar .nav-links li .sub-menu a {
            color: #fff;
            font-size: 15px;
            padding: 5px 0;
            white-space: nowrap;
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links li .sub-menu a:hover {
            opacity: 1;
        }

        .sidebar.close .nav-links li .sub-menu {
            position: absolute;
            left: 100%;
            top: -10px;
            margin-top: 0;
            padding: 10px 20px;
            border-radius: 0 6px 6px 0;
            opacity: 0;
            display: block;
            pointer-events: none;
            transition: 0s;
        }

        .sidebar.close .nav-links li:hover .sub-menu {
            top: 0;
            opacity: 1;
            pointer-events: auto;
            transition: all 0.4s ease;
        }

        .sidebar .nav-links li .sub-menu .link_name {
            display: none;
        }

        .sidebar.close .nav-links li .sub-menu .link_name {
            font-size: 18px;
            opacity: 1;
            display: block;
        }

        .sidebar .nav-links li .sub-menu.blank {
            opacity: 1;
            pointer-events: auto;
            padding: 3px 20px 6px 16px;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-links li:hover .sub-menu.blank {
            top: 50%;
            transform: translateY(-50%);
        }

        .sidebar .profile-details {
            position: fixed;
            bottom: 0;
            width: 260px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1d1b31;
            padding: 12px 0;
            transition: all 0.5s ease;
        }

        .sidebar.close .profile-details {
            background: none;
        }

        .sidebar.close .profile-details {
            width: 78px;
        }

        .sidebar .profile-details .profile-content {
            display: flex;
            align-items: center;
        }

        .sidebar .profile-details img {
            height: 52px;
            width: 52px;
            object-fit: cover;
            border-radius: 16px;
            margin: 0 14px 0 12px;
            background: #1d1b31;
            transition: all 0.5s ease;
            object-position: left;
        }

        .sidebar.close .profile-details img {
            padding: 10px;
        }

        .sidebar .profile-details .profile_name,
        .sidebar .profile-details .job {
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar.close .profile-details i,
        .sidebar.close .profile-details .profile_name,
        .sidebar.close .profile-details .job {
            display: none;
        }

        .sidebar .profile-details .job {
            font-size: 12px;
        }

        .home-section {
            position: relative;
            background: #e4e9f7;
            height: 100vh;
            left: 260px;
            width: calc(100% - 260px);
            transition: all 0.5s ease;
            padding: 12px;
        }

        .sidebar.close~.home-section {
            left: 78px;
            width: calc(100% - 78px);
        }

        .home-content {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .home-section .home-content .bx-menu,
        .home-section .home-content .text {
            color: #11101d;
            font-size: 35px;
        }

        .home-section .home-content .bx-menu {
            cursor: pointer;
            margin-right: 10px;
        }

        .home-section .home-content .text {
            font-size: 22px;
            font-weight: 600;
        }

        @media screen and (max-width: 400px) {
            .sidebar {
                width: 240px;
            }

            .sidebar.close {
                width: 78px;
            }

            .sidebar .profile-details {
                width: 240px;
            }

            .sidebar.close .profile-details {
                background: none;
            }

            .sidebar.close .profile-details {
                width: 78px;
            }

            .home-section {
                left: 240px;
                width: calc(100% - 240px);
            }

            .sidebar.close~.home-section {
                left: 78px;
                width: calc(100% - 78px);
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style>
        .btn-outline-primary {
            border-color: #000;
            color: #000;
        }

        .btn-outline-primary:hover {
            background-color: black;
            border-color: #fff;
        }

        .slider-image {
            width: auto;
            height: 400px;
            object-fit: cover;
        }

        .card-circle .col-lg-2 {
            width: auto;
        }

        .fw-medium {
            font-weight: 500;
        }

        .cod-left p {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .social_share div {
            background: #fff !important;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: grid;
            place-items: center;
        }

        .social_share i {
            font-size: 1.5rem;
            color: #000;
        }

        .balance-button {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #fafafa;
            border: 1px solid #00b795;
            color: #00b795;
            border-radius: 5px;
            cursor: pointer;
            overflow: hidden;
            transition: background-color 0.3s;
            border-radius: 20px;
        }

        .balance-button .fa,
        .balance-button .balance-text {
            display: inline-block;
            white-space: nowrap;
            transition: transform 0.3s, opacity 0.3s;
        }

        .balance-button:hover {
            background-color: #00b795;
        }

        .balance-button:hover .fa,
        .balance-button:hover .balance-text {
            transform: translateX(-100%);
            opacity: 0;
        }

        .balance-button .balance {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            white-space: nowrap;
            padding: 10px 20px;
            background-color: transparent;
            color: white;
            border-radius: 5px;
            transition: opacity 0.3s;
            opacity: 0;
        }

        .balance-button:hover .balance {
            opacity: 1;
        }

        .delivery_chart .card {
            background-color: none;
            border: none;
            border-left: 5px solid #00b795;
            padding-left: 15px;
        }

        .delivery_chart .card.item-2 {
            border-left: 5px solid #ffa246;
        }

        .delivery_chart .card.item-3 {
            border-left: 5px solid #ef4444 !important;
        }

        .circular-progress {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: conic-gradient(#00b795 0% 50%,
                    #ef4444 50% 70%,
                    #ffa246 70% 100%);
        }

        .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            clip: rect(0px, 200px, 200px, 100px);
        }

        .delivered {
            background: conic-gradient(#00b795 0% 50%, transparent 50%);
        }

        .cancelled {
            background: conic-gradient(#ef4444 0% 20%, transparent 20%);
            transform: rotate(180deg);
        }

        .returned {
            background: conic-gradient(#ffa246 0% 30%, transparent 30%);
            transform: rotate(270deg);
        }

        @media screen and (max-width: 600px) {
            .col-12 {
                width: 100% !important;
            }

            .cod-text {
                font-size: 18px;
            }

            .payment_sent {
                font-size: 14px;
            }

            .value_text {
                font-size: 16px !important;
            }

            .value_text_large {
                font-size: 22px !important;
            }

            .footer_text {
                flex-direction: column !important;
                font-size: 16px !important;
            }

            .payment_card {
                margin-top: 10px;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let arrow = document.querySelectorAll(".arrow");
            let sidebar = document.querySelector(".sidebar");
            let sidebarBtn = document.querySelector(".bx-menu");

            arrow.forEach((a) => {
                a.addEventListener("click", (e) => {
                    // Close all sub-menus
                    document.querySelectorAll(".nav-links li").forEach((li) => {
                        if (li !== e.target.closest("li")) {
                            li.classList.remove("showMenu");
                        }
                    });
                    // Toggle the clicked sub-menu
                    let arrowParent = e.target.parentElement.parentElement;
                    arrowParent.classList.toggle("showMenu");
                });
            });

            sidebarBtn.addEventListener("click", () => {
                sidebar.classList.toggle("close");
            });

            // Close the sidebar when clicking anywhere on the page
            document.addEventListener("click", (e) => {
                if (!sidebar.contains(e.target) && !sidebarBtn.contains(e.target)) {
                    sidebar.classList.add("close");
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class="bx bxl-c-plus-plus"></i>
            @php
                $data = App\Admin\Company::first();
            @endphp
            <span class="logo_name">{{ $data->name }}</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('merchant.panel.merchant_dashboard') }}">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>



            </li>
            <li>
                <a href="{{ route('order.create_order_list') }}">
                    <i class="fa fa-archive"></i>
                    <span class="link_name">Parcel List</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">All Parcel List</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('order.backup_create') }}">
                    <i class="fa fa-plus"></i>
                    <span class="link_name">Add Parcel</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Add Parcel</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('csv-file-upload-merchants') }}">
                    <i class="fa fa-plus"></i>
                    <span class="link_name">Bulk Import</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Bulk Import</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="fa fa-file-text"></i>
                        <span class="link_name">Report</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Report</a></li>
                    <li><a href="{{ route('order.report.datewise') }}">Parcel History</a></li>
                    <li><a href="{{ route('order.report.return.datewise') }}">Return History</a></li>
                    <li><a href="{{ route('merchent.pay.information.index') }}">Payment History</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bx-cog"></i>
                        <span class="link_name">Profile</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                @php
                    $data = App\Admin\PaymentInfo::where('user_id', Auth::user()->id)->exists();
                @endphp
                <ul class="sub-menu">
                    <li><a class="link_name" href="">Profile</a></li>
                    <li><a href="{{ route('merchant.profile.updation') }}">Profile</a></li>
                    <li><a href="{{ route('merchant.complain') }}">Add Ticket</a></li>
                    @if ($data)
                    @else
                        <li><a href="{{ route('merchant.payment.info.add') }}">Add Payment Method</a>
                        </li>
                    @endif
                    <li><a href="{{ route('change.password') }}">Change password</a></li>

                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </li>
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <img src="{{ asset('/Company/Icon/icon.png') }}" alt="profileImg" />
                    </div>

                    <div class="name-job">
                        <div class="profile_name">{{ auth()->user()->name }}</div>
                       
                       
                    </div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>

    <section class="home-section" style="overflow: scroll; overflow-x: hidden">


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('pickup_request') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">PickUp Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label for="pick_up_address"
                                    class="col-lg-4 col-md-4 col-sm-4 col-form-label text-end">
                                    PickUp Address <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" id="pick_up_address" name="pick_up_address"
                                        class="form-control pick-up" placeholder="Pick up Address" readonly
                                        required />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="note" class="col-lg-4 col-md-4 col-sm-4 col-form-label text-end">
                                    Note <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" id="note" name="Note" class="form-control"
                                        placeholder="Note" required />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="estimated_parcel"
                                    class="col-lg-4 col-md-4 col-sm-4 col-form-label text-end">
                                    Estimated Parcel (Optional)
                                </label>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" id="estimated_parcel" name="estimated_parcel"
                                        class="form-control" placeholder="Estimated Parcel" />
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button class="btn btn-success btn-sm" type="submit">Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="PrimaryModalalert12" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('payment_request') }}" method="POST">
                        @csrf
                        <div class="modal-header bg-color-1">
                            <h5 class="modal-title" id="exampleModalLabel">Payment Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label for="payment_method" class="col-sm-5 col-form-label">Payment method <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bkash">Bkash</option>
                                        <option value="Rocket">Rocket</option>
                                        <option value="Nagad">Nagad</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning btn-sm"
                                data-bs-dismiss="modal">Close</button>
                            <button type="reset" class="btn btn-danger btn-sm">Clear</button>
                            <button type="submit" class="btn btn-success btn-sm">Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <div class="home-content gap-3">
                <div class="d-flex">
                    <i class="bx bx-menu menu_icon"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div
                    style="
              background-color: white;
              padding: 10px 20px;
              border: 1px solid lightgray;
              border-radius: 20px;
            ">
                    <i class="fa fa-search me-2"></i>
                    <input type="text" class="border-none mt-1" placeholder="Search Consignment"
                        style="background: none; outline: none; border: none" />
                </div>
                <button class="balance-button">
                    <i class="fa fa-hand-pointer-o"></i>
                    <span class="balance-text">Check Balance</span>
                    <span class="balance">৳ {{ $paymentProcessing }}</span>
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="text-dark text-decoration-none" href="#">Merchant</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            {{-- 
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    @foreach ($slider as $item)
                        <div class="carousel-item active">
                            <img src="{{ asset($item->image) }}" class="d-block w-100 slider-image"
                                alt="..." />
                        </div>
                    @endforeach
                    <div class="carousel-item active">
                        <img src="{{ asset('/Company/slider.jpg') }}" class="d-block w-100 slider-image"
                            alt="..." />
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('/Company/slider.jpg') }}" class="d-block w-100 slider-image"
                            alt="..." />
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('/Company/slider.jpg') }}" class="d-block w-100 slider-image"
                            alt="..." />
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div> --}}

            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($slider as $index => $item)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                            aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($slider as $index => $item)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset($item->image) }}" class="d-block w-100 slider-image"
                                alt="..." />
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>
        <div class="row my-3">
            <div class="col-lg-4">
                <a style="text-decoration: none; color:black;" href="{{ route('order.backup_create') }}">
                    <div class="d-grid card p-5" style="place-items: center">
                        <div class="p-3 px-4 mb-3" style="background-color: #e5f7f4; border-radius: 15px">
                            <i class="fa fa-archive" aria-hidden="true" style="color: #00b795; font-size: 40px"></i>
                        </div>
                        <p class="mb-0" style="font-size: 22px; font-weight: 500">
                            Add Parcel
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="#" style="text-decoration: none; color:black;" class="ediT" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <div class="d-grid card p-5" style="place-items: center">
                        <div class="p-3 px-4 mb-3" style="background-color: #fefce8; border-radius: 15px">
                            <i class="fa fa-truck" aria-hidden="true" style="color: #f97316; font-size: 40px"></i>
                        </div>

                        <p class="mb-0" style="font-size: 22px; font-weight: 500">
                            Pickup Request
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4">
                <a href="#" style="text-decoration: none; color:black;" class="ediT" data-bs-toggle="modal"
                    data-bs-target="#PrimaryModalalert12">
                    <div class="d-grid card p-5" style="place-items: center">
                        <div class="p-3 px-4 mb-3" style="background-color: #eff6ff; border-radius: 15px">
                            <i class="fa fa-credit-card" aria-hidden="true"
                                style="color: #3b82f6; font-size: 40px"></i>
                        </div>
                        <p class="mb-0" style="font-size: 22px; font-weight: 500">
                            Payment Request
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="row card-circle my-3 pt-3 bg-white mx-1 justify-content-center">
            <div class="col-lg-2 col-md-12 col-12">
                <div class="p-4 d-flex flex-column align-items-center">
                    <div
                        style="
                background: #f5f8fa;
                border-radius: 50%;
                width: 70px;
                height: 70px;
                display: grid;
                place-items: center;
              ">
                        <i class="fa fa-archive" style="font-size: 30px; color: #6c7780"></i>
                    </div>
                    <p class="mb-0 mt-2 text-dark" style="font-size: 19px; font-weight: 500">
                        At Sorting
                    </p>
                    <p class="mb-0 text-center text-secondary">{{ $total_sorting }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <div class="p-4 d-flex flex-column align-items-center">
                    <div
                        style="
                background: #fff8f1;
                border-radius: 50%;
                width: 70px;
                height: 70px;
                display: grid;
                place-items: center;
              ">
                        <i class="fa fa-truck" style="font-size: 30px; color: #ffa246"></i>
                    </div>
                    <p class="mb-0 mt-2 text-dark" style="font-size: 19px; font-weight: 500">
                        In Trasit
                    </p>
                    <p class="mb-0 text-center text-secondary">{{ $total_transit }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <div class="p-4 d-flex flex-column align-items-center">
                    <div
                        style="
                background: #f3f8ff;
                border-radius: 50%;
                width: 70px;
                height: 70px;
                display: grid;
                place-items: center;
              ">
                        <i class="fa fa-map-marker" style="font-size: 30px; color: #4576b5"></i>
                    </div>
                    <p class="mb-0 mt-2 text-dark" style="font-size: 19px; font-weight: 500">
                        At Delivery Hub
                    </p>
                    <p class="mb-0 text-center text-secondary">{{ $total_delivery_hub }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <div class="p-4 d-flex flex-column align-items-center">
                    <div
                        style="
                background: #edfaef;
                border-radius: 50%;
                width: 70px;
                height: 70px;
                display: grid;
                place-items: center;
              ">
                        <i class="fa fa-bus" style="font-size: 30px; color: #8fc892"></i>
                    </div>
                    <p class="mb-0 mt-2 text-dark" style="font-size: 19px; font-weight: 500">
                        Assigned For Delivery
                    </p>
                    <p class="mb-0 text-center text-secondary">{{ $total_assign_for_delivery }}</p>
                </div>
            </div>

            <div class="col-lg-2 col-12">
                <div class="p-4 d-flex flex-column align-items-center">
                    <div
                        style="
                background: #fff8f1;
                border-radius: 50%;
                width: 70px;
                height: 70px;
                display: grid;
                place-items: center;
              ">
                        <i class="fa fa-circle" style="font-size: 30px; color: #e83633"></i>
                    </div>
                    <p class="mb-0 mt-2 text-dark" style="font-size: 19px; font-weight: 500">
                        On Hold
                    </p>
                    <p class="mb-0 text-center text-secondary">{{ $total_on_hold }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <h2 class="mt-2 mb-3 cod-text">Cash on Delivery (COD) Details</h2>
            <div class="col-lg-6 cod-left">
                <div class="card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <p>Last invoice date</p>
                        <p class="fw-medium">
                            {{ \Carbon\Carbon::parse($latestPayment->updated_at ?? '')->format('d-m-Y') }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p>Payment sent to you</p>
                        <p class="fw-medium">৳{{ $latestPayment->t_payable ?? '' }}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p>Payment done via</p>
                        <p class="fw-medium">Cash</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p>Lifetime earning</p>
                        <p class="fw-medium">৳{{ $life_time_payment ?? '' }}</p>
                    </div>
                    <div class="card p-2 payment_card" style="background: lightblue">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="p-2" style="background: rgb(14, 127, 165); border-radius: 2px">
                                <i class="fa fa-info text-white"></i>
                            </div>
                            <span class="payment_sent">A payment of ৳{{ $paymentProcessing ?? '' }} is currenly in
                                process
                                to be sent to your
                                bank/mfs account</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card p-4">
                    <div>
                        <p class="mb-0 fw-medium">Payment in Review</p>
                        <p>৳{{ $paymentProcessing }}</p>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">Payment Preparing for invoice</p>
                        <p>৳0</p>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-outline-danger">Details</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3 bg-white py-5">
            <div class="col-md-3 mb-3">
                <div class="d-flex ms-5">
                    <div class="circular-progress">
                        <div class="circle delivered"></div>
                        <div class="circle cancelled"></div>
                        <div class="circle returned"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row delivery_chart">
                    <div class="col-md-4">
                        <div class="card item-1">
                            <p class="text-secondary mb-2">Delivered</p>
                            <p class="text-dark mb-2" style="font-size: 32px; font-weight: 500">
                                {{ $total_delivery_success_ratio }}%
                            </p>
                            <p>{{ $total_delivered_order }} orders | ৳{{ $total_collect }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card item-2">
                            <p class="text-secondary mb-2">Processing</p>
                            <p class="text-dark mb-2" style="font-size: 32px; font-weight: 500">
                                {{ $total_delivery_unsuccess_ratio }}%
                            </p>
                            <p>{{ $totalorderTransit }} orders | ৳{{ $total_transit_amount }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card item-3">
                            <p class="text-secondary mb-2">Returned</p>
                            <p class="text-dark mb-2" style="font-size: 32px; font-weight: 500">
                                {{ $total_delivery_return_ratio }}%
                            </p>
                            <p class="mb-2">{{ $total_return }} orders | ৳{{ $total_return_amount }}</p>
                            <p>
                                ({{ $total_return }} <span style="color: #ffa246">orders</span> under
                                processing)
                            </p>
                        </div>
                    </div>

                    <p style="font-size: 20px" class="value_text">
                        TOTAL VALUE:
                        <span style="font-size: 30px; font-weight: 500"
                            class="text-dark me-1 value_text_large">৳{{ $all_collection }}
                        </span>
                        (<span style="color: #00b795">{{ $all_order_count }}</span> Orders)
                    </p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-end social_share my-3">
            <div>
                <a href="https://www.facebook.com/dmanofficialbd" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </div>
            <div>
                <a href="https://www.linkedin.com/company/dman-delivery-service" target="_blank">
                    <i class="fa fa-linkedin"></i>
                </a>
            </div>
          
        </div>
        <div class="card flex-row my-3 p-3 w-100 justify-content-center footer_text"
            style="background-color: #e5f7f4; font-size: 18px">
            &copy; 2024 All rights reserved by <a class="ms-1 text-decoration-none" style="color: #4576b5"
                href="#" target="_blank"> {{ config('app.name') }}</a></span> &nbsp;| &nbsp;
            <span>Developed By
                <a class="ms-1 text-decoration-none" style="color: #4576b5"
                    href="https://www.creativesoftware.com.bd/" target="_blank">Courier Lab
                </a></span>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 10000;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 10000;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }
        @endif
    </script>
    <script>
        $(document).ready(function() {

            $('.ediT').on('click', function() {

                $.ajax({
                    type: "GET",
                    url: "{{ route('pickup_address') }}",
                    success: function(data) {
                        $('.pick-up').val(data[0]['address']);

                    }
                });

            });
        });
    </script>


    <!-- <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script> -->

    <!-- <script src="script.js"></script> -->
</body>

</html>
