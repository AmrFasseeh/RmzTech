<!-- BEGIN: Header-->
@auth
<nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
        <div class="navbar-wrapper">
                <div class="navbar-header">
                        <ul class="nav navbar-nav flex-row" style="justify-content: center;">
                                <li class="nav-item"><a class="navbar-brand" href="{{ route('landing') }}"><img
                                                        style="height:40px; width:150px" alt="Rmz Tech logo"
                                                        src="{{ asset('/public/app-assets/images/logo.png') }}">
                                        </a></li>
                        </ul>
                </div>
                <div class="navbar-container container center-layout">
                        <div class="collapse navbar-collapse" id="navbar-mobile">
                                <ul class="nav navbar-nav mr-auto float-left">
                                        <li class="nav-item d-none d-md-block"><a
                                                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                                                class="ft-menu"></i></a></li>
                                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"
                                                        href="#"><i class="ficon ft-maximize"></i></a></li>
                                        {{-- <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i
                                                                class="ficon ft-search"></i></a>
                                                <div class="search-input">
                                                        <input class="input" type="text"
                                                                placeholder="Explore Modern...">
                                                </div>
                                        </li> --}}
                                </ul>
                                <ul class="nav navbar-nav float-right">

                                        <li class="dropdown dropdown-user nav-item"><a
                                                        class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                                        data-toggle="dropdown"><span
                                                                class="mr-1 user-name text-bold-700">{{ Auth::user()->fullname }}</span><span
                                                                class="avatar avatar-online"><img
                                                                        src="{{ Auth::user()->image != NULL ? Auth::user()->image->url() : asset('/public/assets/rmz-logos/icon.png') }}"
                                                                        alt="avatar"><i></i></span></a>
                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                href="{{ route('edit.emp') }}"><i class="ft-user"></i>
                                                                Edit
                                                                Profile</a>
                                                        <div class="dropdown-divider"></div><a class="dropdown-item"
                                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                                                        class="ft-power"></i> Logout</a>
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                                method="POST" style="dispaly:none;">
                                                                @csrf
                                                        </form>
                                                </div>
                                                {{-- </li>
                                        
                                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><span
                                                        class="mr-1 user-name text-bold-700">Login</span></a>
                                        </li> --}}


                                </ul>
                        </div>
                </div>
        </div>
</nav>
@endauth
<!-- END: Header-->




<!-- BEGIN: Main Menu-->
@auth
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
        role="navigation" data-menu="menu-wrapper">
        <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
                <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                        <li class="dropdown nav-item"><a class="nav-link" href="{{ route('landing') }}"><i
                                                class="la la-home"></i><span>Dashboard</span></a>
                        </li>
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                        data-toggle="dropdown"><i class="la la-user"></i><span>Users</span></a>
                                <ul class="dropdown-menu">
                                        @if (Auth::user()->getRoleNames()->contains('Admin'))
                                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                                        class="dropdown-item dropdown-toggle" href="#"
                                                        data-toggle="dropdown"><i
                                                                class="la la-user"></i><span>Admins</span></a>
                                                <ul class="dropdown-menu">
                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('show.admins') }}"
                                                                        data-toggle=""><span>View All Admins</span></a>
                                                        </li>
                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('register') }}"
                                                                        data-toggle=""><span>Add New</span></a>
                                                        </li>
                                                </ul>
                                        </li>
                                        @endif
                                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                                        class="dropdown-item dropdown-toggle" href="#"
                                                        data-toggle="dropdown"><i
                                                                class="la la-users"></i><span>Employees</span></a>
                                                @if (Auth::user()->getRoleNames()->contains('Admin'))
                                                <ul class="dropdown-menu">
                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('show.users') }}"
                                                                        data-toggle=""><span>View All
                                                                                Employees</span></a>
                                                        </li>

                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('add.user') }}"
                                                                        data-toggle=""><span>Add new</span></a>
                                                        </li>

                                                </ul>
                                                @else
                                                <ul class="dropdown-menu">
                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('view.users') }}"
                                                                        data-toggle=""><span>View All
                                                                                Employees</span></a>
                                                        </li>
                                                </ul>
                                                @endif
                                        </li>
                                </ul>
                        </li>
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                        data-toggle="dropdown"><i class="la la-file-text"></i><span>Reports</span></a>
                                @if (Auth::user()->getRoleNames()->contains('Admin'))
                                <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('reports.today') }}"
                                                        data-toggle=""><i class="la la-file-pdf-o"></i><span>Daily
                                                                Report</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('reports.monthly') }}"
                                                        data-toggle=""><i class="la la-file-pdf-o"></i><span>Monthly
                                                                Report</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('records.years') }}"
                                                        data-toggle=""><i class="la la-check-square"></i><span>Records
                                                                by date</span></a>
                                        </li>
                                </ul>
                                @endif
                                @if (Auth::user()->getRoleNames()->contains('employee'))
                                <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('monthly.emp') }}"
                                                        data-toggle=""><i
                                                                class="la la-file-pdf-o"></i><span>{{ Carbon\Carbon::now()->englishMonth }}
                                                                Report</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('lastmonth.emp') }}"
                                                        data-toggle=""><i
                                                                class="la la-check-square"></i><span>{{ Carbon\Carbon::now()->subMonth()->englishMonth }}
                                                                Report</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('emp.allrecords') }}"
                                                        data-toggle=""><i class="la la-check-square"></i><span>Records
                                                                by date</span></a>
                                        </li>

                                </ul>
                                @endif
                        </li>
                        
                        @if (Auth::user()->getRoleNames()->contains('Admin'))
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                        data-toggle="dropdown"><i class="la la-cogs"></i><span>Settings</span></a>
                                <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('settings.show', 1) }}"
                                                        data-toggle=""><i class="la la-cogs"></i><span>Settings
                                                                page</span></a>
                                        </li>
                                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                                        class="dropdown-item dropdown-toggle" href="#"
                                                        data-toggle="dropdown"><i class="la la-cogs"></i><span>Business
                                                                Hours</span></a>
                                                <ul class="dropdown-menu">
                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('businesshours.show', 1) }}"
                                                                        data-toggle=""><span>Display Business
                                                                                Hours</span></a>
                                                        </li>
                                                        <li data-menu=""><a class="dropdown-item"
                                                                        href="{{ route('businesshours.create', 1) }}"
                                                                        data-toggle=""><span>Change Business
                                                                                Hours</span></a>
                                                        </li>
                                                </ul>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('add.holidays') }}"
                                                        data-toggle=""><i
                                                                class="la la-cogs"></i><span>Holidays</span></a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="{{ route('get.company') }}"
                                                data-toggle=""><i
                                                        class="la la-cogs"></i><span>Companies</span></a>
                                </li>
                                </ul>
                        </li>
                        @endif
                </ul>
        </div>
</div>
@endauth
<!-- END: Main Menu-->