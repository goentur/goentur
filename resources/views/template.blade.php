<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell noti-icon"></i>
                        <span class="badge badge-danger rounded-circle noti-icon-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="font-16 m-0">
                                <span class="float-right">
                                    <a href="#" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon">
                                    <i class="fa fa-user-plus text-info"></i>
                                </div>
                                <p class="notify-details">New user registered
                                    <small class="noti-time">You have 10 unread messages</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon text-success">
                                    <i class="far fa-gem text-primary"></i>
                                </div>
                                <p class="notify-details">New settings
                                    <small class="noti-time">There are new settings available</small>
                                </p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon text-danger">
                                    <i class="far fa-bell text-danger"></i>
                                </div>
                                <p class="notify-details">Updates
                                    <small class="noti-time">There are 2 new updates available</small>
                                </p>
                            </a>
                        </div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center notify-item notify-all">
                            See all notifications
                        </a>
                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="@if (session()->get('_jenis_kelamin')=='p'){{ asset('images/p.png') }}@elseif(session()->get('_jenis_kelamin')=='l'){{ asset('images/l.png') }}@else{{ asset('images/logo.png') }}@endif" alt="user-image" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Selamat datang!</h6>
                            <br>
                            <h6 class="text-overflow m-0">{{ session()->get('_nama_pegawai') }}</h6>
                            <h6 class="text-overflow m-0">{{ Auth::user()->email }}</h6>
                        </div>
                        <div class="dropdown-divider"></div>
                        <!-- item-->
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                            <i class="mdi mdi-power-settings"></i>
                            <span>Logout</span>
                        </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                         </form>
                    </div>
                </li>
            </ul>
            <!-- LOGO -->
            <div class="logo-box">
                <a href="a" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <span class="logo-lg-text-dark text-white" style="font-size: 35px">{{ config('app.name') }}</span>
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="" height="35">
                    </span>
                </a>
            </div>
            <!-- LOGO -->
            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
            </ul>
        </div>
        <!-- end Topbar -->
        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <div class="user-box text-center bg-img text-white text-white border border-primary border-left-0 border-top-0 border-right-0">
                         <img src="@if (session()->get('_jenis_kelamin')=='p'){{ asset('images/p.png') }}@elseif(session()->get('_jenis_kelamin')=='l') {{ asset('images/l.png') }}@else{{ asset('images/logo.png') }}@endif" style="width:30%;height:100%" class="rounded-circle img-thumbnail"  alt="foto profil">
                         <h6 class="text-white">{{ session()->get('_nama_pegawai') }}</h6>
                         {{ session()->get('_nip') }}<br>{{ Auth::user()->email }} 
                    </div>
                    @include('partials.sidebar')
                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- end container-fluid -->
            </div>
            <!-- end content -->
            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            Copyright &copy; {{ date('Y') }} TIM-IT BKPSDM Kota Pekalongan
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

    </div>
    <!-- END wrapper -->
@include('partials.scripts')
</body>

</html>