<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('user/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- bootstrap css 1 js 1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <!-- Navbar Start -->

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark px-3">
        <a href="{{ route('user#homePage') }}" class="navbar-brand"><span class="text-warning h2">Food</span><span
                class="text-danger h4">House</span></a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarCollapse">
            <ul class="navbar-nav ml-auto py-0">
                <li class="nav-item"><a href="{{ route('user#homePage') }}" class="nav-item nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('user#cartPage') }}" class="nav-item nav-link">My Cart</a></li>
                <li class="nav-item"><a href="{{ route('user#historyPage') }}" class="nav-item nav-link">Orders</a>
                <li class="nav-item"><a href="{{ route('user#contactPage') }}" class="nav-item nav-link">Contact</a>
                </li>
            </ul>
            <div class="ml-auto d-flex">
                <div class="auth_user">
                    @if (Auth::user()->image === null)
                        @if (Auth::user()->gender === 'male')
                            <img src="{{ asset('images/default-user.jpg') }}" class="auth_user_img" />
                        @else
                            <img src="{{ asset('images/female_default.webp') }}" class="auth_user_img" />
                        @endif
                    @else
                        <img src="{{ asset('storage/user_profile/' . Auth::user()->image) }}" class="auth_user_img" />
                    @endif
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->name }} <i
                                class="fas fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('user#account#detailsPage') }}" class="dropdown-item"><i
                                        class="fas fa-user mr-2"></i>
                                    Account</a>
                            </li>
                            <li>
                                <a href="{{ route('user#account#changePasswordPage') }}" class="dropdown-item"><i
                                        class="fas fa-key mr-2"></i> Change Password</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i
                                            class="fas fa-sign-out-alt mr-2"></i>
                                        Logout</button>
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Navbar End -->

    @yield('content')

    {{-- Request::has() returns false even when parameter is present --}}
    {{-- {{ Request::route()->getName() }} --}}
    {{-- {{ strpos(Request::url(), 'asdf') == 0 ? 'yes' : 'no' }} --}}
    {{-- 0 == false --}}
    @if (strpos(Request::url(), 'account') == false)
        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
            <div class="row px-xl-5 pt-5">
                <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                    <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                    <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed
                        dolor. Rebum tempor no vero est magna amet no</p>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA
                    </p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-md-4 mb-5">
                            <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Home</a>
                                <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our
                                    Shop</a>
                                <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop
                                    Detail</a>
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Shopping
                                    Cart</a>
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Checkout</a>
                                <a class="text-secondary" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Contact
                                    Us</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Home</a>
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Our
                                    Shop</a>
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Shop
                                    Detail</a>
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Shopping
                                    Cart</a>
                                <a class="text-secondary mb-2" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Checkout</a>
                                <a class="text-secondary" href="#"><i
                                        class="fa fa-angle-right mr-2"></i>Contact
                                    Us</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                            <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                            <form action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Your Email Address">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                            <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                            <div class="d-flex">
                                <a class="btn btn-primary btn-square mr-2" href="#"><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-primary btn-square mr-2" href="#"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary btn-square mr-2" href="#"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a class="btn btn-primary btn-square" href="javascript:void(0);"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
                <div class="col-md-6 px-xl-0">
                    <p class="mb-md-0 text-center text-md-left text-secondary">
                        &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                        by
                        <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                    </p>
                </div>
            </div>
        </div>
        <!-- Footer End -->
    @endif

    <!-- Back to Top -->
    <a href="javascript:void(0);" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('user/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('user/mail/contact.js') }}"></script>

    {{-- Sweet alert 2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- bootstrap css 1 js 1 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('user/js/main.js') }}"></script>

    @yield('script')
</body>

</html>
