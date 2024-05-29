<!-- LOGO -->
<div class="navbar-brand-box">
    <!-- Dark Logo-->
    <a href="{!! route('dashboard') !!}" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{!! asset('assets/images/logo-sm.png') !!}" alt="Image" height="22">
        </span>
        <span class="logo-lg">
            <img src="{!! asset('assets/images/logo-dark.png') !!}" alt="Image" height="17">
        </span>
    </a>
    <!-- Light Logo-->
    <a href="{!! route('dashboard') !!}" class="logo logo-light">
        <span class="logo-sm">
            <img src="{!! asset('assets/images/logo-sm.png') !!}" alt="Image" height="22">
        </span>
        <span class="logo-lg">
            <img src="{!! asset('assets/images/logo-light.png') !!}" alt="Image" height="17">
        </span>
    </a>
    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
        <i class="ri-record-circle-line"></i>
    </button>
</div>

<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Menu</span></li>

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link menu-link @yield('dashboard')" href="{!! route('dashboard') !!}">
                    <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                </a>
            </li>

            {{-- Data Master --}}
            <li class="nav-item">
                <a class="nav-link menu-link @yield('datamaster')" href="#sidebarDataMaster" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDataMaster">
                    <i class="ri-database-2-line"></i> <span data-key="t-data-master">Data Master</span>
                </a>
                <div class="@yield('toggle', 'collapse') menu-dropdown" id="sidebarDataMaster">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{!! route('user.index') !!}" class="nav-link @yield('user')" data-key="t-user"> User </a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('role.index') !!}" class="nav-link @yield('role')" data-key="t-Role"> Role </a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('permission.index') !!}" class="nav-link @yield('permission')" data-key="t-Permission"> Permission </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Management --}}
            <li class="nav-item">
                <a class="nav-link menu-link @yield('management')" href="#sidebarManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarManagement">
                    <i class="ri-home-gear-line"></i> <span data-key="t-management">Management</span>
                </a>
                <div class="@yield('toggleManagement', 'collapse') menu-dropdown" id="sidebarManagement">
                    <ul class="nav nav-sm flex-column">
                        @can('view_regions')
                            <li class="nav-item">
                                <a href="{!! route('region.index') !!}" class="nav-link @yield('region')" data-key="t-region"> Region </a>
                            </li>
                        @endcan
                        @can('view_offices')
                            <li class="nav-item">
                                <a href="{!! route('office.index') !!}" class="nav-link @yield('office')" data-key="t-office"> Office </a>
                            </li>
                        @endcan
                        @can('view_mines')
                            <li class="nav-item">
                                <a href="{!! route('mine.index') !!}" class="nav-link @yield('mine')" data-key="t-mine"> Mine </a>
                            </li>
                        @endcan
                        @can('view_employees')
                            <li class="nav-item">
                                <a class="nav-link @yield('employee')" href="{!! route('employee.index') !!}" data-key="t-employee"> Employee </a>
                            </li>
                        @endcan
                        @can('view_vehicles')
                            <li class="nav-item">
                                <a class="nav-link @yield('vehicle')" href="{!! route('dashboard') !!}" data-key="t-vehicle"> Vehicle </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>

            {{-- Vehicle Monitoring --}}
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarVehicleMonitoring" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarVehicleMonitoring">
                    <i class="ri-gas-station-line"></i> <span data-key="t-vehicle-monitoring">Vehicle Monitoring</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarVehicleMonitoring">
                    <ul class="nav nav-sm flex-column">
                        @can('view_fuel_consumption')
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-fuel"> Fuel Consumption </a>
                            </li>
                        @endcan
                        @can('view_service_schedules')
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-service"> Service Schedule </a>
                            </li>
                        @endcan
                        @can('view_usage_history')
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-usage"> Vehicle Usage History </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>

            {{-- Booking --}}
            @can('view_employees')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{!! route('dashboard') !!}">
                        <i class="ri-calendar-check-line"></i> <span data-key="t-booking">Booking</span>
                    </a>
                </li>
            @endcan

            {{-- Approval --}}
            @can('view_approvals')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{!! route('dashboard') !!}">
                        <i class="ri-user-follow-line"></i> <span data-key="t-approval">Approval</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
    <!-- Sidebar -->
</div>

<div class="sidebar-background"></div>