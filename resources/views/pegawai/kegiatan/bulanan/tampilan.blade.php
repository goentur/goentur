@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">DATA KEGIATAN BULANAN</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">KEGIATAN</li>
                    <li class="breadcrumb-item active">DATA KEGIATAN BULANAN</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card">
            <div class="card-header border border-primary">
                <form action="javascript:void(0)" class="form-horizontal" method="post">
                    <div class="form-group row">
                        <label class="col-lg-3 control-label" for="bulan-pengerjaan"><h4>PILIH BULAN PENGERJAAN</h4></label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <div class="input-group-prepend" for="bulan-pengerjaan">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-month-outline"></i></span>
                                </div>
                                <input type="text" id="bulan-pengerjaan" name="bulan_pengerjaan" class="form-control form-control-lg bulan-umum" value="{{ date('m-Y') }}" placeholder="Pilih bulan pengerjaan">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="btn-cari-data-bulanan" type="submit"><i class="mdi mdi-calendar-search"></i> CARI</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="data-kegiatan-bulanan"></div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection
@push('javascript')
<script>
    var _token = "{{ csrf_token() }}";
    $(document).on("click", "#btn-cari-data-bulanan", function() {
        if (cekKoneksiInternet()) {
            var val = $('#bulan-pengerjaan').val();
            if (val) {
                tampil(val)
            } else {
                alert_error("MAAF!!!", "Pilih tanggal terlebih dahulu");
            }
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });
    function tampil(t) {
        if (cekKoneksiInternet()) {
            loading();
            $.when(
                $.ajax({
                    url: "{{ '/pegawai/data-kegiatan-bulanan' }}",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        _token: _token,
                        tanggal: t,
                    },
                    success: function(a) {
                        if (a !== null) {
                            $('#data-kegiatan-bulanan').html(a);
                        } else {
                            alert_error("MAAF!!!", "Data kegiatan bulanan gagal ditampilkan");
                        }
                    },
                    error: function(a, t, e) {
                        alert_error("MAAF!!!", "Data kegiatan bulanan gagal ditampilkan");
                    },
                })
            ).done(function() {
                unLoading();
            });
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    }
</script>
@endpush