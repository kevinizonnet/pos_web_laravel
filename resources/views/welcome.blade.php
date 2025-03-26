@extends('layouts.home')
{{-- @section('title', config('app.name', 'ultimatePOS')) --}}

@section('content')
    <style type="text/css">
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
            margin-bottom: 5%;
            width: 100% !important;
        }

        .title {
            font-size: 84px;
        }

        .tagline {
            font-size: 25px;
            font-weight: 300;
            text-align: center;
        }

        .home-login {
            left: 40%;
            position: absolute;
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            color: white;
        }

        .home-register {
            left: 56%;
            position: absolute;
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            color: white;
        }

        @media only screen and (max-width: 668px) {
            .home-login {
                width: 80%;
                left: 41px;
            }

            .home-register {
                width: 80%;
                margin-top: 80px;
                left: 41px;
            }
        }
        @media (max-width:767px) { 
          .title img.sst { width: 100%; height: auto; }
        }

    </style>

    <div class="title flex-center">
        {{-- {{ config('app.name', 'ultimatePOS') }} --}}
        <img src="{{ asset('images/logo/Rv.png') }}" class="sst">
    </div>
<style>
    .sst{
        margin-top:80px;
        width:700px;
        
    }
</style>
    

   
@endsection
