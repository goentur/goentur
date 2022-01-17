<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | BKPSDM Kota Pekalongan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="BKPSDM Kota Pekalongan" name="{{ config('app.name') }}" />
    <meta content="TIM IT BKPSDM Kota Pekalongan" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="icon" href="{{ asset('images/sub.png') }}">
    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="authentication-page">
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4" data-aos="zoom-in-down">
                        <div class="card-header bg-primary p-3 border border-primary bg-img position-relative text-center">
                            <img src="{{ asset('images/none.png') }}" class="img-fluid rounded-circle avatar-xl img-thumbnail" style="height: 90px" alt="gambar user}">
                            <h3 class="text-white text-center mb-0">{{ Auth::user()->name }}</h3>
                            <h6 class="text-white text-center mb-0">{{ Auth::user()->email }}</h6>
                        </div>
                        <div class="card-body border border-primary border-top-0">
                            <form action="{{ '/unlock' }}" method="post" class="text-center p-3">
                                @csrf
                                <div class="mb-3"><p class="text-muted m-0">Akun anda terkunci.</p>
                                <p class="text-muted m-0">Silahkan masukan password anda untuk melanjutkan.</p></div>
                                <div class="input-group mb-3" id="show_hide_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" autofocus id="password" required name="password" class="form-control form-control-lg" placeholder="Password">
                                    <div class="input-group-append">
                                        <a href="javascript:void(0)" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    {!! htmlFormSnippet() !!}
                                </div>
                                <div class="form-group text-center mt-3">
                                    <button class="btn btn-primary btn-lg waves-effect btn-block width-md waves-light" type="submit"> <i class="mdi mdi-arrow-right-box"></i> MASUK </button>
                                </div>
                            </form>
                            <div class="text-right pr-3 pt-0 mt-0">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">BUKAN {{ Auth::user()->name }} ?</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                            <hr class="bg-primary">
                            <div class="mb-0 text-center">
                                Copyright &copy; {{ date('Y') }}<br>TIM-IT BKPSDM Kota Pekalongan.
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <!-- end row -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
    <script>
        $(document).ready(function() {
            AOS.init();
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
</body>

</html>