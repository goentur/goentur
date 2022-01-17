@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">DASHBOARD</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">DASHBOARD</li>
                    <li class="breadcrumb-item active">DASHBOARD</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-12">
    {!! $lalu !!}
    </div>
    <div class="col-lg-6 col-12">
    {!! $ini !!}
    </div>
</div>
<!-- End Row -->

@endsection

@push('javascript')
ok
@endpush