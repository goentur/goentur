<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | BKPSDM Kota Pekalongan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="BKPSDM Kota Pekalongan" name="{{ config('app.name') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />

</head>

<body class="authentication-page">

    <div class="account-pages my-5 pt-md-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <div class="wrapper-page">
                        <div class="text-center">
                            <h1>@yield('code')!</h1>
                            <h2>Sorry, @yield('message')</h2>
                            <br>
                            <a class="btn btn-primary btn-lg waves-effect waves-light" href="/"><i class="fa fa-angle-left mr-1"></i> Back to Home</a>
                        </div>
                    </div>
                    <!-- end wrapper page -->
                </div>

            </div>
            <!-- end row -->

        </div>

    </div>

    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

</body>

</html>