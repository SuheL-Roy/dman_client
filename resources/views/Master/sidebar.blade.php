@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp

<div class="left-sidebar-pro">
    <style>
        a:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
            hover: #fff;
        }
    </style>
    <nav id="sidebar" class="">

        <div class="sidebar-header">

            {{-- <a style="hover: rgb(255, 255, 255)" href="{{ url('/') }}"> --}}
            @php
                $data = App\Admin\Company::first();
            @endphp
            <img class="main-logo" src="{{ asset($data->logo) ?? asset('Company/Logo/logo.png') }}" alt=""
                style="width:205px; padding: 5px;" />
            {{-- </a> --}}
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar" style="height: 85vh !important;">

            <nav class="sidebar-nav left-sidebar-menu-pro">
                @can('superAdmin')


                    <ul class="metismenu" id="menu1">
                        <li>
                            <a @if ($route == 'admin.panel.super.dashboard') style="" @endif class="active" title="Admin"
                                href="{{ route('home') }}">
                                <i class="" aria-hidden="true"></i>
                                @if (auth()->user()->role == 1)
                                    <span style="text-align: center; color: green;"> Admin Login: Safe Entry</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'admin.panel.super.dashboard') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                class="active" title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        @cannot('superAdmin')
                            <li class="">
                                <a class="has-arrow" href="#">
                                    <i class="fa big-icon fa-cogs icon-wrap"></i>
                                    <span class="mini-click-non">Setup</span>
                                </a>
                                <ul class="submenu-angle" aria-expanded="true">
                                    <li>
                                        <a title="Shop" href="{{ route('shop.index') }}">
                                            <i class="fa fa-home sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">Shop</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Employee" href="{{ route('employee.index') }}">
                                            <i class="fa fa-user-plus sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">Employee</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="">
                                <a class="has-arrow" href="#">
                                    <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                    <span class="mini-click-non">Order</span>
                                </a>
                                <ul class="submenu-angle" aria-expanded="true">
                                    <li>
                                        <a title="Create Order" href="{{ route('order.create') }}">
                                            <i class="fa fa-cart-plus sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">Add Parcel</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a title="Draft Orders" href="{{ route('order.draft') }}">
                                            <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">Draft Orders</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a title="Confirmed Order" href="{{ route('order.lists') }}">
                                            <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">Confirmed Orders</span>
                                        </a>
                                    </li>

                                    {{-- <li>
                                        <a title="Confirmed Order" href="{{ route('order.list.order_list_new') }}">
                                            <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">New Confirmed Orders</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                        @endcannot
                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-cog icon-wrap"></i>
                                <span class="mini-click-non">Configuration</span>
                            </a>
                            <ul @if (
                                $route == 'company.index' ||
                                    $route == 'business.type.index' ||
                                    $route == 'category.index' ||
                                    $route == 'coverage.area.index' ||
                                    $route == 'zone.index' ||
                                    $route == 'weight_price.index' ||
                                    $route == 'notice.index' ||
                                    $route == 'district.list.index' ||
                                    $route == 'pickup.index' ||
                                    $route == 'problem.index' ||
                                    $route == 'slider.index') class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'company.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Company" href="{{ route('company.index') }}">
                                        <span class="mini-sub-pro">Company Info</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'Expense.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant" href="{{ route('Expense.index') }}">
                                        <span class="mini-click-non">Expense Type </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'Income.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant" href="{{ route('Income.index') }}">
                                        <span class="mini-click-non">Income Type </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'business.type.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Business Type" href="{{ route('business.type.index') }}">
                                        <span class="mini-sub-pro">Business Type</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.delivery_category') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Category" href="{{ route('order.delivery_category') }}">
                                        <span class="mini-sub-pro">Reason Category </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'category.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Category" href="{{ route('category.index') }}">
                                        <span class="mini-sub-pro">Order Category </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'coverage.area.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Coverage Area" href="{{ route('coverage.area.index') }}">
                                        <span class="mini-sub-pro">Area Management </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'district.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Coverage Area" href="{{ route('district.list.index') }}">
                                        <span class="mini-sub-pro">District Management </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'branch_district.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Zone" href="{{ route('branch_district.list.index') }}">
                                        <span class="mini-click-non">Branch Management </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'weight_price.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Weight and Price" href="{{ route('weight_price.index') }}">
                                        <span class="mini-click-non">Charge Management </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.status.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Status Change" href="{{ route('order.status.list.index') }}">
                                        <span class="mini-click-non">Status Change for Rider </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'scheduler.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Scheduler" href="{{ route('scheduler.index') }}">
                                        <span class="mini-click-non">Scheduler for Merchant</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'autoassign.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="AutoAssign" href="{{ route('autoassign.index') }}">
                                        <span class="mini-click-non">Auto Assign for Rider</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'notice.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Notice" href="{{ route('notice.index') }}">
                                        <span class="mini-sub-pro">Notice Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'pickup.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Time" href="{{ route('pickup.index') }}">
                                        <span class="mini-sub-pro">Pickup Time Management </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'problem.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Problem" href="{{ route('problem.index') }}">
                                        <span class="mini-sub-pro">Problem Management</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'slider.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Slider" href="{{ route('slider.index') }}">
                                        <span class="mini-sub-pro">Slider Management</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-user icon-wrap"></i>
                                <span class="mini-click-non">Team Mangement</span>
                            </a>
                            <ul @if (
                                $route == 'shop.merchant.index' ||
                                    $route == 'agent.index' ||
                                    $route == 'rider.index' ||
                                    $route == 'admin.panel.register') {{-- asifislam --}} 
                      
                                class="submenu-angle collapse in"
                                style="background: rgb(222, 232, 241)"

                                @else
                             class="submenu-angle"
                             style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'shop.merchant.password_manage') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant" href="{{ route('shop.merchant.password_manage') }}">
                                        <span class="mini-click-non">User Password Manage</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'shop.merchant.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant" href="{{ route('shop.merchant.index') }}">
                                        <span class="mini-click-non">Merchant Information</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'agent.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agent" href="{{ route('agent.index') }}">
                                        <span class="mini-click-non">Branch Information</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('rider.index') }}">
                                        <span class="mini-click-non">Rider Information</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'admin.panel.register') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Registration" href="{{ route('admin.panel.register') }}">
                                        <span class="mini-sub-pro">Executive Information</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        {{-- <li>
                            <a @if ($route == 'order.list.index') 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirm Order" href="{{ route('order.list.index') }}">
                                <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">All Parcel List</span>
                            </a>
                        </li> --}}

                        @can('superAdmin')
                            <li class="">
                                <a class="has-arrow" href="#">
                                    <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                    <span class="mini-click-non">Parcel Management</span>
                                </a>
                                <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"
                        @else
                        class="submenu-angle"
                        style="background: rgb(131, 218, 245)" @endif
                                    aria-expanded="true">
                                    <li>
                                        <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Confirm Order" href="{{ route('order.list.order_list_new') }}">

                                            <span class="mini-click-non">All Parcel List</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a @if ($route == 'order.report.filtering') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="pickup request" href="{{ route('order.report.filtering') }}">
                                            <span class="mini-sub-pro">Pickup Request List</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                    <a @if ($route == 'order.draft')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Draft Orders" href="{{ route('order.draft') }}">
                                        <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Draft Orders</span>
                                    </a>
                                </li> --}}
                                    <li>
                                        <a @if ($route == 'pickup_request_list') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Parcel Request list" href="{{ route('pickup_request_list') }}">
                                            <span class="mini-sub-pro">Parcel Request List</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a @if ($route == 'order.backup_create') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Create Order" href="{{ route('order.backup_create') }}">
                                            <span class="mini-click-non">Add Parcel</span>
                                        </a>

                                    </li>
                                    <li>
                                        <a @if ($route == 'csv-file-upload') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Confirmed Order" href="{{ route('csv-file-upload') }}">
                                            <span class="mini-sub-pro">Bulk Import</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a @if ($route == 'csv-file-upload-express')  style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Confirmed Order" href="{{ route('csv-file-upload-express') }}">
                                            <span class="mini-sub-pro">Express Bulk Import</span>
                                        </a>
                                    </li> --}}

                                    <li>
                                        <a @if ($route == 'delivery.assign.order_export') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Create Order" href="{{ route('delivery.assign.order_export') }}">
                                            <span class="mini-click-non">Order Export</span>
                                        </a>

                                    </li>


                                    {{-- <li>
                                        <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Confirm Order" href="{{ route('order.list.index') }}">

                                            <span class="mini-click-non">All Parcel List2</span>
                                        </a>
                                    </li> --}}

                                </ul>
                            </li>
                        @endcan

                        @can('superAdmin')
                            {{-- <li class="">
                                <a class="has-arrow" href="#">
                                    <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                    <span class="mini-click-non">Parcel For Marchant</span>
                                </a>
                                <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') 
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                    aria-expanded="true">
                                    <li>
                                        <a @if ($route == 'order.create')  style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Create Order" href="{{ route('order.create') }}">
                                            <span class="mini-sub-pro">Old Add Parcel</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a @if ($route == 'order.backup_create') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Create Order" href="{{ route('order.backup_create') }}">
                                            <span class="mini-click-non">Add Parcel</span>
                                        </a>

                                    </li>

                                    <li>
                                        <a @if ($route == 'delivery.assign.order_export') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Create Order" href="{{ route('delivery.assign.order_export') }}">
                                            <span class="mini-click-non">Order Export</span>
                                        </a>

                                    </li>

                                    <li>
                                        <a @if ($route == 'order.draft')  style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Draft Orders" href="{{ route('order.draft') }}">
                                            <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                            <span class="mini-sub-pro">Draft Orders</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a @if ($route == 'csv-file-upload')  style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Confirmed Order" href="{{ route('csv-file-upload') }}">
                                            <span class="mini-sub-pro">Bulk Import</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Confirm Order" href="{{ route('order.list.order_list_new') }}">

                                            <span class="mini-click-non">Parcel Export</span>
                                        </a>
                                    </li>

                                </ul>
                            </li> --}}

                            <li class="">
                                <a class="has-arrow" href="#">
                                    <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                    <span class="mini-click-non">Operation</span>
                                </a>
                                <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                    aria-expanded="true">
                                    <li>
                                        <a @if ($route == 'order.collection.hub') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="In Collection Hub" href="{{ route('order.collection.hub') }}">

                                            <span class="mini-click-non">Parcel Fulfillment</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a @if ($route == 'order.transfer_index') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Transfer To Hub" href="{{ route('order.transfer_index') }}">

                                            <span class="mini-click-non">Transfer To Hub</span>
                                        </a>
                                    </li>


                                    {{-- <li>
                                        <a @if ($route == 'redx_transfer_list') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Transfer To ThardParty"
                                            href="{{ route('redx_transfer_list') }}">

                                            <span class="mini-click-non">Redx Transfer List</span>
                                        </a>
                                    </li> --}}


                                    {{-- <li>
                                        <a style="background-color: var(--primary); color: var(--white);" 
                                          target="__blank"  title="Transfer To ThardParty" href="http://127.0.0.1:8000/">

                                            <span class="mini-click-non">Transfer To Redx</span>
                                        </a>
                                    </li> --}}

                                    <li>
                                        <a @if ($route == 'admin.return.to.hub_index') {{-- asifislam --}} 
                                        style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Return To Hub" href="{{ route('admin.return.to.hub_index') }}">

                                            <span class="mini-click-non">Return To Hub</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a @if ($route == 'admin.bypass.to.return.index') 
                                        style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Return To Bypass" href="{{ route('admin.bypass.to.return.index') }}">
                                            <span class="mini-click-non">Return To Bypass</span>
                                        </a>
                                    </li> --}}

                                    <li>
                                        <a @if ($route == 'delivery.assign.branch.list') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Delivery Processing for Branch"
                                            href="{{ route('delivery.assign.branch.list') }}">
                                            <span class="mini-click-non">Delivery Processing for Branch </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a @if ($route == 'rider.transfer.pickup.index') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Pickup transfer" href="{{ route('rider.transfer.pickup.index') }}">
                                            <span class="mini-click-non">Pickup transfer</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a @if ($route == 'rider.transfer.delivery.index') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Delivery transfer" href="{{ route('rider.transfer.delivery.index') }}">
                                            <span class="mini-click-non">Delivery transfer</span>
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            <li class="">
                                <a class="has-arrow" href="#">
                                    <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                    <span class="mini-click-non">Thirdparty Operation</span>
                                </a>
                                <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                    aria-expanded="true">

                                    <li>
                                        <a @if ($route == 'order.transfer_to_third_party') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Transfer To ThardParty"
                                            href="{{ route('order.transfer_to_third_party') }}">

                                            <span class="mini-click-non">Transfer To Redx</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a @if ($route == 'order.transfer_to_third_pathao') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Transfer To ThardParty"
                                            href="{{ route('order.transfer_to_third_pathao') }}">

                                            <span class="mini-click-non">Transfer To Pathao</span>
                                        </a>
                                    </li>




                                    <li>
                                        <a @if ($route == 'pathao_transfer_list') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Transfer To ThardParty" href="{{ route('pathao_transfer_list') }}">

                                            <span class="mini-click-non">ThirdParty Transfer List</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a @if ($route == 'third_party_delivery_cancel_list') style="background-color: var(--primary); color: var(--white);" @endif
                                            title="Transfer To ThardParty"
                                            href="{{ route('third_party_delivery_cancel_list') }}">

                                            <span class="mini-click-non">ThirdParty Delivery and Cancel List</span>
                                        </a>
                                    </li>





                                </ul>
                            </li>
                        @endcan

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">HR & Payroll</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'rider.attendance.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('rider.attendance.index') }}">
                                        <span class="mini-click-non">Rider Attendance</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'employee.attendance.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('employee.attendance.index') }}">
                                        <span class="mini-click-non">Employee Attendance</span>
                                    </a>
                                </li>


                                <li>
                                    <a @if ($route == 'rider.attendance.daily.attendance') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('rider.attendance.daily.attendance') }}">
                                        <span class="mini-click-non">Daily Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.attendance.monthly.attendance.all.employee') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider"
                                        href="{{ route('rider.attendance.monthly.attendance.all.employee') }}">
                                        <span class="mini-click-non">Monthly Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.attendance.monthly.attendance') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('rider.attendance.monthly.attendance') }}">
                                        <span class="mini-click-non">Employee Wise Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.attendance.date_wise.attendance') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('rider.attendance.date_wise.attendance') }}">
                                        <span class="mini-click-non">Branch Wise Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.attendance.branch.wise.monthly.attendance') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider"
                                        href="{{ route('rider.attendance.branch.wise.monthly.attendance') }}">
                                        <span class="mini-click-non">Branch Wise Monthly Attendance</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'rider.attendance.date_wise.attendance') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider" href="{{ route('rider.attendance.employee.wise.monthly.attendance.summary') }}">
                                        <span class="mini-click-non">Summery Attendance</span>
                                    </a>
                                </li> --}}

                                <li>

                                </li>

                            </ul>
                        </li>

                        {{-- <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-bag icon-wrap"></i>
                                <span class="mini-click-non">Order Manage</span>
                            </a>
                            <ul 
                                @if ($route == 'order.transfer.area' || $route == 'order.return.head_office' || $route == 'order.return.merchant') 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(160, 160, 152)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'order.transfer.area') 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Transfer Area" href="{{ route('order.transfer.area') }}">
                                        <span class="mini-click-non">Transfer Area</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.return.head_office') 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Returned Order" href="{{ route('order.return.head_office') }}">
                                        <span class="mini-click-non">Returned Order</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.return.merchant')
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return To Merchant" href="{{ route('order.return.merchant') }}">
                                        <span class="mini-click-non">Return To Merchant</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}





                        {{-- <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-bag icon-wrap"></i>
                                <span class="mini-click-non">Collection Manage</span>
                            </a>
                            <ul @if ($route == 'agent.collect.index' || $route == 'rider.collect.index') 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(160, 160, 152)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'agent.collect.index')
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agents Collect" href="{{ route('agent.collect.index') }}">
                                        <span class="mini-click-non">From Agent </span>
                                    </a>
                                </li>

                                 <li>
                                    <a @if ($route == 'rider.collect.index') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchants Info" href="{{ route('rider.collect.index') }}">
                                        <span class="mini-click-non">From Rider </span>
                                    </a>
                                </li> 


                            </ul>
                        </li> --}}

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-bag icon-wrap"></i>
                                <span class="mini-click-non">Accounts</span>
                            </a>
                            <ul @if (
                                $route == 'accounts.merchant.payment' ||
                                    $route == 'accounts.merchant.advance.payment' ||
                                    $route == 'agent.collect.index') {{-- asifislam --}} 
                      
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"

                        @else
                             class="submenu-angle"
                             style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'agent.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub Payment" href="{{ route('agent.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Branch Collection </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'payment_request_list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub Payment" href="{{ route('payment_request_list') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Payment Request List </span>
                                    </a>
                                </li>
                                
                                <li class="">
                                    <a @if ($route == 'accounts.merchant.payment') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('accounts.merchant.payment') }}">
                                        <span class="mini-sub-pro">Invoice Processing</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a @if ($route == 'accounts.merchant.advance.payment') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agent Wise" href="{{ route('accounts.merchant.advance.payment') }}">
                                        <span class="mini-sub-pro">Advance Payment</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'merchant.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('merchant.payment.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Merchant Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('rider.payment.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Rider Payment Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'branch.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('branch.payment.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Branch Payment Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'branch.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('accounts.branch.payment') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Branch Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('accounts.rider.payment') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Rider Payment</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a @if ($route == 'Expense.list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('Expense.list') }}">
                                        <span class="mini-sub-pro">Expense Management</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a @if ($route == 'Income.list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('Income.list') }}">
                                        <span class="mini-sub-pro">Income Management</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a @if ($route == 'admin.panel.register') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Registration" href="{{ route('accounts.merchant.paymentinfo') }}">
                                        <span class="mini-sub-pro">Merchant Payment Update</span>
                                    </a>
                                </li>



                                {{-- <li>
                                    <a title="Riders Payment" href="#">
                                        <span class="mini-click-non">Riders Payment</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'agent.collect.index') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agents Payment" href="{{ route('agent.collect.index') }}">
                                        <span class="mini-click-non">Agents Payment</span>
                                    </a>
                                </li> --}}


                            </ul>
                        </li>




                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-warning icon-wrap"></i>
                                <span class="mini-click-non">Ticket Manage</span>
                            </a>
                            <ul @if ($route == 'complain.index' || $route == 'complain.report' || $route == 'complain.report.statuswise') {{-- asifislam --}} 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'complain.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Reveived Complains" href="{{ route('complain.index') }}">
                                        <span class="mini-click-non">Reveived Tickets</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'complain.payment.request') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Requests" href="{{ route('complain.payment.request') }}">
                                        <span class="mini-click-non">Payment Requests</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'complain.report.statuswise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Status Wise Report" href="{{ route('complain.report.statuswise') }}">
                                        <span class="mini-click-non">Filtering Ticket</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Report Manage</span>
                            </a>
                            <ul @if (
                                $route == 'order.report.statuswise' ||
                                    $route == 'order.report.datewise' ||
                                    $route == 'merchent.pay.info.index' ||
                                    $route == 'merchent.pay.information.index' ||
                                    $route == 'order.report.merchantwise' ||
                                    $route == 'order.status.merchant' ||
                                    $route == 'order.report.pickup.request' ||
                                    $route == 'order.report.collected' ||
                                    $route == 'merchant.payment.adjustment' ||
                                    $route == 'merchant.advance.payment' ||
                                    $route == 'order.report.return.datewise' ||
                                    $route == 'order.report.admin.agent.history' ||
                                    $route == 'order.report.rider.status.date' ||
                                    $route == 'order.report.agent.transfer.history.index_' ||
                                    $route == 'order.report.admin.transfer.history' ||
                                    $route == 'order.report.riderwise') {{-- asifislam --}} 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                {{-- <li>
                                    <a @if ($route == 'order.report.statuswise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Status Wise" href="{{ route('order.report.statuswise') }}">
                                        <span class="mini-sub-pro">Status Wise</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'order.report.datewise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('order.report.datewise') }}">
                                        <span class="mini-sub-pro">Date Wise</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'merchent.pay.info.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info" href="{{ route('merchent.pay.info.index') }}">
                                        <span class="mini-sub-pro">Merchant Payment Info</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'merchent.pay.information.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info"
                                        href="{{ route('merchent.pay.information.index') }}">
                                        <span class="mini-sub-pro">Merchant Payment History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.daily_collection_report') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info"
                                        href="{{ route('order.report.daily_collection_report') }}">
                                        <span class="mini-sub-pro">Merchant Wise Revenue Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.daily_collection_report_date_wise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info"
                                        href="{{ route('order.report.daily_collection_report_date_wise') }}">
                                        <span class="mini-sub-pro">Date Wise Revenue Report</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'order.report.admin.transfer.history')style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Processing"
                                        href="{{ route('order.report.admin.transfer.history') }}">
                                        <span class="mini-sub-pro">Transaction History</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'order.report.agent.transfer.history.index') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Processing"
                                        href="{{ route('order.report.agent.transfer.history.index') }}">
                                        <span class="mini-sub-pro">Hub Transaction History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.rider.status.date') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider History" href="{{ route('order.report.rider.status.date') }}">
                                        <span class="mini-sub-pro">Rider History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'complain.report') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise Report" href="{{ route('complain.report') }}">
                                        <span class="mini-click-non">Tickets Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'complain.report') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise Report" href="{{ route('Expense.report') }}">
                                        <span class="mini-click-non">Expense Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'Income.report') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise Report" href="{{ route('Income.report') }}">
                                        <span class="mini-click-non">Income Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'Summary.view') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise Report" href="{{ route('Summary.view') }}">
                                        <span class="mini-click-non">Income & Expense Summary Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Payment Processing"
                                        href="{{ route('order.report.agent.transaction.report') }}">
                                        <span class="mini-sub-pro">Rider Collect History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.collected') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Urgent Order" href="{{ route('order.report.collected') }}">
                                        <span class="mini-sub-pro">Transfer History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.merchantwise') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Wise" href="{{ route('order.report.merchantwise') }}">
                                        <span class="mini-sub-pro">Merchant History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.admin.agent.history') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub History" href="{{ route('order.report.admin.agent.history') }}">
                                        <span class="mini-sub-pro">Hub History</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'order.status.merchant')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Wise" href="{{ route('order.status.merchant') }}">
                                        <span class="mini-sub-pro">Merchant Wise</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'order.report.pickup.request')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Today PickUp" href="{{ route('order.report.pickup.request') }}">
                                        <span class="mini-sub-pro">Today PickUp</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.riderwise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('order.report.riderwise') }}">
                                        <span class="mini-sub-pro">Rider Wise</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'merchant.payment.adjustment') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('merchant.payment.adjustment') }}">
                                        <span class="mini-sub-pro">Merchant Adjustment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.advance.payment') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('merchant.advance.payment') }}">
                                        <span class="mini-sub-pro">Advance Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.return.datewise') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return History" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return History</span>
                                    </a>
                                </li>
                            </ul>
                        </li>



                    </ul>
                @endcan
                @can('activeMerchant')
                    <ul class="metismenu" id="menu1">
                        <li>
                            <a @if ($route == 'home') style="" @endif class="active" title="Merchant"
                                href="{{ route('home') }}">
                                <i class="" aria-hidden="true"></i>
                                @if (auth()->user()->role == 12)
                                    <span style="text-align: center; color: green;">Merchant Login: Safe Entry</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'home') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        {{-- <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-cogs icon-wrap"></i>
                                <span class="mini-click-non">Settings</span>
                            </a>
                            <ul @if ($route == 'shop.index' || $route == 'employee.index') 
                      
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"

                        @else
                             class="submenu-angle"
                             style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'shop.index')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Shop" href="{{ route('shop.index') }}">
                                        <i class="fa fa-home sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Shop</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'employee.index')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Employee" href="{{ route('employee.index') }}">
                                        <i class="fa fa-user-plus sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Executive</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        <!--  <li>
                                                                <a class="has-arrow" href="#">
                                                                    <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                                                    <span class="mini-click-non">Order</span>
                                                                </a>
                                                                <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                                                    aria-expanded="true">
                                                                    <li>
                                                                        <a @if ($route == 'order.create') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                                                            title="Create Order" href="{{ route('order.create') }}">
                                                                            <i class="fa fa-cart-plus sub-icon-mg" aria-hidden="true"></i>
                                                                            <span class="mini-sub-pro">Create Order</span>
                                                                        </a>
                                                                    </li>
                                                                    {{-- <li>
                                    <a @if ($route == 'order.draft') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Draft Orders" href="{{ route('order.draft') }}">
                                        <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Draft Orders</span>
                                    </a>
                                </li> --}}
                                                                    <li>
                                                                        <a @if ($route == 'order.list') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                                                            title="Confirmed Order" href="{{ route('order.list') }}">
                                                                            <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                                                            <span class="mini-sub-pro">Order History</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a @if ($route == 'csv-file-upload') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                                                            title="Confirmed Order" href="{{ route('csv-file-upload') }}">
                                                                            <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                                                            <span class="mini-sub-pro">Bulk Import</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li> -->



                        {{-- <li>
                            <a @if ($route == 'payment.confirmation.index')  style="background-color: var(--primary); color: var(--white);" @endif
                                title="Create Order" href="{{ route('order.create') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Old Add Parcel</span>
                            </a>

                        </li> --}}

                        <li>
                            <a @if ($route == 'order.backup_create') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Create Order" href="{{ route('order.backup_create') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Add Parcel</span>
                            </a>

                        </li>

                        {{-- <li>
                            <a @if ($route == 'payment.confirmation.index')  style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirmed Order" href="{{ route('order.lists') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">All Parcel List</span>
                            </a>

                        </li> --}}

                        <li>
                            <a @if ($route == 'order.create_order_list') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirmed Order" href="{{ route('order.create_order_list') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">All Parcel List</span>
                            </a>

                        </li>

                        <li>
                            <a @if ($route == 'payment.confirmation.index') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirmed Order" href="{{ route('csv-file-upload-merchants') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Bulk Import</span>
                            </a>

                        </li>


                        {{-- <li>
                            <a @if ($route == 'payment.confirmation.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Payment confirmation" href="{{ route('payment.confirmation.index') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Payment confirm</span>
                            </a>

                        </li> --}}
                        {{-- <li>
                            <a @if ($route == 'merchant.complain')  style="background-color: var(--primary); color: var(--white);" @endif
                                title="Payment confirmation" href="{{ route('merchant.complain') }}">
                                <i class="fa big-icon fa-plus icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Add Ticket</span>
                            </a>
                        </li> --}}
                        <li>
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Report Managenment</span>
                            </a>
                            <ul @if (
                                $route == 'order.report.pickup.request' ||
                                    $route == 'order.report.statuswise' ||
                                    $route == 'order.report.datewise' ||
                                    $route == 'order.report.pay.complete' ||
                                    $route == 'order.report.return.datewise' ||
                                    $route == 'order.report.merchant.history' ||
                                    $route == 'merchent.pay.information.index') {{-- asifislam --}} 
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                {{-- <li>
                                    <a @if ($route == 'order.report.pickup.request') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Today PickUp Request" href="{{ route('order.report.pickup.request') }}">
                                        <span class="mini-sub-pro">Today Pickup Request</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'order.report.statuswise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Status Wise" href="{{ route('order.report.statuswise') }}">
                                        <span class="mini-sub-pro">Status Wise</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'order.report.datewise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('order.report.datewise') }}">
                                        <span class="mini-sub-pro">Parcel History</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'order.report.pay.complete') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Complete" href="{{ route('order.report.pay.complete') }}">
                                        <span class="mini-sub-pro">Payment Complete</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'order.report.return.datewise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Order Return" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return History</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'order.report.merchant.history')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment History" href="{{ route('order.report.merchant.history') }}">
                                        <span class="mini-sub-pro">Payment History</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'order.report.return.datewise')  style="background-color: var(--primary); color: var(--white);" @endif
                                title="Date Wise" href="{{ route('order.report.return.datewise') }}">
                                <span class="mini-sub-pro">Return History</span>
                                </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'merchent.pay.information.index') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment History" href="{{ route('merchent.pay.information.index') }}">
                                        <span class="mini-sub-pro">Payment History</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a title="Urgent Order" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return Info</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                    </ul>
                @endcan
                @can('activeRider')
                    <ul class="metismenu" id="menu1">
                        <li>
                            <a @if ($route == 'rider.dashboard') style="" @endif class="active" title="Rider"
                                href="{{ route('home') }}">
                                <i class="" aria-hidden="true"></i>
                                @if (auth()->user()->role == 10)
                                    <span style="text-align: center; color: green;">Rider Login: Safe Entry</span>
                                @endif


                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'rider.dashboard') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a title="Pick Up Requests" href="{{ route('request.assign.list') }}">
                                <i class="fa big-icon fa-cart-plus icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Pickup Parcel List </span>
                            </a>
                        </li>
                        <li>
                            <a title="Auto Pickup" href="{{ route('request.assign.auto.lists') }}">
                                <i class="fa big-icon fa-cart-plus icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Auto Pick Up List</span>
                            </a>
                        </li>
                        <li>
                            <a title="Delivery Requests" href="{{ route('delivery.assign.list') }}">
                                <i class="fa big-icon fa-shopping-cart icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Delivery Parcel List</span>
                            </a>
                        </li>
                        <li>
                            <a title="Delivery Requests" href="{{ route('delivery.assign.hold_reschedule') }}">
                                <i class="fa big-icon fa-shopping-cart icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Reschedule Order</span>
                            </a>
                        </li>
                        <li>
                            <a title="Delivery Requests" href="{{ route('delivery.assign.transfer') }}">
                                <i class="fa big-icon fa-shopping-cart icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Transfer Order List</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a title="Incomplete Requests" href="{{ route('delivery.assign.hold') }}">
                                <i class="fa big-icon fa-shopping-cart icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Incomplete Requests</span>
                            </a>
                        </li> --}}
                        <li>
                            <a title="Order Returns" href="{{ route('order.return.list') }}">
                                <i class="fa big-icon fa-cart-arrow-down icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non"> Return Parcel List </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Report Mangement</span>
                                {{-- asifman1  --}}
                            </a>
                            <ul @if (
                                $route == 'order.report.confirm.collected' ||
                                    $route == 'order.report.delivery.confirm' ||
                                    $route == 'order.report.collected' ||
                                    $route == 'order.report.delivery.rider' ||
                                    $route == 'order.report.return.datewise') {{-- asifislam --}} 
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"
                        @else
                        class="submenu-angle"
                        style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">


                                <li>
                                    <a @if ($route == 'order.report.delivery.rider') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirm Delivery" href="{{ route('order.report.delivery.rider') }}">
                                        <span class="mini-sub-pro">Parcel History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.collected') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Order Collect" href="{{ route('order.report.collected') }}">
                                        <span class="mini-sub-pro">Transfer History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.return.datewise') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return History</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'order.report.agent.transaction.report') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Collected Order"
                                        href="{{ route('order.report.agent.transaction.report') }}">
                                        <span class="mini-sub-pro">Paymnet History</span>
                                    </a>
                                </li> --}}

                                {{-- 
                                <li class="">
                                    <a class="has-arrow" href="#" title="Order List">
                                        <span class="mini-click-non">Order Pick Up</span>
                                    </a>
                                    <ul class="submenu-angle" aria-expanded="true">
                                        <li>
                                            <a title="Collected Order"
                                                href="{{ route('order.report.confirm.collected') }}">
                                                <span class="mini-sub-pro">Collected Order</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Order Collect" href="{{ route('order.report.collected') }}">
                                                <span class="mini-sub-pro">Order Collect</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="PickUp Cancel" href="{{ route('order.report.pickup_cancel') }}">
                                                <span class="mini-sub-pro">PickUp Cancel</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                                {{-- 
                                <li class="">
                                    <a class="has-arrow" href="#" title="Order List">
                                        <span class="mini-click-non">Order Delivery</span>
                                    </a>
                                    <ul class="submenu-angle" aria-expanded="true">
                                        <li>
                                            <a title="Pending Delivery" href="{{ route('order.report.pending') }}">
                                                <span class="mini-sub-pro">Pending Delivery</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Confirm Delivery"
                                                href="{{ route('order.report.delivery.confirm') }}">
                                                <span class="mini-sub-pro">Confirm Delivery</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Delivered Order" href="{{ route('order.report.delivered') }}">
                                                <span class="mini-sub-pro">Delivered Order</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                                {{-- <li class="">
                                    <a class="has-arrow" href="#" title="Order Return">
                                        <span class="mini-click-non">Order Return</span>
                                    </a>
                                    <ul class="submenu-angle" aria-expanded="true">
                                        <li>
                                            <a title="Date Wise" href="{{ route('order.report.return.datewise') }}">
                                                <span class="mini-sub-pro">Date Wise</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                        </li>
                    </ul>
                @endcan
                @can('activeAgent')

                    <ul class="metismenu" id="menu1">
                        <li>
                            <a @if ($route == 'home') style="" @endif class="active" title="Hud"
                                href="{{ route('home') }}">
                                <i class="" aria-hidden="true"></i>
                                @if (auth()->user()->role == 8)
                                    <span style="text-align: center; color: green;">Hub Login: Safe Entry</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'home') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'rider.index') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Rider" href="{{ route('rider.index') }}">
                                <i class="fa big-icon fa-motorcycle icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Rider List</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'admin.panel.register') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Registration" href="{{ route('admin.panel.register') }}">
                                <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                <span class="mini-sub-pro">Add Hub Incharge</span>
                            </a>
                        </li>

                        {{-- <li>
                            <a @if ($route == 'order.list.index')  
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirm Order" href="{{ route('order.list.index') }}">
                                <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">All Parcel List1</span>
                            </a>
                        </li> --}}
                        {{-- <li>
                            <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirm Order" href="{{ route('order.list.order_list_new') }}">
                                <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Current Hub
                                     Parcel List</span>
                            </a>
                        </li> --}}

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Parcel Management</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                    class="submenu-angle collapse in"
                    style="background: rgb(222, 232, 241)"
                    @else
                    class="submenu-angle"
                    style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirm Order" href="{{ route('order.list.order_list_new') }}">

                                        <span class="mini-click-non">All Parcel List</span>
                                    </a>
                                </li>

                                {{-- <li>
                                    <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirm Order" href="{{ route('order.list.index') }}">

                                        <span class="mini-click-non">All Parcel List2</span>
                                    </a>
                                </li> --}}

                            </ul>
                        </li>

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Parcel Manage</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"
                        @else
                        class="submenu-angle"
                        style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                {{-- <li>
                                    <a @if ($route == 'order.create')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Create Order" href="{{ route('order.create') }}">
                                        <i class="fa fa-cart-plus sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Add Old Parcel</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'order.backup_create') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Create Order" href="{{ route('order.backup_create') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-click-non">Add Parcel</span>
                                    </a>

                                </li>
                                {{-- <li>
                                    <a @if ($route == 'order.draft')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Draft Orders" href="{{ route('order.draft') }}">
                                        <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Draft Orders</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'delivery.assign.order_export') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Create Order" href="{{ route('delivery.assign.order_export') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-click-non">Order Export</span>
                                    </a>

                                </li>

                                <li>
                                    <a @if ($route == 'csv-file-upload') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirmed Order" href="{{ route('csv-file-upload') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Bulk Import</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Operation</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"
                        @else
                        class="submenu-angle"
                        style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'request.assign.request_pickup') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pick Up Assign" href="{{ route('request.assign.request_pickup') }}">
                                        <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Pickup Parcel</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.collection') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Collection Hub" href="{{ route('order.collection') }}">
                                        <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Pick up Hub</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.transfer.head_office') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Collection Hub" href="{{ route('order.transfer.head_office') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Transit Parcel</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.destination') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Destination Hub" href="{{ route('order.destination') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Destination Hub</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'delivery.assign.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Delivery Assign" href="{{ route('delivery.assign.index') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Delivery Parcel</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'delivery.assign.delivery_assign_by_scan') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Delivery Assign" href="{{ route('delivery.assign.delivery_assign_by_scan') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Delivery Parcel By Scan</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'order.move.return.assign.list') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return Assign" href="{{ route('order.move.return.assign.list') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Return Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.return') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return Order" href="{{ route('order.return') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Reschedule Parcel</span>
                                    </a>
                                </li>


                            </ul>
                        </li>


                        <li>
                            <a @if ($route == 'delivered.order.index') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Delivered Order" href="{{ route('delivered.order.index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Payment Processing</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'delivered.order.rider.payment') {{-- asifislam --}} 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Delivered Order" href="{{ route('delivered.order.rider.payment.load') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Collect Amount From Rider</span>
                            </a>
                        </li>

                        {{-- <li>
                            <a @if ($route == 'order.return_list2') 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Return Order" href="{{ route('order.return_list2') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Hold & Reschedule Order2</span>
                            </a>
                        </li> --}}

                        <li class="menu-open">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Parcel Re Assign</span>
                            </a>





                            <ul @if (
                                $route == 'agent.pickup.bypass.index' ||
                                    $route == 'agent.delivery.bypass.index' ||
                                    $route == 'agent.order.bypass.index') {{-- asifislam --}} 
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"
                            @else
                            class="submenu-angle"
                            style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'agent.pickup.bypass.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Bypass" href="{{ route('agent.pickup.bypass.index') }}">
                                        <i class="fa fa-car"></i>
                                        <span class="mini-sub-pro">Pickup Re Assign</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'agent.delivery.bypass.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Bypass" href="{{ route('agent.delivery.bypass.index') }}">
                                        <i class="fa fa-car"></i>
                                        <span class="mini-sub-pro">Delivery Re Assign</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'agent.order.bypass.index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Bypass" href="{{ route('agent.order.bypass.index') }}">
                                        <i class="fa fa-car"></i>
                                        <span class="mini-sub-pro">Hub Fulfillment </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Report Management</span>
                            </a>
                            <ul @if ($route == 'order.report.rider.status.date' || $route == 'order.report.rider.payment.report') {{-- asifislam --}} 
                                class="submenu-angle collapse in"
                                style="background: rgb(222, 232, 241)"
                                @else
                                class="submenu-angle"
                                style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'order.report.rider.status.date') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider History" href="{{ route('order.report.rider.status.date') }}">
                                        <span class="mini-sub-pro">Rider History</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Payment Processing"
                                        href="{{ route('order.report.rider.payment.report') }}">
                                        <span class="mini-sub-pro">Transaction History</span>
                                    </a>
                                </li>
                                {{-- /Transaction --}}
                                <li>
                                    <a title="Payment Processing"
                                        href="{{ route('order.report.agent.transaction.report') }}">
                                        <span class="mini-sub-pro">Rider Collect History</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a title="Payment Processing" href="{{ route('order.report.processing') }}">
                                        <span class="mini-sub-pro">Payment Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Payment Collect" href="{{ route('order.report.pay.collect') }}">
                                        <span class="mini-sub-pro">Payment Collect</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a title="Transfer History" href="{{ route('order.report.collected') }}">
                                        <span class="mini-sub-pro">Transfer History</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Return History" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return History</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endcan

                @can('ActiveInCharge')

                    <ul class="metismenu" id="menu1">
                        <li>
                            <a @if ($route == 'home') style="" @endif class="active" title="Hud"
                                href="{{ route('home') }}">
                                <i class="" aria-hidden="true"></i>
                                @if (auth()->user()->role == 18)
                                    <span style="text-align: center; color: green;">Hub Incharge Login: Safe Entry</span>
                                @endif

                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'home') {{-- asifislam --}} 
                        style="background-color: var(--primary); color: var(--white);" @endif
                                title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>

                        {{-- <li>
                        <a @if ($route == 'order.list.index')  
                        style="background-color: var(--primary); color: var(--white);" @endif
                            title="Confirm Order" href="{{ route('order.list.index') }}">
                            <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                            <span class="mini-click-non">All Parcel List1</span>
                        </a>
                    </li> --}}
                        <li>
                            <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirm Order" href="{{ route('order.list.order_list_new') }}">
                                <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">All Parcel List</span>
                            </a>
                        </li>
                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Parcel Manage</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                    class="submenu-angle collapse in"
                    style="background: rgb(222, 232, 241)"
                    @else
                    class="submenu-angle"
                    style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                {{-- <li>
                                <a @if ($route == 'order.create')  style="background-color: var(--primary); color: var(--white);" @endif
                                    title="Create Order" href="{{ route('order.create') }}">
                                    <i class="fa fa-cart-plus sub-icon-mg" aria-hidden="true"></i>
                                    <span class="mini-sub-pro">Add Old Parcel</span>
                                </a>
                            </li> --}}
                                <li>
                                    <a @if ($route == 'order.backup_create') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Create Order" href="{{ route('order.backup_create') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-click-non">Add Parcel</span>
                                    </a>

                                </li>
                                {{-- <li>
                                <a @if ($route == 'order.draft')  style="background-color: var(--primary); color: var(--white);" @endif
                                    title="Draft Orders" href="{{ route('order.draft') }}">
                                    <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                    <span class="mini-sub-pro">Draft Orders</span>
                                </a>
                            </li> --}}
                                <li>
                                    <a @if ($route == 'csv-file-upload') {{-- asifislam --}} style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirmed Order" href="{{ route('csv-file-upload') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Bulk Import</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Operation</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') {{-- asifislam --}} 
                    class="submenu-angle collapse in"
                    style="background: rgb(222, 232, 241)"
                    @else
                    class="submenu-angle"
                    style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'request.assign.request_pickup') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pick Up Assign" href="{{ route('request.assign.request_pickup') }}">
                                        <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Pickup Parcel</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.collection') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Collection Hub" href="{{ route('order.collection') }}">
                                        <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Pick up Hub</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.transfer.head_office') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Collection Hub" href="{{ route('order.transfer.head_office') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Transit Parcel</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.destination') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Destination Hub" href="{{ route('order.destination') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Destination Hub</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'delivery.assign.index') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Delivery Assign" href="{{ route('delivery.assign.index') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Delivery Parcel</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.move.return.assign.list') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return Assign" href="{{ route('order.move.return.assign.list') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Return Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.return') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return Order" href="{{ route('order.return') }}">
                                        <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                        <span class="mini-click-non">Reschedule Parcel</span>
                                    </a>
                                </li>


                            </ul>
                        </li>


                        <li>
                            <a @if ($route == 'delivered.order.index') {{-- asifislam --}} 
                        style="background-color: var(--primary); color: var(--white);" @endif
                                title="Delivered Order" href="{{ route('delivered.order.index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Payment Processing</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'delivered.order.rider.payment') {{-- asifislam --}} 
                        style="background-color: var(--primary); color: var(--white);" @endif
                                title="Delivered Order" href="{{ route('delivered.order.rider.payment') }}">
                                <i class="fa big-icon fa-money icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Collect Amount From Rider</span>
                            </a>
                        </li>

                        {{-- <li>
                        <a @if ($route == 'order.return_list2') 
                        style="background-color: var(--primary); color: var(--white);" @endif
                            title="Return Order" href="{{ route('order.return_list2') }}">
                            <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                            <span class="mini-click-non">Hold & Reschedule Order2</span>
                        </a>
                    </li> --}}

                        <li class="menu-open">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Parcel Re Assign</span>
                            </a>





                            <ul @if (
                                $route == 'agent.pickup.bypass.index' ||
                                    $route == 'agent.delivery.bypass.index' ||
                                    $route == 'agent.order.bypass.index') {{-- asifislam --}} 
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"
                        @else
                        class="submenu-angle"
                        style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'agent.pickup.bypass.index') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Bypass" href="{{ route('agent.pickup.bypass.index') }}">
                                        <i class="fa fa-car"></i>
                                        <span class="mini-sub-pro">Pickup Re Assign</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'agent.delivery.bypass.index') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Bypass" href="{{ route('agent.delivery.bypass.index') }}">
                                        <i class="fa fa-car"></i>
                                        <span class="mini-sub-pro">Delivery Re Assign</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'agent.order.bypass.index') {{-- asifislam --}} 
                                style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup Bypass" href="{{ route('agent.order.bypass.index') }}">
                                        <i class="fa fa-car"></i>
                                        <span class="mini-sub-pro">Hub Fulfillment </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                @endcan
                @can('activeManager')
                    <ul class="metismenu" id="menu1">
                        <li>
                            <a @if ($route == 'admin.panel.super.dashboard') style="background-color: var(--primary); color: var(--white);" @endif
                                class="active" title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>




                        {{-- <li>
                            <a @if ($route == 'order.list.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Confirm Order" href="{{ route('order.list.index') }}">
                                <i class="fa big-icon fa-list icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">All Parcel List</span>
                            </a>
                        </li>
                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Parcel</span>
                            </a>
                            <ul @if ($route == 'order.create' || $route == 'order.draft' || $route == 'order.lists') 
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"
                        @else
                        class="submenu-angle"
                        style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'order.create')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Create Order" href="{{ route('order.create') }}">
                                        <i class="fa fa-cart-plus sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Add Parcel</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.draft')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Draft Orders" href="{{ route('order.draft') }}">
                                        <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Draft Orders</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.lists')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirmed Order" href="{{ route('order.lists') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">All Parcel List</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'csv-file-upload')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Confirmed Order" href="{{ route('csv-file-upload') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Bulk Import</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a @if ($route == 'admin.panel.register') 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Registration" href="{{ route('accounts.merchant.paymentinfo') }}">
                                <i class="fa fa-user-secret sub-icon-mg" aria-hidden="true"></i>
                                <span class="mini-sub-pro">Payment Update</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'order.collection.hub')  
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="In Collection Hub" href="{{ route('order.collection.hub') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Check In</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'order.transfer_index') 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Transfer To Hub" href="{{ route('order.transfer_index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Transfer To Hub</span>
                            </a>
                        </li>

                        <li>
                            <a @if ($route == 'admin.return.to.hub_index') 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Return To Hub" href="{{ route('admin.return.to.hub_index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Return To Hub</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'admin.bypass.to.return.index') 
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Return To Bypass" href="{{ route('admin.bypass.to.return.index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Return To Bypass</span>
                            </a>
                        </li>


                        <li>
                            <a @if ($route == 'agent.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Hub Payment" href="{{ route('agent.collect.index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Hub Payment </span>
                            </a>
                        </li>




                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-bag icon-wrap"></i>
                                <span class="mini-click-non">Payment Processing</span>
                            </a>
                            <ul @if (
                                $route == 'accounts.merchant.payment' ||
                                    $route == 'accounts.merchant.advance.payment' ||
                                    $route == 'agent.collect.index') 
                      
                        class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"

                        @else
                             class="submenu-angle"
                             style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li class="">
                                    <a @if ($route == 'accounts.merchant.payment') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('accounts.merchant.payment') }}">
                                        <span class="mini-sub-pro">Invoice Processing</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a @if ($route == 'accounts.merchant.advance.payment')  
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agent Wise" href="{{ route('accounts.merchant.advance.payment') }}">
                                        <span class="mini-sub-pro">Advance Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Riders Payment" href="#">
                                        <span class="mini-click-non">Riders Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'agent.collect.index') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agents Payment" href="{{ route('agent.collect.index') }}">
                                        <span class="mini-click-non">Agents Payment</span>
                                    </a>
                                </li>


                            </ul>
                        </li> --}}
                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-warning icon-wrap"></i>
                                <span class="mini-click-non">Operation</span>
                            </a>
                            <ul @if ($route == 'complain.index' || $route == 'complain.report' || $route == 'complain.report.statuswise') {{-- asifislam --}} 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                {{-- <li>
                                    <a @if ($route == 'complain.payment.request')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Requests" href="{{ route('complain.payment.request') }}">
                                        <span class="mini-click-non">Payment Requests</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'complain.index')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Reveived Complains" href="{{ route('complain.index') }}">
                                        <span class="mini-click-non">Reveived Tickets</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'complain.report')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise Report" href="{{ route('complain.report') }}">
                                        <span class="mini-click-non">Date Wise Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'complain.report.statuswise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Status Wise Report" href="{{ route('complain.report.statuswise') }}">
                                        <span class="mini-click-non">Filtering Tickets</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if ($route == 'order.collection.hub') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="In Collection Hub" href="{{ route('order.collection.hub') }}">

                                        <span class="mini-click-non">Parcel Fulfillment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.transfer_index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Transfer To Hub" href="{{ route('order.transfer_index') }}">

                                        <span class="mini-click-non">Transfer To Hub</span>
                                    </a>
                                </li>


                                {{-- <li>
                                    <a @if ($route == 'redx_transfer_list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Transfer To ThardParty"
                                        href="{{ route('redx_transfer_list') }}">

                                        <span class="mini-click-non">Redx Transfer List</span>
                                    </a>
                                </li> --}}


                                {{-- <li>
                                    <a style="background-color: var(--primary); color: var(--white);" 
                                      target="__blank"  title="Transfer To ThardParty" href="http://127.0.0.1:8000/">

                                        <span class="mini-click-non">Transfer To Redx</span>
                                    </a>
                                </li> --}}

                                <li>
                                    <a @if ($route == 'admin.return.to.hub_index') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return To Hub" href="{{ route('admin.return.to.hub_index') }}">

                                        <span class="mini-click-non">Return To Hub</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if ($route == 'admin.bypass.to.return.index') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return To Bypass" href="{{ route('admin.bypass.to.return.index') }}">
                                        <span class="mini-click-non">Return To Bypass</span>
                                    </a>
                                </li> --}}

                                <li>
                                    <a @if ($route == 'delivery.assign.branch.list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Delivery Processing for Branch"
                                        href="{{ route('delivery.assign.branch.list') }}">
                                        <span class="mini-click-non">Delivery Processing for Branch </span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'rider.transfer.pickup.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Pickup transfer" href="{{ route('rider.transfer.pickup.index') }}">
                                        <span class="mini-click-non">Pickup transfer</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'rider.transfer.delivery.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Delivery transfer" href="{{ route('rider.transfer.delivery.index') }}">
                                        <span class="mini-click-non">Delivery transfer</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Report Manage</span>
                            </a>
                            <ul @if (
                                $route == 'order.report.statuswise' ||
                                    $route == 'order.report.datewise' ||
                                    $route == 'merchent.pay.info.index' ||
                                    $route == 'merchent.pay.information.index' ||
                                    $route == 'order.report.merchantwise' ||
                                    $route == 'order.status.merchant' ||
                                    $route == 'order.report.pickup.request' ||
                                    $route == 'order.report.collected' ||
                                    $route == 'merchant.payment.adjustment' ||
                                    $route == 'merchant.advance.payment' ||
                                    $route == 'order.report.return.datewise' ||
                                    $route == 'order.report.admin.agent.history' ||
                                    $route == 'order.report.rider.status.date' ||
                                    $route == 'order.report.admin.transfer.history' ||
                                    $route == 'order.report.riderwise') 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'merchent.pay.info.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info" href="{{ route('merchent.pay.info.index') }}">
                                        <span class="mini-sub-pro">Merchant Payment Info</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchent.pay.information.index')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info"
                                        href="{{ route('merchent.pay.information.index') }}">
                                        <span class="mini-sub-pro">Merchant Payment History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.admin.transfer.history')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Processing"
                                        href="{{ route('order.report.admin.transfer.history') }}">
                                        <span class="mini-sub-pro">Transaction History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.rider.status.date') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider History" href="{{ route('order.report.rider.status.date') }}">
                                        <span class="mini-sub-pro">Rider History</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Payment Processing"
                                        href="{{ route('order.report.agent.transaction.report') }}">
                                        <span class="mini-sub-pro">Rider Collect History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.collected')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Urgent Order" href="{{ route('order.report.collected') }}">
                                        <span class="mini-sub-pro">Transfer History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.merchantwise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Wise" href="{{ route('order.report.merchantwise') }}">
                                        <span class="mini-sub-pro">Merchant History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.admin.agent.history')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub History" href="{{ route('order.report.admin.agent.history') }}">
                                        <span class="mini-sub-pro">Hub History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.status.merchant')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Wise" href="{{ route('order.status.merchant') }}">
                                        <span class="mini-sub-pro">Merchant Wise</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.pickup.request')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Today PickUp" href="{{ route('order.report.pickup.request') }}">
                                        <span class="mini-sub-pro">Today PickUp</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.riderwise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('order.report.riderwise') }}">
                                        <span class="mini-sub-pro">Rider Wise</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.payment.adjustment')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('merchant.payment.adjustment') }}">
                                        <span class="mini-sub-pro">Merchant Adjustment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.advance.payment')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('merchant.advance.payment') }}">
                                        <span class="mini-sub-pro">Advance Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.return.datewise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return History" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return History</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}



                    </ul>
                @endcan
                @can('activeAccounts')
                    <ul class="metismenu" id="menu1">
                        <li>
                            <a title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a @if ($route == 'admin.panel.register')  
                            style="background-color: var(--primary); color: var(--white);" @endif
                                title="Registration" href="{{ route('accounts.merchant.paymentinfo') }}">
                                <i class="fa fa-user-secret sub-icon-mg" aria-hidden="true"></i>
                                <span class="mini-sub-pro">Payment Update</span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'agent.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Hub Payment" href="{{ route('agent.collect.index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Hub Payment </span>
                            </a>
                        </li>
                        <li>
                            <a @if ($route == 'merchant.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                title="Merchant Payment" href="{{ route('merchant.payment.collect.index') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Merchant Payment</span>
                            </a>
                        </li> --}}

                        {{-- <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-bag icon-wrap"></i>
                                <span class="mini-click-non">Collection Manage</span>
                            </a>
                            <ul @if ($route == 'agent.collect.index' || $route == 'rider.collect.index') 
                          
                            class="submenu-angle collapse in"
                            style="background: rgb(160, 160, 152)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">
                                <li>
                                    <a @if ($route == 'agent.collect.index')
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agents Collect" href="{{ route('agent.collect.index') }}">
                                        <span class="mini-click-non">From Agent </span>
                                    </a>
                                </li>

                                 <li>
                                    <a @if ($route == 'rider.collect.index') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchants Info" href="{{ route('rider.collect.index') }}">
                                        <span class="mini-click-non">From Rider </span>
                                    </a>
                                </li> 


                            </ul>
                        </li> --}}

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-bag icon-wrap"></i>
                                <span class="mini-click-non">Accounts</span>
                            </a>
                            <ul @if (
                                $route == 'accounts.merchant.payment' ||
                                    $route == 'accounts.merchant.advance.payment' ||
                                    $route == 'agent.collect.index') class="submenu-angle collapse in"
                        style="background: rgb(222, 232, 241)"

                        @else
                             class="submenu-angle"
                             style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true">

                                <li>
                                    <a @if ($route == 'agent.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub Payment" href="{{ route('agent.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Branch Collection </span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'payment_request_list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub Payment" href="{{ route('payment_request_list') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Payment Request List </span>
                                    </a>
                                </li>
                                <li class="">
                                    <a @if ($route == 'accounts.merchant.payment') 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('accounts.merchant.payment') }}">
                                        <span class="mini-sub-pro">Invoice Processing</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a @if ($route == 'accounts.merchant.advance.payment') {{-- asifislam --}} 
                                    style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Agent Wise" href="{{ route('accounts.merchant.advance.payment') }}">
                                        <span class="mini-sub-pro">Advance Payment</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'merchant.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('merchant.payment.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Merchant Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'rider.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('rider.payment.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Rider Payment Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'branch.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('branch.payment.collect.index') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Branch Payment Processing</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'branch.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('accounts.branch.payment') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Branch Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.payment.collect.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment" href="{{ route('accounts.rider.payment') }}">
                                        {{-- <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i> --}}
                                        <span class="mini-click-non">Rider Payment</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a @if ($route == 'Expense.list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('Expense.list') }}">
                                        <span class="mini-sub-pro">Expense Management</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a @if ($route == 'Income.list') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('Income.list') }}">
                                        <span class="mini-sub-pro">Income Management</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a @if ($route == 'admin.panel.register') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Registration" href="{{ route('accounts.merchant.paymentinfo') }}">
                                        <span class="mini-sub-pro">Merchant Payment Update</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        {{-- <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-print icon-wrap"></i>
                                <span class="mini-click-non">Report Manage</span>
                            </a>
                            <ul @if (
                                $route == 'order.report.statuswise' ||
                                    $route == 'order.report.datewise' ||
                                    $route == 'merchent.pay.info.index' ||
                                    $route == 'merchent.pay.information.index' ||
                                    $route == 'order.report.merchantwise' ||
                                    $route == 'order.status.merchant' ||
                                    $route == 'order.report.pickup.request' ||
                                    $route == 'order.report.collected' ||
                                    $route == 'merchant.payment.adjustment' ||
                                    $route == 'merchant.advance.payment' ||
                                    $route == 'order.report.return.datewise' ||
                                    $route == 'order.report.admin.agent.history' ||
                                    $route == 'order.report.rider.status.date' ||
                                    $route == 'order.report.admin.transfer.history' ||
                                    $route == 'order.report.riderwise') class="submenu-angle collapse in"
                            style="background: rgb(222, 232, 241)"

                            @else
                                 class="submenu-angle"
                                 style="background: rgb(131, 218, 245)" @endif
                                aria-expanded="true"> --}}
                                {{-- <li>
                                    <a @if ($route == 'order.report.statuswise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Status Wise" href="{{ route('order.report.statuswise') }}">
                                        <span class="mini-sub-pro">Status Wise</span>
                                    </a>
                                </li>

                                <li>
                                    <a @if ($route == 'order.report.datewise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Date Wise" href="{{ route('order.report.datewise') }}">
                                        <span class="mini-sub-pro">Date Wise</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'merchent.pay.info.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info" href="{{ route('merchent.pay.info.index') }}">
                                        <span class="mini-sub-pro">Merchant Payment Info</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if ($route == 'merchent.pay.information.index') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Payment Info"
                                        href="{{ route('merchent.pay.information.index') }}">
                                        <span class="mini-sub-pro">Merchant Payment History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.admin.transfer.history') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Payment Processing"
                                        href="{{ route('order.report.admin.transfer.history') }}">
                                        <span class="mini-sub-pro">Transaction History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.rider.status.date') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider History" href="{{ route('order.report.rider.status.date') }}">
                                        <span class="mini-sub-pro">Rider History</span>
                                    </a>
                                </li>
                                <li>
                                    <a title="Payment Processing"
                                        href="{{ route('order.report.agent.transaction.report') }}">
                                        <span class="mini-sub-pro">Rider Collect History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.collected') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Urgent Order" href="{{ route('order.report.collected') }}">
                                        <span class="mini-sub-pro">Transfer History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.merchantwise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Wise" href="{{ route('order.report.merchantwise') }}">
                                        <span class="mini-sub-pro">Merchant History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.admin.agent.history') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Hub History" href="{{ route('order.report.admin.agent.history') }}">
                                        <span class="mini-sub-pro">Hub History</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.status.merchant') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Merchant Wise" href="{{ route('order.status.merchant') }}">
                                        <span class="mini-sub-pro">Merchant Wise</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.pickup.request') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Today PickUp" href="{{ route('order.report.pickup.request') }}">
                                        <span class="mini-sub-pro">Today PickUp</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.riderwise') style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('order.report.riderwise') }}">
                                        <span class="mini-sub-pro">Rider Wise</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.payment.adjustment')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('merchant.payment.adjustment') }}">
                                        <span class="mini-sub-pro">Merchant Adjustment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'merchant.advance.payment')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Rider Wise" href="{{ route('merchant.advance.payment') }}">
                                        <span class="mini-sub-pro">Advance Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if ($route == 'order.report.return.datewise')  style="background-color: var(--primary); color: var(--white);" @endif
                                        title="Return History" href="{{ route('order.report.return.datewise') }}">
                                        <span class="mini-sub-pro">Return History</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                    </ul>
                @endcan
                @can('activeCallCenter')
                    <ul class="metismenu" id="menu1">
                        <li>
                            <a title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a title="Complain Submit" href="{{ route('complain.create') }}">
                                <i class="fa fa-warning icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Ticket Submit</span>
                            </a>
                        </li>
                        <li>
                            <a title="Reveived Complains" href="{{ route('complain.index') }}">
                                <i class="fa fa-book icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Reveived Tickets</span>
                            </a>
                        </li>
                    </ul>
                @endcan

                @can('activeEmployee')
                    <ul class="metismenu" id="menu1">
                        <li>
                            <a title="Dashboard" href="{{ route('home') }}">
                                <i class="fa big-icon fa-dashboard icon-wrap" aria-hidden="true"></i>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>

                        <li class="">
                            <a class="has-arrow" href="#">
                                <i class="fa big-icon fa-shopping-basket icon-wrap"></i>
                                <span class="mini-click-non">Order</span>
                            </a>
                            <ul class="submenu-angle" aria-expanded="true">
                                <li>
                                    <a title="Create Order" href="{{ route('order.create') }}">
                                        <i class="fa fa-cart-plus sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Add Parcel</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a title="Draft Orders" href="{{ route('order.draft') }}">
                                        <i class="fa fa-shopping-basket sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Draft Orders</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a title="Confirmed Order" href="{{ route('order.lists') }}">
                                        <i class="fa fa-shopping-bag sub-icon-mg" aria-hidden="true"></i>
                                        <span class="mini-sub-pro">Confirmed Orders</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                @endcan

            </nav>
        </div>
    </nav>
</div>
