<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background: var(--primary)">
            <div class="header-top-wraper" style="background: var(--primary)">
                <div class="row">
                    <div class="col-lg-0 col-md-0 col-sm-1 col-xs-12">
                        <div class="menu-switcher-pro">
                            {{-- <button type="button" id="sidebarCollapse"
                                class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                <i class="fa fa-bars"></i>
                            </button> --}}
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-12 text-left">
                        <div class="header-top-menu tabl-d-n">
                            <ul class="nav navbar-nav mai-top-nav">
                                <li class="nav-item">
                                    <?php
                                    $data = DB::table('notices')->first();
                                    ?>
                                    <a style="font-size:16px; font-weight:bolder;">
                                        <marquee behavior="scroll" direction="left" scrollamount="5">
                                            <span>{{ $data->message }}</span>
                                        </marquee>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                        <div class="header-right-info">
                            <ul class="nav navbar-nav mai-top-nav header-right-menu ">

                                <li class="nav-item">
                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle">
                                        <i class="fa fa-user adminpro-user-rounded header-riht-inf"
                                            aria-hidden="true"></i>
                                        <span class="admin-name">{{ Auth::user()->name ?? '' }}</span>
                                        <i class="fa fa-angle-down adminpro-icon adminpro-down-arrow"></i>
                                    </a>
                                    <ul role="menu"
                                        class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                        <li>
                                            @can('activeMerchant')
                                                <a class="dropdown-item" href="{{ route('merchant.profile.updation') }}">
                                                    <i class="fa fa-briefcase author-log-ic"></i>
                                                    {{ __('Profile') }}
                                                </a>
                                            @endcan
                                            @can('activeMerchant')
                                                {{-- <a class="dropdown-item" href="{{ route('merchant.payment.info') }}">
                                                <i class="fa fa-money author-log-ic"></i>
                                                {{ __('Payment Info') }}
                                            </a> --}}

                                                @php
                                                    $data = App\Admin\PaymentInfo::where('user_id', Auth::user()->id)->exists();
                                                @endphp
                                                <a class="dropdown-item" href="{{ route('merchant.complain') }}">
                                                    <i class="fa fa-money author-log-ic"></i>
                                                    {{ __('Add Ticket') }}
                                                </a>
                                                @if ($data)
                                                    {{-- <a class="dropdown-item"
                                                        href="{{ route('merchant.payment.info.add') }}">
                                                        <i class="fa fa-money author-log-ic"></i>
                                                        {{ __('Add Payment Method') }}
                                                    </a> --}}
                                                @else
                                                    <a class="dropdown-item"
                                                        href="{{ route('merchant.payment.info.add') }}">
                                                        <i class="fa fa-money author-log-ic"></i>
                                                        {{ __('Add Payment Method') }}
                                                    </a>
                                                @endif
                                                <a class="dropdown-item" href="{{ route('order.create') }}">
                                                    <i class="fa fa-money author-log-ic"></i>
                                                    {{ __('Create Order') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('order.lists') }}">
                                                    <i class="fa fa-money author-log-ic"></i>
                                                    {{ __('Confirmed Order List') }}
                                                </a>
                                            @endcan
                                            @can('activeRider')
                                                <a class="dropdown-item" href="{{ route('request.assign.list') }}">
                                                    <i class="fa fa-youtube-play author-log-ic"></i>
                                                    {{ __('Pick Up Requests') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('delivery.assign.list') }}">
                                                    <i class="fa fa-youtube-play author-log-ic"></i>
                                                    {{ __('Delivery Requests') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('delivery.assign.transfer') }}">
                                                    <i class="fa fa-youtube-play author-log-ic"></i>
                                                    {{ __('Transfer Requests') }}
                                                </a>
                                            @endcan

                                            <a class="dropdown-item" href="#">
                                                <i class="fa fa-youtube-play author-log-ic"></i>
                                                {{ __('Tutorial') }}
                                            </a>

                                            <a class="dropdown-item" href="{{ route('change.password') }}">
                                                <i class="fa fa-lock author-log-ic"></i>&nbsp;
                                                {{ __('Change password') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <span class="fa fa-sign-out author-log-ic"></span> {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
