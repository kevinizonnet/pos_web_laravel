<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/favicon.jpeg') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">

        <!-- Custom Styles -->
        <style>
            body {
                min-height: 100vh;
                background-color: #FFDEBC; /* Warm peachy background */
                color: #333; /* Dark text for readability */
                font-family: 'Inter', sans-serif; /* Clean, modern font */
                margin: 0; /* Remove default margin */
            }

            /* Navbar styling */
            .navbar-default {
                background-color:#ff5a1f; /* Dark brown for a premium look */
                border: none;
                padding: 15px 0;
                box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
                transition: all 0.3s ease;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .navbar-static-top {
                margin-bottom: 19px;
            }

            .navbar-default .navbar-brand {
                color:rgb(255, 242, 228); /* Peachy color for contrast */
                font-size: 1.6rem;
                font-weight: 700;
                text-transform: capitalize;
                padding: 15px 20px;
                transition: color 0.3s ease, transform 0.3s ease;
            }

            .navbar-default .navbar-brand:hover {
                color: #FFFFFF; /* White on hover for a clean effect */
                transform: scale(1.05); /* Slight scale on hover */
            }

            .navbar-default .navbar-nav > li > a {
                color: rgb(255, 242, 228); /* Peachy color for nav links */
                font-weight: 600;
                font-size: 15px;
                padding: 15px 20px;
                position: relative;
                transition: color 0.3s ease;
            }

            .navbar-default .navbar-nav > li > a:hover {
                color: #FFF; /* Chocolate orange on hover to match buttons */
            }

            /* Underline effect on hover */
            .navbar-default .navbar-nav > li > a::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: 10px;
                left: 20px;
                background-color: #FFF; /* Chocolate orange underline */
                transition: width 0.3s ease;
            }

            .navbar-default .navbar-nav > li > a:hover::after {
                width: calc(100% - 40px); /* Underline expands on hover */
            }

            /* Sticky navbar effect on scroll */
            .navbar-default.sticky {
                background-color:rgb(173, 84, 0); /* Slightly darker brown when sticky */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }

            /* Container styling */
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 15px;
            }

            .content {
                min-height: calc(100vh - 200px); /* Ensure content takes up remaining space */
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            /* Responsive adjustments */
            @media only screen and (max-width: 768px) {
                .navbar-default {
                    padding: 10px 0;
                }

                .navbar-default .navbar-brand {
                    font-size: 1.4rem;
                    padding: 10px 15px;
                }

                .navbar-default .navbar-nav > li > a {
                    font-size: 14px;
                    padding: 10px 15px;
                }

                .navbar-default .navbar-nav > li > a::after {
                    bottom: 8px;
                    left: 15px;
                }

                .navbar-default .navbar-nav > li > a:hover::after {
                    width: calc(100% - 30px);
                }

                .container {
                    padding: 0 10px;
                }
            }

            @media only screen and (max-width: 480px) {
                .navbar-default .navbar-brand {
                    font-size: 1.2rem;
                    padding: 10px 10px;
                }

                .navbar-default .navbar-nav > li > a {
                    font-size: 13px;
                    padding: 8px 10px;
                }

                .navbar-default .navbar-nav > li > a::after {
                    bottom: 6px;
                    left: 10px;
                }

                .navbar-default .navbar-nav > li > a:hover::after {
                    width: calc(100% - 20px);
                }
            }
        </style>
    </head>

    <body>
        @include('layouts.partials.home_header')
        <div class="container">
            <div class="content">
                @yield('content')
            </div>
        </div>
        @include('layouts.partials.javascripts')

        <!-- Scripts -->
        <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
        @yield('javascript')

        <!-- Sticky Navbar Script -->
        <script>
            window.addEventListener('scroll', function () {
                const navbar = document.querySelector('.navbar-default');
                if (window.scrollY > 50) {
                    navbar.classList.add('sticky');
                } else {
                    navbar.classList.remove('sticky');
                }
            });
        </script>
    </body>
</html>