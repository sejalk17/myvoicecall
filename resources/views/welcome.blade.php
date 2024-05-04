<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OBD</title>

    <!-- load stylesheets -->
    <link rel="stylesheet" href="{{asset('webtheme/bill/css/bootstrap.min.css')}}"> <!-- Bootstrap style -->
    <link rel="stylesheet" href="{{asset('webtheme/bill/css/hero-slider-style.css')}}"> <!-- Hero slider style (https://codyhouse.co/gem/hero-slider/) -->
    <link rel="stylesheet" href="{{asset('webtheme/bill/css/templatemo-style.css')}}"> <!-- Templatemo style -->
    <link rel="stylesheet" href="{{asset('webtheme/bill/css/magnific-popup.css')}}"> <!-- Magnific popup style (http://dimsemenov.com/plugins/magnific-popup/) -->
    <link rel="stylesheet" href="{{asset('webtheme/bill/font-awesome-4.6.3/css/font-awesome.min.css')}}"> <!-- Font awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400"> <!-- Google web font "Open Sans" -->



    <style>
        .fa-heart {
            animation: 2.5s ease 0s normal none infinite running animateHeart;
            color: #ff0000;
            font-size: 25px !important;
        }
    </style>
</head>

<body>
    <div style="background-color:#00000063; color:#fff; padding:7px; font-family:monotype;c font-size:10px;">Reg. no.:- RF/JPR/2021/4669
        <span class="pull-right"><a href="{{ route('login') }}" class="btn btn-success btn-xl ">Login</a></span>
    </div>
    <!-- Content -->
    <div class="cd-hero">

        <!-- Navigation -->
        <div class="cd-slider-nav">
            <nav class="navbar">

                <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                    &#9776;
                </button>
                <div class="collapse navbar-toggleable-sm text-xs-center text-uppercase tm-navbar" id="tmNavbar">
                    <ul class="nav navbar-nav">
                        <li class="nav-item active selected">
                            <a class="nav-link" href="#0" data-no="1">Intro <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#0" data-no="2">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#0" data-no="3">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#0" data-no="4">Video</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#0" data-no="5">Contact</a>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>

        <ul class="cd-hero-slider">
            <!-- autoplay -->
            <li class="selected">
                <div class="cd-full-width">
                    <div class="container js-tm-page-content" data-page-no="1">

                        <div class="row">
                            <div class="flash-message">
                                @if (Session::has('message'))
                                <center>
                                    <h6 class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                        <b>{{ Session::get('message') }}</b>
                                    </h6>
                                </center>
                                @endif
                            </div> <!-- end .flash-message -->
                            <div class="col-xs-12">
                                <img src="https://myvoicecall.com/skote/layouts/assets/images/logo-light.png" width="20% !important">
                                <h2 class="tm-site-name"></h2>
                                <div class="tm-bg-white-translucent text-xs-left tm-textbox tm-textbox-1-col">
                                    <p class="tm-text"> <a rel="nofollow" href="https://codyhouse.co/gem/hero-slider/" target="_blank">Hero Slider</a> for left and right page transitions. Responsiveness is based on <a rel="nofollow" href="http://getbootstrap.com/" target="_blank">Bootstrap</a> 4 alpha 2. Images are taken from <a rel="nofollow" href="https://unsplash.com/" target="_blank">Unsplash</a>. This web template is provided by <a href="https://plus.google.com/+templatemo" target="_blank">templatemo</a> for free of charge.</p>
                                    <p class="tm-text">Mauris eros lacus, sollicitudin sit amet lacinia et, vehicula bibendum felis. Pellentesque in quam iaculis erat iaculis lacinia. Donec sagittis sapien odio, a sodales velit elementum nec.</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div> <!-- .cd-full-width -->
            </li>

            <li>
                <div class="cd-full-width">

                    <div class="container-fluid js-tm-page-content" data-page-no="2">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tm-2-col-container">

                                    <div class="tm-bg-white-translucent text-xs-left tm-textbox tm-2-col-textbox">
                                        <h2 class="tm-text-title">Lorem ipsum dolor</h2>
                                        <p class="tm-text">Quisque sagittis quam tortor, sit amet posuere justo tempor non. Cras tempus, eros vel ultrices aliquam, velit tortor sodales risus, ac facilisis lectus tortor eget neque.</p>
                                        <p class="tm-text">Nam auctor dui ante. Curabitur tristique nec ligula ac semper. Nunc eu leo sit amet elit condimentum consectetur.</p>
                                    </div>

                                    <div class="tm-bg-white-translucent text-xs-left tm-textbox tm-2-col-textbox">
                                        <h2 class="tm-text-title">Phasellus rutrum sapien</h2>
                                        <p class="tm-text">
                                            Donec sagittis sapien odio, a sodales velit elementum nec. Donec feugiat purus a bibendum hendrerit.</p>
                                        <p class="tm-text">Fusce ut elit interdum sem consectetur maximus. Mauris eros lacus, sollicitudin sit amet lacinia et, vehicula bibendum felis. Pellentesque in quam iaculis erat iaculis lacinia.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- .cd-full-width -->

            </li>

            <!-- Page 3 -->
            <li>

                <div class="cd-full-width">

                    <div class="container-fluid js-tm-page-content" data-page-no="3">

                        <div class="row tm-img-gallery">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{asset('webtheme/bill/img/tm-img-01.jpg')}}">
                                    <img src="{{asset('webtheme/bill/img/tm-img-01-tn.jpg')}}" alt="Image" class="img-fluid tm-img">
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{asset('webtheme/bill/img/tm-img-02.jpg')}}">
                                    <img src="{{asset('webtheme/bill/img/tm-img-02-tn.jpg')}}" alt="Image" class="img-fluid tm-img">
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{asset('webtheme/bill/img/tm-img-03.jpg')}}">
                                    <img src="{{asset('webtheme/bill/img/tm-img-03-tn.jpg')}}" alt="Image" class="img-fluid tm-img">
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{asset('webtheme/bill/img/tm-img-04.jpg')}}">
                                    <img src="{{asset('webtheme/bill/img/tm-img-04-tn.jpg')}}" alt="Image" class="img-fluid tm-img">
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{asset('webtheme/bill/img/tm-img-05.jpg')}}">
                                    <img src="{{asset('webtheme/bill/img/tm-img-05-tn.jpg')}}" alt="Image" class="img-fluid tm-img">
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <a href="{{asset('webtheme/bill/img/tm-img-06.jpg')}}">
                                    <img src="{{asset('webtheme/bill/img/tm-img-06-tn.jpg')}}" alt="Image" class="img-fluid tm-img">
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </li>

            <li>
                <!-- class="cd-bg-video" -->
                <div class="js-tm-page-content" data-page-no="4">

                    <div class="cd-bg-video-wrapper" data-video="https://bills.eleit.in/webtheme/bill/video/sunset-loop">
                        <!-- video element will be loaded using jQuery -->
                    </div> <!-- .cd-bg-video-wrapper -->

                </div>

            </li>

            <li>
                <div class="cd-full-width">

                    <div class="container-fluid js-tm-page-content" data-page-no="5">

                        <div class="tm-contact-page">

                            <div class="row">

                                <div class="col-xs-12">
                                    <h2 class="tm-section-title">Contact Us</h2>
                                    <p class="tm-text tm-font-w-400" style="color:#fff;  text-shadow: 2px 2px #000;">Address: 02, Behind SBI Bank Bassi Jaipur Rajsthan 303301
                                    <p>
                                    <p class="tm-text tm-font-w-400" style="color:#fff;  text-shadow: 2px 2px #000;">01429-294230, 9602495664</p>
                                    <p class="tm-text tm-font-w-400 m-b-3" style="text-shadow: 2px 2px #000;"><a style="color:#fff !important;  " href="mailto:rahul@dakshinfo.com">rahul@dakshinfo.com</a></p>
                                </div>

                            </div>

                            <!-- contact form -->
                            <div class="row">


                                <form action="{{ url('contact_store') }}" method="post" class="tm-contact-form">
                                    @csrf
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <input type="text" id="contact_name" name="contact_name" class="form-control" placeholder="Your Name" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" id="contact_email" name="contact_email" class="form-control" placeholder="Your Email" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="contact_subject" name="contact_subject" class="form-control" placeholder="Subject" required />
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <textarea id="contact_message" name="contact_message" class="form-control" rows="5" placeholder="Your message" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <button type="submit" class="pull-xs-right tm-submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div> <!-- .cd-full-width -->
            </li>
        </ul> <!-- .cd-hero-slider -->

        <footer class="tm-footer">

            <div class="tm-social-icons-container">
                <a href="#" class="tm-social-link"><i class="fa fa-facebook"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-google-plus"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-twitter"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-behance"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-linkedin"></i></a>
            </div>

            <p class="tm-copyright-text">Copyright &copy; 2022 Design and Developed by <a href="https://www.eezib.com" target="_blank">Eezib Technology</a></p>

        </footer>

    </div> <!-- .cd-hero -->


    <!-- Preloader, https://ihatetomatoes.net/create-custom-preloading-screen/ -->
    <div id="loader-wrapper">

        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <!-- load JS files -->
    <script src="{{asset('webtheme/bill/js/jquery-1.11.3.min.js')}}"></script> <!-- jQuery (https://jquery.com/download/) -->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script> <!-- Tether for Bootstrap (http://stackoverflow.com/questions/34567939/how-to-fix-the-error-error-bootstrap-tooltips-require-tether-http-github-h) -->
    <script src="{{asset('webtheme/bill/js/hero-slider-main.js')}}"></script> <!-- Hero slider (https://codyhouse.co/gem/hero-slider/) -->
    <script src="{{asset('webtheme/bill/js/jquery.magnific-popup.min.js')}}"></script> <!-- Magnific popup (http://dimsemenov.com/plugins/magnific-popup/) -->
    <script src="{{asset('webtheme/bill/js/bootstrap.min.js')}}"></script> <!-- Bootstrap js (v4-alpha.getbootstrap.com/) -->

    <script>
        function adjustHeightOfPage(pageNo) {

            // Get the page height
            var totalPageHeight = 15 + $('.cd-slider-nav').height() +
                $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .js-tm-page-content").height() + 160 +
                $('.tm-footer').height();

            // Adjust layout based on page height and window height
            if (totalPageHeight > $(window).height()) {
                $('.cd-hero-slider').addClass('small-screen');
                $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", totalPageHeight + "px");
            } else {
                $('.cd-hero-slider').removeClass('small-screen');
                $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", "100%");
            }

        }

        /*
            Everything is loaded including images.
        */
        $(window).load(function() {

            adjustHeightOfPage(1); // Adjust page height

            /* Gallery pop up
            -----------------------------------------*/
            $('.tm-img-gallery').magnificPopup({
                delegate: 'a', // child items selector, by clicking on it popup will open
                type: 'image',
                gallery: {
                    enabled: true
                }
            });

            /* Collapse menu after click 
            -----------------------------------------*/
            $('#tmNavbar a').click(function() {
                $('#tmNavbar').collapse('hide');

                adjustHeightOfPage($(this).data("no")); // Adjust page height       
            });

            /* Browser resized 
            -----------------------------------------*/
            $(window).resize(function() {
                var currentPageNo = $(".cd-hero-slider li.selected .js-tm-page-content").data("page-no");
                adjustHeightOfPage(currentPageNo);
            });

            // Remove preloader
            // https://ihatetomatoes.net/create-custom-preloading-screen/
            $('body').addClass('loaded');

        });
    </script>

</body>

</html>