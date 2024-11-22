<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>{{ config('app.name') }} || Super Admin Dashboard</title>
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
            {{-- <span class="logo_name">{{ $data->name }}</span> --}}
            <span class="logo_name">  <img class="main-logo" src="{{ asset($data->logo) ?? asset('Company/Logo/logo.png') }}" alt=""
                style="width:134px; padding: 5px;" /> </span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.panel.super.dashboard.new') }}">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>

            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bx-cog"></i>
                        <span class="link_name">Configuration</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Configuration</a></li>
                    <li><a href="{{ route('company.index') }}">Company Info</a></li>
                    <li><a href="{{ route('Expense.index') }}">Expense Type</a></li>
                    <li><a href="{{ route('Income.index') }}">Income Type</a></li>
                    <li><a href="{{ route('business.type.index') }}">Business Type</a></li>
                    <li><a href="{{ route('order.delivery_category') }}">Reason Category</a></li>
                    <li><a href="{{ route('category.index') }}">Order Category </a></li>
                    <li><a href="{{ route('coverage.area.index') }}">Area Management</a></li>
                    <li><a href="{{ route('district.list.index') }}">District Management</a></li>
                    <li><a href="{{ route('branch_district.list.index') }}">Branch Management</a></li>
                    <li><a href="{{ route('weight_price.index') }}">Charge Management</a></li>
                    <li><a href="{{ route('order.status.list.index') }}">Status Change for Rider</a></li>
                    <li><a href="{{ route('notice.index') }}">Notice Management</a></li>
                    <li><a href="{{ route('pickup.index') }}">Pickup Time Management</a></li>
                    <li><a href="{{ route('slider.index') }}">Slider Management</a></li>
                    <li><a href="{{ route('scheduler.index') }}">Scheduler for Merchant</a></li>
                    <li><a href="{{ route('autoassign.index') }}">Auto Assign for Rider</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bxs-user user-icon"></i>
                        <span class="link_name">Team</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Team</a></li>
                    <li><a href="{{ route('shop.merchant.password_manage') }}">User Password Manage</a></li>
                    <li><a href="{{ route('shop.merchant.index') }}">Merchant Information</a></li>
                    <li><a href="{{ route('agent.index') }}">Branch Information</a></li>
                    <li><a href="{{ route('rider.index') }}">Rider Information</a></li>
                    <li><a href="{{ route('admin.panel.register') }}">Executive Information</a></li>

                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bx-sidebar"></i>
                        <span class="link_name">Parcel</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Parcel</a></li>
                    <li><a href="{{ route('order.report.filtering') }}">Pickup Request List</a></li>
                    <li><a href="{{ route('pickup_request_list') }}">Parcel Request List</a></li>
                    <li><a href="{{ route('order.list.order_list_new') }}">All Parcel List</a></li>
                    {{-- <li><a href="{{ route('order.list.index') }}">All Parcel List2</a></li> --}}
                    <li><a href="{{ route('order.backup_create') }}">Add Parcel</a></li>
                    <li><a href="{{ route('delivery.assign.order_export') }}">Order Export</a></li>
                    <li><a href="{{ route('csv-file-upload') }}">Bulk Import</a></li>
                    {{-- <li><a href="{{ route('csv-file-upload-express') }}">Express Bulk Import</a></li> --}}
                </ul>
            </li>



            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bx-folder"></i>
                        <span class="link_name">Operation</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Operation</a></li>
                    <li><a href="{{ route('order.collection.hub') }}">Parcel Fulfillment</a></li>
                    <li><a href="{{ route('order.transfer_index') }}">Transfer To Hub</a></li>
                    <li><a href="{{ route('admin.return.to.hub_index') }}">Return To Hub</a></li>
                    <li><a href="{{ route('delivery.assign.branch.list') }}">Delivery Processing for Branch</a></li>
                    <li><a href="{{ route('rider.transfer.pickup.index') }}">Pickup transfer</a></li>
                    <li><a href="{{ route('rider.transfer.delivery.index') }}">Delivery transfer</a></li>

                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bxs-home-smile"></i>
                        <span class="link_name">3PL Operation</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">3PL Operation</a></li>
                    <li><a href="{{ route('order.transfer_to_third_party') }}">Transfer To Redx</a></li>
                    <li><a href="{{ route('order.transfer_to_third_pathao') }}">Transfer To Pathao</a></li>
                    <li><a href="{{ route('pathao_transfer_list') }}">ThirdParty Transfer List</a></li>
                    <li><a href="{{ route('third_party_delivery_cancel_list') }}">ThirdParty Delivery and Cancel
                            List</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bxs-basket"></i>
                        <span class="link_name">HR & Payroll</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">HR & Payroll</a></li>
                    <li><a href="{{ route('rider.attendance.index') }}">Rider Attendance</a></li>
                    <li><a href="{{ route('employee.attendance.index') }}">Employee Attendance</a></li>
                    <li><a href="{{ route('rider.attendance.daily.attendance') }}">Daily Attendance</a></li>
                    <li><a href="{{ route('rider.attendance.monthly.attendance.all.employee') }}">Monthly
                            Attendance</a></li>
                    <li><a href="{{ route('rider.attendance.monthly.attendance') }}">Employee Wise Attendance</a></li>
                    <li><a href="{{ route('rider.attendance.date_wise.attendance') }}">Branch Wise Attendance</a></li>
                    <li><a href="{{ route('rider.attendance.branch.wise.monthly.attendance') }}">Branch Wise Monthly
                            Attendance</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bxs-user user-icon"></i>
                        <span class="link_name">Accounts</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Accounts</a></li>
                    <li><a href="{{ route('agent.collect.index') }}">Branch Collection</a></li>
                    <li><a href="{{ route('payment_request_list') }}">Payment Request List</a></li>
                    <li><a href="{{ route('accounts.merchant.payment') }}">Invoice Processing</a></li>
                    <li><a href="{{ route('accounts.merchant.advance.payment') }}">Advance Payment</a></li>
                    <li><a href="{{ route('merchant.payment.collect.index') }}">Merchant Payment</a></li>
                    <li><a href="{{ route('rider.payment.collect.index') }}">Rider Payment Processing</a></li>
                    <li><a href="{{ route('branch.payment.collect.index') }}">Branch Payment Processing</a></li>
                    <li><a href="{{ route('accounts.branch.payment') }}">Branch Payment</a></li>
                    <li><a href="{{ route('accounts.rider.payment') }}">Rider Payment</a></li>
                    <li><a href="{{ route('Expense.list') }}">Expense Management</a></li>
                    <li><a href="{{ route('Income.list') }}">Income Management</a></li>
                    <li><a href="{{ route('accounts.merchant.paymentinfo') }}">Merchant Payment Update</a></li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bxs-report"></i>
                        <span class="link_name">Report</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Report</a></li>
                    <li><a href="{{ route('merchent.pay.information.index') }}">Merchant Payment History</a></li>
                    <li><a href="{{ route('order.report.daily_collection_report') }}">Merchant Wise Revenue Report</a>
                    </li>
                    <li><a href="{{ route('order.report.daily_collection_report_date_wise') }}">Dae Wise Revenue
                            Report</a></li>
                    <li><a href="{{ route('order.report.agent.transfer.history.index') }}">Hub Transaction History</a>
                    </li>
                    <li><a href="{{ route('order.report.rider.status.date') }}">Rider History</a></li>
                    <li><a href="{{ route('complain.report') }}">Tickets Report</a></li>
                    <li><a href="{{ route('Expense.report') }}">Expense Report</a></li>
                    <li><a href="{{ route('Income.report') }}">Income Report</a></li>
                    <li><a href="{{ route('Summary.view') }}">Income & Expense Summary Report</a></li>
                    <li><a href="{{ route('order.report.agent.transaction.report') }}">Rider Collect History</a></li>
                    <li><a href="{{ route('order.report.collected') }}">Transfer History</a></li>
                    <li><a href="{{ route('order.report.merchantwise') }}">Merchant History</a></li>
                    <li><a href="{{ route('order.report.admin.agent.history') }}">Hub History</a></li>
                    <li><a href="{{ route('merchant.payment.adjustment') }}">Merchant Adjustment</a></li>
                    <li><a href="{{ route('merchant.advance.payment') }}">Advance Payment</a></li>
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
                        <img src="{{ asset('/Company/white.png') }}" alt="profileImg" />
                    </div>
                    <div class="name-job">
                        @if (auth()->user()->role == '1')
                            <div class="profile_name">Super Admin</div>
                        @endif
                        <div class="job">Creative Software</div>
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
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayOrderPlaced }}</h2>
                                <p class="my-0" style="text-align: center;">Today New Order</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayPickupDone }}</h2>
                                <p class="my-0">Today Total Pickup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayOneHourPickup }}</h2>
                                <p class="my-0">Today One Hour Pickup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TodayRegularPickup }}</h2>
                                <p class="my-0">Today Regular PickUp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TodayRegularDelivery }}</h2>
                                <p class="my-0">Today Regular Delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TodayUrgentDelivery }}</h2>
                                <p class="my-0">Today One Hour Delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayOrdercancel }}</h2>
                                <p class="my-0">Today Order Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TodayPCl }}</h2>
                                <p class="my-0">Today PickUp Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Today Delivery Charge</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayPickupAmount }}</h2>
                                <p class="my-0">Today Pickup Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayOrderCancelAmount }}</h2>
                                <p class="my-0">Today Cancel Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todayPaid }}</h2>
                                <p class="my-0">Today Paid </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Today Due Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Today Delivery Return</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Today Hold & Rescheduled</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Today Delivery Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todays_total_delivery_success_ratio }}%</h2>
                                <p class="my-0">Today Successfull Ratio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $todays_total_delivery_unsuccess_ratio }}%</h2>
                                <p class="my-0">Today Pending Ratio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $today_total_merchant_payment_processing }}</h2>
                                <p class="my-0">Today Payment Processing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $today_total_paid_amount }}</h2>
                                <p class="my-0">Total Paid Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $today_pickup_request }}</h2>
                                <p class="my-0">Today Pickup Request</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $today_payment_request }}</h2>
                                <p class="my-0">Today Payment Request</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>







        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalOrderPlaced }}</h2>
                                <p class="my-0" style="text-align: center;">Total New Order</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalPickupDone }}</h2>
                                <p class="my-0">Total Pickup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalOneHourPickup }}</h2>
                                <p class="my-0">Total One Hour Pickup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TotalRegularPickup }}</h2>
                                <p class="my-0">Total Regular PickUp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TotalRegularDelivery }}</h2>
                                <p class="my-0">Total Regular Delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TotalUrgentDelivery }}</h2>
                                <p class="my-0">Total One Hour Delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalOrdercancel }}</h2>
                                <p class="my-0">Total Order Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-truck"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $TotalPCl }}</h2>
                                <p class="my-0">Total PickUp Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Total Delivery Charge</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalPickupAmount }}</h2>
                                <p class="my-0">Total Pickup Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalOrderCancelAmount }}</h2>
                                <p class="my-0">Total Cancel Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $totalPaid }}</h2>
                                <p class="my-0">Total Paid</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Total Due Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Total Delivery Return</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Total Hold & Rescheduled</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">0</h2>
                                <p class="my-0">Total Delivery Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $total_delivery_success_ratio }}%</h2>
                                <p class="my-0">Total Successfull Ratio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $total_delivery_unsuccess_ratio }}%</h2>
                                <p class="my-0">Total Pending Ratio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $total_merchant_payment_processing }}</h2>
                                <p class="my-0">Total Payment Processing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $total_paid_amount }}</h2>
                                <p class="my-0">Total Paid Amount</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $total_pickup_request }}</h2>
                                <p class="my-0">Total Pickup Request</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card py-3">
                    <div class="d-grid" style="place-items: center">
                        <div class="d-flex align-items-center gap-2">
                            <i style="color: #0bbce5; font-size: 39px" class="fa fa-shopping-cart"></i>
                            <div>
                                <h2 class="mb-0 text-center">{{ $total_payment_request }}</h2>
                                <p class="my-0">Total Payment Request</p>
                            </div>
                        </div>
                    </div>
                </div>
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
