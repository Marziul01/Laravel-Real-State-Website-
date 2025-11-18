<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link justify-content-center">
            <img src="{{ asset($setting->site_logo) }}" alt="Logo" class="app-brand-logo demo" height="100%" width="40%" />
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->

        <li class="menu-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Email">Dashboard</div>
            </a>
        </li>
        @if ($access->control_panel != 2)
            <li class="menu-item {{ Route::currentRouteName() == 'admin.control.panel' ? 'active' : '' }}">
                <a href="{{ route('admin.control.panel') }}"
                    class="menu-link">
                    <i class="menu-icon1 tf-icons fa-solid fa-user-gear"></i>
                    <div class="text-truncate" data-i18n="Email">Control Panel</div>
                </a>
            </li>
        @endif
        
        @if ($access->rent_property != 2)
        <li class="menu-item  {{ Route::currentRouteName() == 'property.index' ? 'active open' : '' }} {{ Route::currentRouteName() == 'property.create' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-hotel"></i>
                <div class="text-truncate" data-i18n="Dashboards">Rent Property Managment</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'property.index' ? 'active' : '' }}">
                    <a href="{{ route('property.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Rent Properties</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'property.create' ? 'active' : '' }}">
                    <a href="{{ route('property.create') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Add New Property </div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        
        @if ($access->sell_property != 2)
        <li class="menu-item  {{ Route::currentRouteName() == 'property.sell' ? 'active open' : '' }} {{ Route::currentRouteName() == 'sellcreate' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-regular fa-building"></i>
                <div class="text-truncate" data-i18n="Dashboards">Sell Property Managment</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'property.sell' ? 'active' : '' }}">
                    <a href="{{ route('property.sell') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Sell Properties</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'sellcreate' ? 'active' : '' }}">
                    <a href="{{ route('sellcreate') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Add New Property </div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        
        @if ($access->coupons != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'coupon.index' ? 'active' : '' }}">
            <a href="{{ route('coupon.index') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons fa-solid fa-percent"></i>
                <div class="text-truncate" data-i18n="Email">Coupons</div>
            </a>
        </li>
        @endif
        
        @if ($access->payment_methods != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'payment_method.index' ? 'active' : '' }}">
            <a href="{{ route('payment_method.index') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons fa-solid fa-wallet"></i>
                <div class="text-truncate" data-i18n="Email">Payment Methods</div>
            </a>
        </li>
        @endif
        
        @if ($access->booking != 2)
        <li class="menu-item  {{ Route::currentRouteName() == 'booking.pending' ? 'active open' : '' }} {{ Route::currentRouteName() == 'booking.active' ? 'active open' : '' }} {{ Route::currentRouteName() == 'booking.visit' ? 'active open' : '' }} {{ Route::currentRouteName() == 'booking.cancel' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-building-circle-check"></i>
                <div class="text-truncate" data-i18n="Dashboards">Booking Managment</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'booking.pending' ? 'active' : '' }}">
                    <a href="{{ route('booking.pending') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Pending Bookings</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'booking.active' ? 'active' : '' }}">
                    <a href="{{ route('booking.active') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Active Bookings</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'booking.visit' ? 'active' : '' }}">
                    <a href="{{ route('booking.visit') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Visited Bookings</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'booking.cancel' ? 'active' : '' }}">
                    <a href="{{ route('booking.cancel') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Canceled Bookings</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        
        @if ($access->property_inquiries != 2)
        <li class="menu-item  {{ Route::currentRouteName() == 'rent.property.inquiry' ? 'active open' : '' }} {{ Route::currentRouteName() == 'sell.property.inquiry' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-building-circle-exclamation"></i>
                <div class="text-truncate" data-i18n="Dashboards">Property Inquiries</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'rent.property.inquiry' ? 'active' : '' }}">
                    <a href="{{ route('rent.property.inquiry') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Rent Property Inquiry</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'sell.property.inquiry' ? 'active' : '' }}">
                    <a href="{{ route('sell.property.inquiry') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Sell Property Inquiry</div>
                    </a>
                </li>
                
            </ul>
        </li>
        @endif
        
        @if ($access->property_submissions != 2)
        <li class="menu-item  {{ Route::currentRouteName() == 'rent.submission' ? 'active open' : '' }} {{ Route::currentRouteName() == 'sell.submission' ? 'active open' : '' }} {{ Route::currentRouteName() == 'clients.confirmed' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-building-user"></i>
                <div class="text-truncate" data-i18n="Dashboards">All Property Submission</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'rent.submission' ? 'active' : '' }}">
                    <a href="{{ route('rent.submission') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Rent Submission</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'sell.submission' ? 'active' : '' }}">
                    <a href="{{ route('sell.submission') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Sell Submission</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'clients.confirmed' ? 'active' : '' }}">
                    <a href="{{ route('clients.confirmed') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Our Clients</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        
        @if ($access->services != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'admin.services' ? 'active' : '' }}">
            <a href="{{ route('admin.services') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons fa-solid fa-handshake-angle"></i>
                <div class="text-truncate" data-i18n="Email">All Services</div>
            </a>
        </li>
        @endif
        
        @if ($access->teams != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'admin.teams' ? 'active' : '' }}">
            <a href="{{ route('admin.teams') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons fa-solid fa-users"></i>
                <div class="text-truncate" data-i18n="Email">All Teams</div>
            </a>
        </li>
        @endif
        
        @if ($access->reviews != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'admin.reviews' ? 'active' : '' }}">
            <a href="{{ route('admin.reviews') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons fa-solid fa-envelopes-bulk"></i>
                <div class="text-truncate" data-i18n="Email">Reviews</div>
            </a>
        </li>
        @endif
        
        @if ($access->user_management != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">
            <a href="{{ route('admin.users') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons fa-solid fa-user-shield"></i>
                <div class="text-truncate" data-i18n="Email">Users Management</div>
            </a>
        </li>
        @endif

        @if ($access->seo != 2)
        <li class="menu-item {{ Route::currentRouteName() == 'admin.seo.settings' ? 'active' : '' }}">
            <a href="{{ route('admin.seo.settings') }}"
                class="menu-link">
                <i class="menu-icon1 tf-icons <i fa-brands fa-searchengin"></i>
                <div class="text-truncate" data-i18n="Email">Seo Settings</div>
            </a>
        </li>
        @endif
        
        @if ($access->pages_management != 2)
        <li class="menu-item  {{ Route::currentRouteName() == 'admin.homeslider' ? 'active open' : '' }} {{ Route::currentRouteName() == 'admin.about.page' ? 'active open' : '' }} {{ Route::currentRouteName() == 'blogs.index' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-file-lines"></i>
                <div class="text-truncate" data-i18n="Dashboards">Pages Managment</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'admin.homeslider' ? 'active' : '' }}">
                    <a href="{{ route('admin.homeslider') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Home Page</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'admin.about.page' ? 'active' : '' }}">
                    <a href="{{ route('admin.about.page') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">About Page</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'blogs.index' ? 'active' : '' }}">
                    <a href="{{ route('blogs.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Blogs</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'careers.index' ? 'active' : '' }}">
                    <a href="{{ route('careers.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Job Posts</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'gallery.index' ? 'active' : '' }}">
                    <a href="{{ route('gallery.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Gallery</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::currentRouteName() == 'admin.agent.page' ? 'active' : '' }}">
                    <a href="{{ route('admin.agent.page') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Work With Us Page</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

    </ul>


    {{-- <div class="aside-last-bar py-2">
        <p class="text-center text-secondary mb-1" style="font-size: 10px; font-weight: 500">
            @php
                $user = auth()->user();
            @endphp
            @if(auth()->user()->last_login_at)
                Last login : {{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->format('d M Y, h:i A') }}
            @else
                First login: {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, h:i A') }}
            @endif
        </p>
    </div> --}}

</aside>
