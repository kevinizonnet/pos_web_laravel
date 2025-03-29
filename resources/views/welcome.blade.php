@extends('layouts.home')
{{-- @section('title', config('app.name', 'ultimatePOS')) --}}

@section('content')
    <style type="text/css">
        /* General container styling */
        .home-container {
            min-height: 70vh;
            background: #FFDEBC;
            /* Warm peachy background */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* padding: 20px; */
            font-family: 'Inter', sans-serif;
            /* Clean, modern font */
            color: #333;
        }

        /* Centered content */
        .flex-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Logo styling */
        .logo {
            width: 200px;
            /* Set a fixed width for consistency */
            height: 200px;
            /* Set a fixed height to maintain aspect ratio */
            margin: 20px 0;
            object-fit: contain;
            /* Ensures the image fits within the dimensions without distortion */
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
            /* Subtle hover effect */
        }

        /* Title styling */
        .title {
            font-size: 3rem;
            font-weight: 700;
            color: #4A2C2A;
            /* Dark brown to complement the peachy background */
            /* margin-bottom: 1rem; */
            text-transform: capitalize;
            letter-spacing: 1px;
        }

        /* Tagline styling */
        .tagline {
            font-size: 1.4rem;
            font-weight: 400;
            color:rgb(27, 26, 26);
            /* Muted brown for the tagline */
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Button container */
        .button-group {
            display: flex;
            gap: 1.5rem;
            /* Space between buttons */
            flex-wrap: wrap;
            /* Allow buttons to wrap if needed */
            justify-content: center;
            /* Center buttons horizontally */
            margin-top: 1rem;
            width: 100%;
            /* Ensure the button group takes full width */
            max-width: 600px;
            /* Limit the width on larger screens for better alignment */
        }

        /* Button styling */
        .home-login,
        .home-register {
            background-color: #D2691E;
            /* Warm chocolate color to match the peachy theme */
            border: none;
            color: white;
            padding: 12px 30px;
            text-align: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            flex: 1;
            /* Allow buttons to grow equally */
            min-width: 200px;
            /* Minimum width to prevent buttons from being too small */
            max-width: 250px;
            /* Maximum width to prevent buttons from being too wide */
        }

        .home-login:hover,
        .home-register:hover {
            background-color: rgb(17 24 39 / 1);
            /* Slightly darker shade on hover */
            /* transform: translateY(-2px); */
            color: #FFF;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 768px) {
            .title {
                font-size: 2.2rem;
            }

            .logo {
                width: 150px;
                /* Reduce size for tablets */
                height: 150px;
            }

            .tagline {
                font-size: 1.2rem;
            }

            .button-group {
                flex-direction: column;
                /* Stack buttons vertically on tablets */
                gap: 1rem;
                max-width: 400px;
                /* Reduce max-width for better fit */
            }

            .home-login,
            .home-register {
                padding: 10px 20px;
                font-size: 1.2rem;
                /* Slightly smaller font size */
                min-width: 180px;
                /* Adjust minimum width */
                max-width: 300px;
                /* Allow buttons to be wider on tablets */
            }
        }

        @media only screen and (max-width: 480px) {
            .title {
                font-size: 1.8rem;
            }

            .logo {
                width: 120px;
                /* Further reduce size for mobile */
                height: 120px;
            }

            .tagline {
                font-size: 1rem;
            }

            .button-group {
                flex-direction: column;
                /* Keep buttons stacked on mobile */
                gap: 0.8rem;
                max-width: 100%;
                /* Allow buttons to take full width on mobile */
                padding: 0 15px;
                /* Add padding to prevent buttons from touching edges */
            }

            .home-login,
            .home-register {
                padding: 8px 15px;
                font-size: 1rem;
                /* Smaller font size for mobile */
                min-width: 100%;
                /* Buttons take full width of the container */
                max-width: 100%;
                /* Ensure buttons stretch to fit */
            }
        }

        /* Specific styling for the logo image */
        .sst {
            width: 100%;
            max-width: 600px;
            /* Ensure the image doesn't exceed this width */
            height: auto;
            /* Let the height adjust automatically to maintain aspect ratio */
            margin-top: 1.5rem;
        }
    </style>

    <div class="home-container">
        <div class="flex-center">
            <h2 class="title">
                {{-- {{ config('app.name', 'ultimatePOS') }} --}}
                Welcome
            </h2>
            <img src="{{ asset('images/logo/Rv.png') }}" class="logo sst" alt="Logo">
            <div class="tagline">
                Your Journey Starts Here
            </div>
            <div class="button-group">
                <a href="/login" class="home-login">Login</a>
                <a href="/business/register" class="home-register">Register</a>
            </div>
        </div>
    </div>

@endsection