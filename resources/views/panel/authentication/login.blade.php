<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود</title>

    <!-- FAVICON -->
    <link rel="icon" href="https://php.spruko.com/spruha/spruha/assets/img/brand/favicon.ico">

        
    <!-- BOOTSTRAP CSS -->
    <link  id="style" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- ICONS CSS -->
    <link href="{{asset('assets/plugins/web-fonts/icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/web-fonts/plugin.css')}}" rel="stylesheet">

    <!-- STYLE CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet">

    <!-- SWITCHER CSS -->
    <link href="{{asset('assets/switcher/css/switcher.css')}}" rel="stylesheet">
    <link href="{{asset('assets/switcher/demo.css')}}" rel="stylesheet">
    
    <!-- FONT CSS -->
    <link href="{{asset('assets/css/fonts.css')}}" rel="stylesheet">

</head>

<body class="font-i-sans">
    <div class="page main-signin-wrapper">
        <!-- Row -->
        <div class="row signpages text-center">
            {{-- @include('flash-messages.messages') --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 pos-absolute">
                                <div class="clearfix"></div>
                                <img src="https://php.spruko.com/spruha/spruha/assets/img/svgs/user.svg"
                                    class="ht-100 mb-0" alt="user">
                                <h5 class="mt-4 text-white">ورود کاربر</h5>

                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" role="alert">
                                <span class="alert-inner--text">ایمیل یا رمز عبور نادرست است</span>
                                </button>
                            </div>
                            @endif
                            <div class="main-container container-fluid">
                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                        <img src="assets/img/brand/logo-light.png"
                                            class="d-lg-none header-brand-img text-start float-start mb-4 error-logo-light"
                                            alt="logo">
                                        <img src="assets/img/brand/logo.png"
                                            class=" d-lg-none header-brand-img text-start float-start mb-4 error-logo"
                                            alt="logo">
                                        <div class="clearfix"></div>
                                        <form action="{{route('login')}}" method="POST">
                                            @csrf
                                            <h5 class="text-start mb-2">ورود کاربر</h5>

                                            <div class="form-group text-start">
                                                <label>ایمیل</label>
                                                <input class="form-control" name="email"
                                                    placeholder="ایمیل خود را وارد کنید" type="email">
                                            </div>
                                            <div class="form-group text-start">
                                                <label>رمز عبور</label>
                                                <input class="form-control" name="password"
                                                    placeholder="رمز خود را وارد کنید" type="password">
                                            </div>
                                            <button type="submit"
                                                class="btn btn-main-primary btn-block text-white">ورود</button>
                                        </form>
                                        <div class="text-start mt-5 ms-0">
                                            {{-- <div class="mb-1"><a href="forgot.html">Forgot password?</a></div> --}}
                                            <div>Don't have an account? <a href="{{route('register.form')}}">Register
                                                    Here</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->


    </div>
</body>

</html>