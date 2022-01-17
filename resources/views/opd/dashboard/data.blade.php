@extends('template')

@section('content')<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">DATA BARANG</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">BARANG</li>
                    <li class="breadcrumb-item active">DATA BARANG</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="" class="btn btn-primary btn-lg waves-effect waves-light"> <i class="fa fa-plus"></i> <span>TAMBAH DATA BARANG</span> </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12 table-responsive">
                        <table id="databarang" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>NAMA BARANG</th>
                                    <th>RESELLER</th>
                                    <th class="text-right">HARGA BELI</th>
                                    <th width="1%">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection

@push('javascript')
ok
@endpush
