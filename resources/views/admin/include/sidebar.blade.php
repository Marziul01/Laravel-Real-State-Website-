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

        <li class="menu-item  {{ Route::currentRouteName() == 'property.index' ? 'active open' : '' }} {{ Route::currentRouteName() == 'property.create' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-user-gear"></i>
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

        <li class="menu-item  {{ Route::currentRouteName() == 'property.sell' ? 'active open' : '' }} {{ Route::currentRouteName() == 'sellcreate' ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-user-gear"></i>
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

        <li class="menu-item {{ Route::currentRouteName() == 'coupon.index' ? 'active' : '' }}">
            <a href="{{ route('coupon.index') }}"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Email">Coupons</div>
            </a>
        </li>

        <li class="menu-item {{ Route::currentRouteName() == 'payment_method.index' ? 'active' : '' }}">
            <a href="{{ route('payment_method.index') }}"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Email">Payment Methods</div>
            </a>
        </li>

        {{-- @if(Auth::user()->access->admin_panel == '1' || Auth::user()->access->admin_panel == '2')
        <li class="menu-item  {{ Route::currentRouteName() == 'admin.users' ? 'active open' : '' }} {{ Route::currentRouteName() == 'admin.categoryTableSettings' ? 'active open' : '' }} {{ Route::currentRouteName() == 'home.settings' ? 'active open' : '' }}  {{ Route::currentRouteName() == 'Export-Data' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon1 tf-icons fa-solid fa-user-gear"></i>
                <div class="text-truncate" data-i18n="Dashboards">Admin Panel</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Control Panel</div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'admin.categoryTableSettings' ? 'active' : '' }}">
                    <a href="{{ route('admin.categoryTableSettings') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Category & Table </div>
                    </a>
                </li>

                <li class="menu-item {{ Route::currentRouteName() == 'home.settings' ? 'active' : '' }}">
                    <a href="{{ route('home.settings') }}"
                        class="menu-link ">
                        <div class="text-truncate" data-i18n="CRM"> Landing Page Setting </div>
                    </a>
                </li>
                
                <li class="menu-item {{ Route::currentRouteName() == 'Export-Data' ? 'active' : '' }}">
                    <a href="{{ route('Export-Data') }}"
                        class="menu-link">
                        <div class="text-truncate" data-i18n="eCommerce">Export Data</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif --}}
        
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
