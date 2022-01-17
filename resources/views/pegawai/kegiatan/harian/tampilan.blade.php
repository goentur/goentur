@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">DATA KEGIATAN HARIAN</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">KEGIATAN</li>
                    <li class="breadcrumb-item active">DATA KEGIATAN HARIAN</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card">
            <div class="card-header border border-primary border-bottom-0">
                <div class="row">
                    @if ($pesan!=null)
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="text-danger"><i class="mdi mdi-email"></i> PESAN!</h3>
                            <ul class="list-unstyled mb-0">
                                @for ($i = 1; $i <= count($pesan); $i++) <li><i class="text-danger mdi mdi-hand-pointing-right"></i> {{ $pesan[$i] }}</li>
                                    @endfor
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-5 col-12">
                        <button type="button" href="javascript:void(0)" class="btn btn-primary btn-block btn-lg waves-effect waves-light" @if ($pesan!=null)disabled @endif data-toggle="modal" data-target="#modal" data-backdrop="static" data-keyboard="false"> <i class="fa fa-plus"></i> <span>TAMBAH KEGIATAN HARIAN</span> </button>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="form-horizontal">
                            <div class="form-group row">
                                <label for="tanggal-kegiatan-harian" class="col-lg-4 control-label">
                                    <h4>PILIH TANGGAL :</h4>
                                </label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" for="tanggal-picker-periode"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                        <input type="text" value="{{ date('d-m-Y') }}" autocomplete="off" id="tanggal-kegiatan-harian" class="form-control form-control-lg" placeholder="Pilih tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="data-kegiatan-harian"></div>
        </div>
    </div>
