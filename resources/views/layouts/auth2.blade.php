<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>

    @include('layouts.partials.css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        .btn-register {
            background-color: #ff5a1f !important;
            padding: 1.2rem;
            border-radius: 8px;
        }

        .btn-register:hover {
            background-color: rgb(230, 66, 7) !important;
            color: #FFF !important;
        }

        .btn-login {
            background-color: #ff5a1f;
            padding: 1.2rem;
            border-radius: 8px;
        }

        .btn-login:hover {
            background-color: rgb(230, 66, 7);
            color: #FFF;
        }

        .lang-select {
            padding: 1.2rem;
            border-radius: 8px;
        }

        .pricing {
            padding: 1rem;
            color: #FFF;
            border: 1px solid rgb(27, 26, 26);
            background-color: rgb(27, 26, 26);
            border-radius: 8px;
        }
    </style>
</head>

<body>
    @inject('request', 'Illuminate\Http\Request')
    @if (session('status'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
            data-msg="{{ session('status.msg') }}">
    @endif
    <div class="container-fluid">
        <div class="row eq-height-row">
            <div class="col-md-5 col-sm-5 hidden-xs left-col eq-height-col">
                <div class="left-col-content login-header">
                    <div style="margin-top: 50%;">
                        <!-- <a href="/">
                    @if(file_exists(public_path('uploads/logo.png')))
                        <img src="/uploads/logo.png" class="img-rounded" alt="Logo" width="150">
                    @else
                      <span class="bigt"> {{ config('app.name', 'ultimatePOS') }}</span>
                    @endif 
                    </a>
                    <br/>
                    @if(!empty(config('constants.app_title')))
                        <small class="t">{{config('constants.app_title')}}</small>
                    @endif-->
                    </div>
                    <style>
                        .t {
                            color: #90EE90;
                        }

                        .bigt {
                            font-size: 80px;
                            margin: auto;
                        }
                    </style>
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12 right-col eq-height-col" style="background:#FFDEBC;">
                <div class="row-" style="margin-top: 1rem;">
                    <div class="col-md-3 col-xs-4" style="text-align: left;">
                        <select class="lang-select" id="change_lang">
                            @foreach(config('constants.langs') as $key => $val)
                                                        <option value="{{$key}}" @if(
                                                            (empty(request()->lang) && config('app.locale') == $key)
                                                            || request()->lang == $key
                                                        ) selected @endif>
                                                            {{$val['full_name']}}
                                                        </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-9 col-xs-8" style="text-align: right;margin-top: 10px;">
                        @if(!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                            <!-- Register Url -->
                            @if(config('constants.allow_registration'))
                                <a href="{{ route('business.getRegister') }}@if(!empty(request()->lang)){{'?lang=' . request()->lang}} @endif"
                                    class="btn-register"><b>{{ __('business.not_yet_registered')}}</b>
                                    {{ __('business.register_now') }}</a>
                                <!-- pricing url -->
                                @if(Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing')
                                    &nbsp; <a href="{{ action('\Modules\Superadmin\Http\Controllers\PricingController@index') }}"
                                        class="pricing">@lang('superadmin::lang.pricing')</a>
                                @endif
                            @endif
                        @endif
                        @if($request->segment(1) != 'login')
                            &nbsp; &nbsp;<span style="color:#6c757d;">{{ __('business.already_registered')}} </span><a
                                href="{{ action('Auth\LoginController@login') }}@if(!empty(request()->lang)){{'?lang=' . request()->lang}} @endif"><span
                                    style="color:#6c757d;">{{ __('business.sign_in') }}</span></a>
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    @include('layouts.partials.javascripts')

    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>

    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2_register').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>