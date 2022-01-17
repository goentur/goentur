@extends('template')

@section('content')<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">422</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">ERROR 422</li>
                    <li class="breadcrumb-item active">DATA TIDAK BISA DIPROSES</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row justify-content-center text-center">
    <div class="col-12">
        <div class="wrapper-page">
            <div class="text-center">
                <h1>422!</h1>
                <h2>MAAF, DATA TIDAK BISA DIPROSES.</h2>
                <br>
            </div>
        </div>
        <!-- end wrapper page -->
    </div>
</div>
<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="text-danger"><i class="mdi mdi-email"></i> PESAN!</h5>
    <ul class="list-unstyled mb-0">
        @for ($i = 1; $i <= count($pesan); $i++)
        <li><i class="text-danger mdi mdi-hand-pointing-right"></i> {!! $pesan[$i] !!}</li>
        @endfor
    </ul>
</div>
@endsection