</div>
<!-- End Row -->
@if ($pesan==null)
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full modal-dialog-centered">
        <div class="modal-content">
            <form method="post" id="form-kegiatan-harian" action="javascript:void" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white mt-1 mb-0"><i class="mdi mdi-calendar-month"></i> FORM KEGIATAN HARIAN</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body border border-primary border-top-0">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="input-bulan-pengerjaan" class="control-label">BULAN PENGERJAAN <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="input-bulan-pengerjaan" @if (date('d')>= 2) {{ 'disabled' }} @endif required data-placeholder="Pilih bulan pengerjaan">
                                    @if (date('d') < 2) <option value="@if (date('m') < 2){{ 12 }}@else{{ (date('m')-1)<10?'0'.(date('m')-1):(date('m')-1) }}@endif">1. {{ strtoupper(Carbon\Carbon::parse(date('Y').'-'.(date('m')==1?12:date('m')-1).'-01')->translatedFormat('F')) }}</option>
                                        <option value="{{ date('m') < 10 ? str_replace("0", "", date('m')) : date('m') }}">2. {{ strtoupper(Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('F')) }}</option>
                                        @else
                                        <option value="{{ date('m') < 10 ? str_replace("0", "", date('m')) : date('m') }}">1. {{ strtoupper(Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('F')) }}</option>
                                        @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="input-kegiatan-bulanan" class="control-label">KEGIATAN BULANAN <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="input-kegiatan-bulanan" required data-placeholder="Pilih kegiatan bulanan">
                                    <option value=""></option>
                                    @if ($skp!=null)
                                    @foreach ($skp as $k)
                                    <option value="{{ $k->id_kegiatan_bulan }}">{{ $loop->iteration }}. {{ $k->kegiatan }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="input-kegiatan-harian" class="control-label">KEGIATAN HARIAN <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="input-kegiatan-harian" required data-placeholder="Pilih kegiatan harian">
                                    <option data-satuan="Tidak ada satuan" data-waktu="0" value=""></option>
                                    @php
                                    $a = session()->get('_aktivitas');
                                    $n = 1;
                                    @endphp
                                    @for ($i = 0; $i < count($a); $i++) <option data-satuan="{{$a[$i]['satuan']}}" data-waktu="{{$a[$i]['waktu']}}" value="{{$a[$i]['id_aktivitas']}}">{{ $n++ }}. {{$a[$i]['aktivitas']}} | {{$a[$i]['satuan']}} | {{$a[$i]['waktu']}} Menit</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="input-kuantitas" class="control-label">KUANTITAS <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" value="1" autocomplete="off" required class="form-control" id="input-kuantitas" placeholder="Masukan kuantitas">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="input-satuan"> Tidak ada satuan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="input-tanggal-pengerjaan" class="control-label">TANGGAL PENGERJAAN <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div for="input-tanggal-pengerjaan" class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <input type="text" required pattern="\d{1,2}-\d{1,2}-\d{4}" value="{{ date('d-m-Y') }}" title="CONTOH FORMAT TANGGAL YANG BENAR = {{ date('d-m-Y') }}" id="input-tanggal-pengerjaan" autocomplete="off" class="form-control" placeholder="Pilih tanggal">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="input-jam-mulai" class="control-label">JAM MULAI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div for="input-jam-mulai" class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-alarm"></i></span>
                                    </div>
                                    <input id="input-jam-mulai" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="CONTOH FORMAT JAM YANG BENAR = {{ date('H:i') }}" value="07:00" required placeholder="Pilih jam mulai" autocomplete="off" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="input-jam-selesai" class="control-label">JAM SELESAI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div for="input-jam-selesai" class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-alarm"></i></span>
                                    </div>
                                    <input id="input-jam-selesai" readonly="readonly" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="CONTOH FORMAT JAM YANG BENAR = {{ date('H:i') }}" required placeholder="Pilih jam selesai" autocomplete="off" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="input-keterangan" class="control-label">KETERANGAN <span class="text-danger">*</span></label>
                                <textarea required id="input-keterangan" autocomplete="off" placeholder="Masukan keterangan" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <span class="text-danger">* WAJIB DIISI</span>
                        </div>
                        <div class="col-12" id="data-kegiatan-harian-diform">
                            <div class="custom-accordion" id="accordionbg">
                                <div class="card mb-1 shadow-none border">
                                    <a href="#" class="text-dark" data-toggle="collapse" data-target="#data-kegiatan-harian-form" aria-expanded="false" aria-controls="data-kegiatan-harian-form">
                                        <div class="card-header bg-primary" id="data-kegiatan-harian-form-sub">
                                            <h5 class="card-title text-white m-0">
                                                DAFTAR KEGIATAN PADA TANGGAL <span id="tglIni">{{ Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y') }}</span>
                                                <i class="mdi mdi-minus-circle-outline float-right accor-plus-icon"></i>
                                            </h5>
                                        </div>
                                    </a>
                                    <div id="data-kegiatan-harian-form" class="collapse show" aria-labelledby="data-kegiatan-harian-form-sub" data-parent="#accordionbg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border border-primary border-top-0">
                    <button type="submit" id="btn-form-kegiatan-harian" class="btn btn-primary btn-lg waves-effect waves-light"><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
                    <button type="button" class="btn btn-danger btn-lg waves-effect tutup" data-dismiss="modal"><i class="mdi mdi-close"></i> <span>TUTUP</span></button>
                </div>
            </form>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
@endsection
@push('javascript')
<script>
    var _token = "{{ csrf_token() }}";
    @if($pesan)
    $(function() {
        tampil($("#tanggal-kegiatan-harian").val());
    });
    @endif
    @if($pesan == null)
    var menit = 0;
    var today = new Date();
    var mulaiHari = '';
    var jmlbulanlalu = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
    if (today.getDate() == 1) {
        mulaiHari = "-" + jmlbulanlalu + "d";
    } else {
        var jml = today.getDate() - 1;
        mulaiHari = "-" + jml + "d";
    }
    $(function() {
        var tanggal = $("#tanggal-kegiatan-harian").val();
        tampil(tanggal);
        tampilDataDiForm(tanggal);
    });
    $("#input-tanggal-pengerjaan").datepicker({
        language: "id",
        format: "dd-mm-yyyy",
        autoclose: true,
        startDate: mulaiHari,
        endDate: "d",
        todayHighlight: true,
        daysOfWeekHighlighted: "0,6",
        orientation: "bottom",
    });
    $('#input-jam-mulai')
        .datetimepicker({
            format: "HH:mm",
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            }
        })
        .on("dp.change", function(event) {
            var val = $(this).val();
            if (val) {
                if (menit > 0) {
                    ubah_jam_selesai();
                } else {
                    alert_error("MAAF!!!", "Pilih kegiatan harian terlebih dahulu");
                }
            } else {
                alert_error("MAAF!!!", "Pilih jam mulai terlebih dahulu");
            }
    });
    $(document).on("change", "#input-kegiatan-harian", function() {
        if (cekKoneksiInternet()) {
            $("#input-satuan").text($(this).find(":selected").data("satuan"));
            menit = $(this).find(":selected").data("waktu");
            ubah_jam_selesai();
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });
    $(document).on("keyup", "#input-kuantitas", function() {
        if (cekKoneksiInternet()) {
            if (menit > 0) {
                ubah_jam_selesai();
            } else {
                alert_error("MAAF!!!", "Pilih kegiatan harian terlebih dahulu");
            }
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });

    function ubah_jam_selesai() {
        if (cekKoneksiInternet()) {
            var kuantitas = parseInt($("#input-kuantitas").val());
            if (kuantitas) {
                var jam = $("#input-jam-mulai").val();
                let day = moment(jam + ':00', "hh:mm:ss").add(menit * kuantitas, "minutes").toString();
                var d = new Date(day);
                var h = new Date();
                if (d.getDate() + '-' + d.getMonth() + '-' + d.getFullYear() == h.getDate() + '-' + h.getMonth() + '-' + h.getFullYear()) {
                    if (d.getHours() < 10) {
                        h = '0' + d.getHours();
                    } else {
                        h = d.getHours();
                    }
                    if (d.getMinutes() < 10) {
                        m = '0' + d.getMinutes();
                    } else {
                        m = d.getMinutes();
                    }
                    $("#input-jam-selesai").val(h + ':' + m);
                    $('#input-kuantitas').focus();
                } else {
                    $("#input-jam-selesai").val('00:00');
                    alert_error("MAAF!!!", "Jam Selesai tidak boleh melebihi waktu 23:59")
                }
            } else {
                alert_error("MAAF!!!", "Inputan kuantitas harian harus diisi dengan angka")
            }
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    }
    $(document).on("click", "#btn-form-kegiatan-harian", function() {
        if (cekKoneksiInternet()) {
            var bulan = $('#input-kegiatan-bulanan').val();
            var hari = $('#input-kegiatan-harian').val();
            var kuantitas = $('#input-kuantitas').val();
            var tanggal = $('#input-tanggal-pengerjaan').val();
            var jamMulai = $('#input-jam-mulai').val();
            var jamSelesai = $('#input-jam-selesai').val();
            var keterangan = $('#input-keterangan').val();
            if (menit > 0 && bulan && hari && kuantitas && tanggal && jamMulai && jamSelesai && jamSelesai != '00:00' && jamSelesai > jamMulai && keterangan) {
                loading();
                $.when(
                    $.ajax({
                        url: "{{ '/pegawai/simpan-kegiatan-harian' }}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            _token: _token,
                            menit: menit,
                            bulan: bulan,
                            hari: hari,
                            kuantitas: kuantitas,
                            tanggal: tanggal,
                            jamMulai: jamMulai,
                            jamSelesai: jamSelesai,
                            keterangan: keterangan,
                        },
                        success: function(a) {
                            if (a.status) {
                                $('#modal').modal('hide');
                                alert_sukses("SELAMAT!!!", "Data Kegiatan Harian berhasil disimpan");
                                tampil(tanggal);
                                tampilDataDiForm(tanggal);
                                $("#input-kegiatan-bulanan").val('').trigger('change');
                                $("#input-kegiatan-harian").val('').trigger('change');
                                $("#input-kuantitas").val('1');
                                $('#input-jam-mulai').val('07:00');
                                $('#input-jam-selesai').val('');
                                $("#input-keterangan").val('');
                            } else {
                                alert_error("MAAF!!!", a.message);
                            }
                        },
                        error: function(a, t, e) {
                            alert_error("MAAF!!!", "Data kegiatan harian gagal disimpan");
                        },
                    })
                ).done(function() {
                    unLoading();
                });
            } else {
                alert_error("MAAF!!!", "Mohon isi semua form Kegiatan Harian dengan benar");
            }
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });

    function tampilDataDiForm(t) {
        if (cekKoneksiInternet()) {
            loading();
            $.when(
                $.ajax({
                    url: "{{ '/pegawai/data-form-kegiatan-harian' }}",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        _token: _token,
                        tanggal: t,
                    },
                    success: function(a) {
                        if (a !== null) {
                            $('#data-kegiatan-harian-diform').html(a);
                        } else {
                            alert_error("MAAF!!!", "Data kegiatan harian gagal ditampilkan");
                        }
                    },
                    error: function(a, t, e) {
                        alert_error("MAAF!!!", "Data kegiatan harian gagal ditampilkan");
                    },
                })
            ).done(function() {
                unLoading();
            });
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    }
    $(document).on("change", "#input-tanggal-pengerjaan", function() {
        if (cekKoneksiInternet()) {
            var val = $(this).val();
            if (val) {
                tampilDataDiForm(val)
            } else {
                alert_error("MAAF!!!", "Pilih tanggal pengerjaan terlebih dahulu");
            }
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });
    @endif
    $("#tanggal-kegiatan-harian").datepicker({
        language: "id",
        endDate: "d",
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        daysOfWeekHighlighted: "0,6",
        orientation: "bottom",
    });
    $(document).on("change", "#tanggal-kegiatan-harian", function() {
        if (cekKoneksiInternet()) {
            var val = $(this).val();
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
                    url: "{{ '/pegawai/data-kegiatan-harian' }}",
                    type: "POST",
                    dataType: "HTML",
                    data: {
                        _token: _token,
                        tanggal: t,
                    },
                    success: function(a) {
                        if (a !== null) {
                            $('#data-kegiatan-harian').html(a);
                        } else {
                            alert_error("MAAF!!!", "Data kegiatan harian gagal ditampilkan");
                        }
                    },
                    error: function(a, t, e) {
                        alert_error("MAAF!!!", "Data kegiatan harian gagal ditampilkan");
                    },
                })
            ).done(function() {
                unLoading();
            });
        } else {
            alert_error("MAAF!!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    }
    $(document).on("click", ".hapus-data", function() {
        if (cekKoneksiInternet()) {
            var id = $(this).data("id");
            if (id) {
                Swal.fire({
                    title: "Apakah anda serius!!!",
                    text: "Ingin menghapus data ini",
                    icon: "question",
                    allowOutsideClick: !1,
                    showCancelButton: !0,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: '<i class="mdi mdi-check-bold"></i> Hapus data ini !',
                    cancelButtonText: '<i class="mdi mdi-close"></i> Tidak jadi !',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ '/pegawai/hapus-kegiatan-harian' }}",
                            type: "POST",
                            data: {
                                _token: _token,
                                id: id,
                            },
                            dataType: "JSON",
                            success: function(a) {
                                if (a.status) {
                                    Swal.fire({
                                        title: "SELAMAT",
                                        text: "Data berhasil dihapus",
                                        icon: "success",
                                        allowOutsideClick: !1,
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: '<i class="mdi mdi-check-bold"></i> OK',
                                    }).then(function() {
                                        tampil($('#tanggal-kegiatan-harian').val());
                                    });
                                } else {
                                    alert_error('MAAF!!!', 'Data kegiatan harian gagal dihapus')
                                }
                            },
                            error: function(a, t, e) {
                                alert_error("MAAF!!!", "Data kegiatan harian gagal dihapus");
                            },
                        });
                    }
                })
            }
        } else {
            alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });
</script>
@endpush