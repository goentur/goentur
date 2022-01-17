@extends('template')

@section('content')<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">DATA JABATAN & ATASAN</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">JABATAN</li>
                    <li class="breadcrumb-item active">DATA JABATAN & ATASAN</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header card-border bg-img text-center">
                <div class="profile-info-name">
                    <img src="@if (session()->get('_jenis_kelamin')=='p'){{ asset('images/p.png') }}@elseif(session()->get('_jenis_kelamin')=='l') {{ asset('images/l.png') }}@else{{ asset('images/logo.png') }}@endif" class="avatar-xl rounded-circle img-thumbnail"  alt="foto profil">
                    <h5 class="text-white">{{ session()->get('_nama_pegawai') }}</h5>
                    <h6 class="text-white">{{ session()->get('_nip') }}</h6>
                </div>
            </div>
            <div class="card-body border border-primary border-top-0">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary"><i class="mdi mdi-account-box"></i> JABATAN</h5>
                        <table class="table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tr>
                                <td width="1%"><b>JABATAN</b></td>
                                <td width="1%"><b>:</b></td>
                                <td>{{ ucwords($jabatan['jabatan_pns']) }}</td>
                            </tr>
                            <tr>
                                <td><b>OPD</b></td>
                                <td width="1%"><b>:</b></td>
                                <td>{{ strtoupper($jabatan['opd_pns']) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 text-right mt-3">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-users-cog"></i> ROTASI JABATAN </button>
                    </div>
                    @if (session()->get('_jenis_jabatan_lain') != 'kosong')
                    <div class="col-12">
                        <h5 class="text-primary"><i class="mdi mdi-account-box-multiple"></i> JABATAN TAMBAHAN</h5>
                        <table class="table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tr>
                                <td width="1%"><b>JABATAN</b></td>
                                <td width="1%"><b>:</b></td>
                                <td>{{ ucwords(session()->get('_jenis_jabatan_lain')) }} {{ $jabatan['jabatan_tambahan_pns'] }}</td>
                            </tr>
                            <tr>
                                <td><b>OPD</b></td>
                                <td width="1%"><b>:</b></td>
                                <td> {{ strtoupper($jabatan['opd_tambahan_pns']) }}</td>
                            </tr>
                        </table>
                    </div>
                    @endif
                    <div class="col-12 mt-3">
                        <div class="alert alert-info alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="text-primary"><i class="mdi mdi-information"></i> INFORMASI!</h5>
                            <ul class="list-unstyled mb-0">
                                <li><i class="text-primary mdi mdi-hand-pointing-right"></i> Tombol <b>ROTASI JABATAN</b> digunkanan untuk memilih jabatan baru.</li>
                                <li><i class="text-primary mdi mdi-hand-pointing-right"></i> Sesuai dengan nomenklatur pada jabatan yang akan diemban.</li>
                                <li><i class="text-primary mdi mdi-hand-pointing-right"></i> Dengan catatan <b><u>HARUS</u></b> pada OPD yang sama.</li>
                                <li><i class="text-primary mdi mdi-hand-pointing-right"></i> Jika jabatan yang akan diemban <b><u>BEDA</u></b> OPD maka harus hubungi admin BKPPD Kota Pekalongan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        @if ($atasan != null)
        <div class="card">
            <div class="card-header card-border bg-img text-center">
                <div class="profile-info-name">
                    <img src="@if ($atasan['jk']=='p'){{ asset('images/p.png') }}@elseif($atasan['jk']=='l') {{ asset('images/l.png') }}@else{{ asset('images/none.png') }}@endif" class="avatar-xl rounded-circle img-thumbnail"  alt="foto profil">
                    <h5 class="text-white">{{ $atasan['nama'] }}</h5>
                    <h6 class="text-white">{{ $atasan['nip'] }}</h6>
                </div>
            </div>
            <div class="card-body border border-primary border-top-0">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary"><i class="mdi mdi-account-box"></i> JABATAN ATASAN</h5>
                        <table class="table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tr>
                                <td width="1%"><b>JABATAN</b></td>
                                <td width="1%"><b>:</b></td>
                                <td>{{ ucwords($atasan['jabatan']) }}</td>
                            </tr>
                            <tr>
                                <td><b>OPD</b></td>
                                <td width="1%"><b>:</b></td>
                                <td>{{ strtoupper($atasan['opd']) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header card-border bg-img text-center">
                <div class="profile-info-name">
                    <img src="{{ asset('images/none.png')  }}" class="avatar-xl rounded-circle img-thumbnail"  alt="foto profil">
                    <h5 class="text-white">Nama tidak diketahui</h5>
                    <h6 class="text-white">NIP tidak diketahui</h6>
                </div>
            </div>
            <div class="card-body border border-primary border-top-0">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary"><i class="mdi mdi-account-box"></i> JABATAN ATASAN</h5>
                        <table class="table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tr>
                                <td width="1%"><b>JABATAN</b></td>
                                <td width="1%"><b>:</b></td>
                                <td><span class="text-danger">Data tidak ditemukan</span></td>
                            </tr>
                            <tr>
                                <td><b>OPD</b></td>
                                <td width="1%"><b>:</b></td>
                                <td><span class="text-danger">Data tidak ditemukan</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="text-danger"><i class="mdi mdi-email"></i> PESAN!</h3>
                            <ul class="list-unstyled mb-0">
                                <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Pastikan jabatan anda <b><u>SUDAH</u></b> sesuai.</li>
                                <li><i class="text-danger mdi mdi-hand-pointing-right"></i> <b><u>KOORDINASIKAN</u></b> dengan atasan anda.</li>
                                <li><i class="text-danger mdi mdi-hand-pointing-right"></i> <b><u>PASTIKAN</u></b> atasan anda sudah memilih jabatan yang sesuai.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        @endif
    </div>
</div>
<!-- End Row -->
@endsection

@push('javascript')
@endpush
