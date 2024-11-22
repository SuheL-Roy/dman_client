<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name') }} || Rider Dashboard</title>
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

        body {
            overflow: hidden;
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
            font-size: 19px;
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
            font-size: 13px;
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
            overflow: auto;
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
            font-size: 14px;
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let arrow = document.querySelectorAll(".arrow");
            let sidebar = document.querySelector(".sidebar");
            let sidebarBtn = document.querySelector(".bx-menu");

            arrow.forEach(a => {
                a.addEventListener("click", (e) => {
                    // Close all sub-menus
                    document.querySelectorAll('.nav-links li').forEach(li => {
                        if (li !== e.target.closest('li')) {
                            li.classList.remove('showMenu');
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
        });
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
                <a href="{{ route('rider.dashboard_new') }}">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>

            </li>
            <li>
                <a href="{{ route('request.assign.list') }}">
                    <i class="fa fa-archive" aria-hidden="true"></i>
                    <span class="link_name">Pickup Parcel List</span>
                </a>

            </li>

            <li>
                <a href="{{ route('request.assign.auto.lists') }}">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                    <span class="link_name">Auto Pick Up List</span>
                </a>

            </li>

            <li>
                <a href="{{ route('delivery.assign.list') }}">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                    <span class="link_name">Delivery Parcel List</span>
                </a>

            </li>

            <li>
                <a href="{{ route('delivery.assign.hold_reschedule') }}">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                    <span class="link_name">Reschedule Order</span>
                </a>

            </li>


            <li>
                <a href="{{ route('delivery.assign.transfer') }}">
                    <i class="fa fa-exchange" aria-hidden="true"></i>
                    <span class="link_name">Transfer Order List</span>
                </a>

            </li>

            <li>
                <a href="{{ route('order.return.list') }}">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                    <span class="link_name">Return Parcel List</span>
                </a>

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
                    <li><a href="{{ route('order.report.delivery.rider') }}">Parcel History</a></li>
                    <li><a href="{{ route('order.report.collected') }}">Transfer History</a></li>
                    <li><a href="{{ route('order.report.return.datewise') }}">Return History</a></li>
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
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Profile</a></li>

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
                    @php
                        $data = App\Admin\Company::first();
                    @endphp
                    <div class="profile-content">
                        <img src="{{ asset('/Company/Icon/icon.png') }}" alt="profileImg" />
                    </div>
                    <div class="name-job">
                      <div class="profile_name">{{ auth()->user()->name }}</div>
                    </div>
                    {{-- <a href="#"><i class="bx bx-log-out"></i></a> --}}


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
    <section class="home-section">
        <div class="home-content">
            <i class="bx bx-menu"></i>
            <span class="text">Dashboard</span>
        </div>
        <div class="row mt-3">


            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.delivery.confirm') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-archive"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $today_pickup }}</h2>
                                    <p class="my-0">Today Pickup Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('delivery.assign.list') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-archive"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $today_delivery }}</h2>
                                    <p class="my-0">Today Delivery Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.return.datewise') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-archive"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $today_return }}</h2>
                                    <p class="my-0">Today Return Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.collected') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-archive"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $today_transfer }}</h2>
                                    <p class="my-0">Today Transfer Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.rider.today.delivered') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $today_delivered }}</h2>
                                    <p class="my-0">Today Delivery</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.rider.monthly.delivered') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $monthly_delivered }}</h2>
                                    <p class="my-0">Monthly Delivery</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.delivery.confirm') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $total_pickup }}</h2>
                                    <p class="my-0">Total Pickup Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.delivery.confirm') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $total_delivery }}</h2>
                                    <p class="my-0">Total Delivery Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.return.datewise') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-archive"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $total_return }}</h2>
                                    <p class="my-0">Total Return Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="{{ route('order.report.collected') }}">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-archive"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $total_transfer }}</h2>
                                    <p class="my-0">Total Transfer Request</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-credit-card-alt"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $total_pickup_Collect_ratio }}%</h2>
                                    <p class="my-0">PickUp Collect Ratio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-3">
                <a style="text-decoration: none;" href="">
                    <div class="card py-3">
                        <div class="d-grid" style="place-items: center">
                            <div class="d-flex align-items-center gap-2">
                                <i style="color: #0bbce5; font-size: 39px" class="fa fa-credit-card-alt"></i>
                                <div>
                                    <h2 class="mb-0 text-center">{{ $total_delivery_success_ratio }}%</h2>
                                    <p class="my-0">Success Delivery Ratio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>










        </div>



        <div class="card"></div>
    </section>

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
