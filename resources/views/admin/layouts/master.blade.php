<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>@yield('title')</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('admin/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('admin/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet"
        media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('admin/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('admin/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('admin/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('admin/css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="{{ route('admin#category#list') }}">
                    <img src="{{ asset('admin/images/icon/logo.png') }}" alt="Cool Admin">
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="{{ route('admin#account#listPage') }}">
                                <i class="fas fa-users"></i>Admins & Users
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a class="js-arrow" href="{{ route('admin#category#list') }}">
                                <i class="fas fa-list"></i>Categories
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a class="js-arrow" href="{{ route('admin#product#listPage') }}">
                                <i class="fas fa-shopping-bag"></i>Products
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a class="js-arrow" href="{{ route('admin#order#listPage') }}">
                                <i class="fab fa-shopify"></i></i>Orders
                            </a>
                        </li>
                        <li class="active has-sub">
                            <a class="js-arrow" href="{{ route('admin#contact#listPage') }}">
                                <i class="fas fa-envelope"></i></i>Messages
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <h3 class="form-header" style="cursor: pointer;">Admin Dashboard Panel</h3>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            @if (Auth::user()->image == null)
                                                @if (Auth::user()->gender == 'male')
                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/female_default.webp') }}"
                                                        class="rounded-circle">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/admin_profile/' . Auth::user()->image) }}"
                                                    class="rounded-circle">
                                            @endif

                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn text-capitalize"
                                                href="javascript:void(0);">{{ Auth::user()->name }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="javascript:void(0);">
                                                        @if (Auth::user()->image == null)
                                                            @if (Auth::user()->gender == 'male')
                                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                                    class="rounded-circle">
                                                            @else
                                                                <img src="{{ asset('images/female_default.webp') }}"
                                                                    class="rounded-circle">
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('storage/admin_profile/' . Auth::user()->image) }}"
                                                                class="rounded-circle">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="javascript:void(0);">{{ Auth::user()->name }}</a>
                                                    </h5>
                                                    <span class="email">{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('admin#account#detailsPage') }}">
                                                        <i class="fas fa-user"></i>Account</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('admin#account#changePasswordPage') }}">
                                                        <i class="fas fa-key"></i>Change Password</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn-block text-left py-3 ps-2">
                                                        <i class="fas fa-sign-out-alt mx-4"></i>Logout
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->
            @yield('content')
        </div>
    </div>
    <!-- Jquery JS-->
    <script src="{{ asset('admin/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('admin/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('admin/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/select2/select2.min.js') }}"></script>

    {{-- Sweet alert 2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Sweet alert 1 --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Main JS-->
    <script src="{{ asset('admin/js/main.js') }}"></script>

    @yield('script')
</body>

</html>
<!-- end document-->
