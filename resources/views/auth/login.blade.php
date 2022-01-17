<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | BKPPD Kota Pekalongan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="BKPPD Kota Pekalongan" name="{{ config('app.name') }}" />
    <meta content="TIM IT BKPPD Kota Pekalongan" name="author" />
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
    <div class="account-pages my-2">
        <div class="container">
            <div class="row justify-content-center modal-dialog-centered">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4" data-aos="zoom-in-down">
                        <div class="card-header bg-primary border border-primary bg-img position-relative text-center">
                            <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="height: 90px" alt="LOGO {{ config('app.name') }}">
                            <h3 class="text-white text-center mb-0">{{ config('app.name') }}</h3>
                            <h5 class="text-white text-center mb-0">BKPPD KOTA PEKALONGAN</h5>
                        </div>
                        <div class="card-body border border-primary border-top-0">
                            <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data" class="p-3 mt-2">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="text" value="{{ old('email') }}" autofocus="autofocus" autocomplete="email" required id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-3" id="show_hide_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" id="password" required name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password">
                                    <div class="input-group-append">
                                        <a href="javascript:void(0)" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">Remember me</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! htmlFormSnippet() !!}
                                    {!! ReCaptcha::htmlScriptTagJsApi() !!}
                                </div>
                                <div class="form-group text-center mt-3 mb-4">
                                    <button class="btn btn-primary btn-lg waves-effect btn-block width-md waves-light" type="submit" id="masuk"> <i class="mdi mdi-arrow-right-box"></i> MASUK </button>
                                </div>
                                <div class="form-group row mb-0 text-center">
                                    <div class="col-sm-12">
                                        Copyright &copy; {{ date('Y') }}<br>TIM-IT BKPSDM Kota Pekalongan.
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
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
    <script>
        $(document).ready(function() {
        AOS.init();
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });
    });
    </script>
</body>
</html>