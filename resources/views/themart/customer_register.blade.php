<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from wpocean.com/html/tf/themart/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:41 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="{{ asset('TheMart') }}/assets/images/favicon.png">
    <title>Themart - eCommerce HTML5 Template</title>
    <link href="{{ asset('TheMart') }}/assets/css/themify-icons.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/flaticon_ecommerce.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/animate.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/owl.carousel.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/owl.theme.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/slick.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/slick-theme.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/swiper.min.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/owl.transitions.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/jquery.fancybox.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/css/odometer-theme-default.css" rel="stylesheet">
    <link href="{{ asset('TheMart') }}/assets/sass/style.css" rel="stylesheet">
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{ asset('TheMart') }}/assets/images/preloader.png" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->

        <div class="wpo-login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="wpo-accountWrapper" action="{{ route('register.store') }}" method="POST">
                            @csrf
                            <div class="wpo-accountInfo">
                                <div class="wpo-accountInfoHeader">
                                    <a href="{{ url('/') }}"><img src="{{ asset('TheMart') }}/assets/images/logo-2.svg" alt=""></a>
                                    <a class="wpo-accountBtn" href="{{ route('user.login') }}">
                                        <span class="">Log in</span>
                                    </a>
                                </div>
                                <div class="image">
                                    <img src="{{ asset('TheMart') }}/assets/images/login.svg" alt="">
                                </div>
                                <div class="back-home">
                                    <a class="wpo-accountBtn" href="{{ url('/') }}">
                                        <span class="">Back To Home</span>
                                    </a>
                                </div>
                            </div>
                            <div class="wpo-accountForm form-style">
                                <div class="fromTitle">
                                    <h2>Signup</h2>
                                    <p>Sign into your pages account</p>
                                    @if (session('pass_error'))
                                    <div class="alert alert-danger">{{ session('pass_error') }}</div>
                                    @elseif (session('register_success'))
                                    <div class="alert alert-success">{{ session('register_success') }}</div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="name">Full Name</label>
                                        <input type="text" id="name" name="name" placeholder="Your name here..">
                                            @error('name')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label>Email</label>
                                        <input type="text" id="email" name="email" placeholder="Your email here..">
                                            @error('email')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="pwd2" type="password" placeholder="Your password here.." name="password">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal3" type="button"><i class="ti-eye"></i></button>
                                            </span>
                                            @error('password')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input class="pwd3" type="password" placeholder="Your password here.." name="password_confirmation">
                                            @error('password_confirmation')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal2" type="button"><i class="ti-eye"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="wpo-accountBtn">Signup</button>
                                    </div>
                                </div>
                                
                                <p class="subText">Sign into your pages account <a href="{{ route('user.login') }}">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{ asset('TheMart') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('TheMart') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!-- Plugins for this template -->
    <script src="{{ asset('TheMart') }}/assets/js/modernizr.custom.js"></script>
    <script src="{{ asset('TheMart') }}/assets/js/jquery.dlmenu.js"></script>
    <script src="{{ asset('TheMart') }}/assets/js/jquery-plugin-collection.js"></script>
    <!-- Custom script for this template -->
    <script src="{{ asset('TheMart') }}/assets/js/script.js"></script>
</body>


<!-- Mirrored from wpocean.com/html/tf/themart/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:41 GMT -->
</html>