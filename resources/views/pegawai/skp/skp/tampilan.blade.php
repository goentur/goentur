@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
     <div class="col-12">
          <div class="page-title-box">
               <h4 class="page-title">DATA SKP</h4>
               <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                         <li class="breadcrumb-item">{{ config('app.name') }}</li>
                         <li class="breadcrumb-item">SKP</li>
                         <li class="breadcrumb-item active">DATA SKP</li>
                    </ol>
               </div>
               <div class="clearfix"></div>
          </div>
          <div class="card">
               <div class="card-header bg-primary">
                    <h3 class="text-white text-center"><i class="mdi mdi-clipboard-plus"></i> DATA SKP PADA PERIODE TERAKHIR</h3>
                    <h6 class="text-white text-center">{{ strtoupper(Carbon\Carbon::parse($data->tanggal_awal)->translatedFormat('d F Y')) }} - {{ strtoupper(Carbon\Carbon::parse($data->tanggal_akhir)->translatedFormat('d F Y')) }}</h6>
               </div>
               <div class="card-body border border-primary border-top-0" id="data-skp"></div>
          </div>
     </div>
</div>
<!-- End Row -->
@if ($skp_blm_dikirim->count() == $skp->count())
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-full modal-dialog-centered">
          <div class="modal-content">
               <form method="post" id="form-skp" action="javascript:void(0)" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                         <h5 class="modal-title text-white mt-1 mb-0"><i class="mdi mdi-clipboard-plus"></i> FORM SKP</h5>
                         <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body border border-primary border-top-0">
                         <div class="row">
                              @if (session()->get('_level_dinas')!='1')
                              <div class="col-md-12">
                                   <div class="form-group">
                                        <label for="id_tupoksi_atasan" class="control-label">KEGIATAN ATASAN <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="id_tupoksi_atasan" id="id_tupoksi_atasan" required="required" data-placeholder="Pilih kegiatan atasan">
                                             <option value=""></option>
                                        </select>
                                   </div>
                              </div>
                              @else
                              <input type="hidden" name="id_tupoksi_atasan" id="id_tupoksi_atasan" value="-" required="required">
                              @endif
                              <div class="col-md-12">
                                   <div class="form-group">
                                        <label for="id_tupoksi" class="control-label">DETAIL SUMBER RENCANA KINERJA PEGAWAI <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="id_tupoksi" name="id_tupoksi" required="required" data-placeholder="Pilih detail sumber rencana kinerja pegawai">
                                             <option data-isi="" value=""></option>
                                             @foreach ($tupoksi as $i)
                                             <option data-isi="{{ $i->tupoksi }}" value="{{ $i->id_tupoksi }}">{{$loop->iteration}}. {{ $i->tupoksi }}</option>
                                             @endforeach
                                        </select>
                                   </div>
                              </div>
                              <div class="col-md-12">
                                   <div class="form-group">
                                        <label for="kegiatan" class="control-label">RENCANA SASARAN KINERJA PEGAWAI <span class="text-danger">*</span></label>
                                        <textarea autocomplete="off" id="kegiatan" @if (session()->get('_level_dinas')!=4 && session()->get('_level_dinas')!=5) readonly="readonly" @endif placeholder="Masukan rencana sasaran kinerja pegawai" name="kegiatan" class="form-control form-control-lg"></textarea>
                                   </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                                   <div class="form-group">
                                        <label for="angka_kredit" class="control-label">ANGKA KREDIT <span class="text-danger">*</span></label>
                                        <input type="number" autocomplete="off" step=".01" id="angka_kredit" @if (session()->get('_level_dinas')!=4 && session()->get('_level_dinas')!=5) readonly="readonly" @endif class="form-control" required="required" name="angka_kredit" min="0" value="0" placeholder="Masukan angka kredit">
                                   </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                                   <div class="form-group">
                                        <label for="output" class="control-label">OUTPUT/KUANTITAS <span class="text-danger">*</span></label>
                                        <input type="number" autocomplete="off" step=".01" id="output" class="form-control" required="required" name="output" min="1" value="1" placeholder="Masukan output/kuantitas">
                                   </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                                   <div class="form-group">
                                        <label for="id_satuan" class="control-label">SATUAN <span class="text-danger">*</span></label>
                                        <select name="id_satuan" class="form-control select2 form-control-lg satuan" required="required" id="id_satuan" data-placeholder="Pilih satuan">
                                             <option value=""></option>
                                             @foreach ($satuan as $i)
                                             <option value="{{ $i->id_satuan }}">{{$loop->iteration}}. {{ $i->satuan }}</option>
                                             @endforeach
                                        </select>
                                   </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                                   <div class="form-group">
                                        <label for="mutu" class="control-label">MUTU/KUALITAS <span class="text-danger">*</span></label>
                                        <input type="number" autocomplete="off" id="mutu" class="form-control form-control-lg" required="required" name="mutu" value="100" readonly="readonly" placeholder="Masukan mutu/kualitas">
                                   </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                                   <div class="form-group">
                                        <label for="waktu" class="control-label">WAKTU <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                             <input type="number" autocomplete="off" id="waktu" class="form-control form-control-lg" required="required" name="waktu" min="1" max="12" value="12" placeholder="Masukan waktu">
                                             <div class="input-group-append">
                                                  <span class="input-group-text">BULAN</span>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                                   <div class="form-group">
                                        <label for="biaya" class="control-label">BIAYA <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                             <div class="input-group-prepend">
                                                  <span class="input-group-text">Rp.</span>
                                             </div>
                                             <input type="text" autocomplete="off" class="form-control form-control-lg rupiah" id="biaya" required="required" name="biaya" value="0" placeholder="Masukan biaya">
                                        </div>
                                   </div>
                              </div>
                              <div class="col-12">
                                   <span class="text-danger">* WAJIB DIISI</span>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer border border-primary border-top-0">
                         <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
                         <button type="button" class="btn btn-danger btn-lg waves-effect tutup" data-dismiss="modal"><i class="mdi mdi-close"></i> <span>TUTUP</span></button>
                    </div>
               </form>
          </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif
@endsection
@push('javascript')
<script>
     $("#datatables").DataTable({
          'bPaginate': false,
          'bLengthChange': false,
          'bFilter': true,
          'bInfo': true,
          'bAutoWidth': false,
          'ordering': false,
          'language': {
               'url': '//cdn.datatables.net/plug-ins/1.11.2/i18n/id.json'
          }
     });
     var _token = "{{ csrf_token() }}";
     var _id_periode_skp = "{{ encrypt($data->id_periode_skp) }}";
     $(document).ready(function() {
          tampil();
          @if($skp_blm_dikirim->count() == $skp->count() && session()->get('_level_dinas') != '1')
          if (cekKoneksiInternet()) {
               loading();
               $.when(
                    $.ajax({
                         url: "{{ '/pegawai/data-kegiatan-atasan' }}",
                         type: "POST",
                         dataType: "HTML",
                         data: {
                              _token: _token,
                         },
                         success: function(a) {
                              $('#id_tupoksi_atasan').html(a);
                         },
                         error: function(a, t, e) {
                              alert_error("MAAF!!!", "Data Kegiatan atasan gagal ditampilkan");
                         },
                    })
               ).done(function() {
                    unLoading();
               });
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
          @endif
     });

     function tampil() {
          if (cekKoneksiInternet()) {
               loading();
               $.when(
                    $.ajax({
                         url: "{{ '/pegawai/data-skp' }}",
                         type: "POST",
                         dataType: "HTML",
                         data: {
                              _token: _token,
                              id_periode_skp: _id_periode_skp,
                         },
                         success: function(a) {
                              $('#data-skp').html(a)
                         },
                         error: function(a, t, e) {
                              alert_error("MAAF!!!", "Data SKP gagal ditampilkan");
                         },
                    })
               ).done(function() {
                    unLoading();
               });
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     }
     @if($skp_blm_dikirim->count() == $skp->count())
     $("#form-skp").submit(function() {
          if (cekKoneksiInternet()) {
               var id_tupoksi_atasan = $('#id_tupoksi_atasan').val();
               var id_tupoksi = $('#id_tupoksi').val();
               var a = $("option:selected", this).attr("data-isi");
               var kegiatan = $('#kegiatan').val();
               var angka_kredit = parseInt($('#angka_kredit').val());
               var output = $('#output').val();
               var id_satuan = $('#id_satuan').val();
               var mutu = parseInt($('#mutu').val());
               var waktu = parseInt($('#waktu').val());
               var biaya = parseInt($('#biaya').val().replaceAll('.', ''));
               if (id_tupoksi_atasan && id_tupoksi && kegiatan && angka_kredit >= 0 && output && id_satuan && mutu == 1000 && waktu > 0 || waktu <= 12 && biaya >= 0) {
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/simpan-skp' }}",
                              type: "POST",
                              dataType: "JSON",
                              data: {
                                   _token: _token,
                                   id_periode_skp: _id_periode_skp,
                                   id_tupoksi_atasan: id_tupoksi_atasan,
                                   id_tupoksi: id_tupoksi,
                                   kegiatan: kegiatan,
                                   angka_kredit: angka_kredit,
                                   output: output,
                                   id_satuan: id_satuan,
                                   mutu: mutu,
                                   waktu: waktu,
                                   biaya: biaya,
                              },
                              success: function(a) {
                                   if (a.status) {
                                        tampil();
                                        $('#modal').modal('hide');
                                        alert_sukses("SELAMAT!!!", "Data SKP berhasil disimpan");
                                        $("#kegiatan").val('');
                                        $("#angka_kredit").val('0');
                                        $("#output").val('1');
                                        $("#id_satuan").val('').trigger('change');
                                        $("#mutu").val('100');
                                        $("#biaya").val('0');
                                   } else {
                                        alert_error("MAAF!!!", "Data SKP gagal disimpan");
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Data SKP gagal disimpan");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               } else {
                    alert_error("MAAF!!!", "Mohon isi semua form SKP ");
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     });
     $(document).on('click', '#button-kirim-skp', function() {
          if (cekKoneksiInternet()) {
               if ($("#persetujuan").is(":checked")) {
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/kirim-skp' }}",
                              type: "POST",
                              dataType: "JSON",
                              data: {
                                   _token: _token,
                                   id_periode_skp: _id_periode_skp,
                              },
                              success: function(a) {
                                   if (a.status) {
                                        tampil();
                                        @if(session()->get('_level_dinas') == '1')
                                        alert_sukses("SELAMAT!!!", "Data SKP berhasil divalidasi");
                                        @else
                                        alert_sukses("SELAMAT!!!", "Data SKP berhasil dikirim keatasan");
                                        @endif
                                   } else {
                                        alert_error("MAAF!!!", "Kirim SKP gagal");
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Kirim SKP gagal");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               } else {
                    alert_error("MAAF!!!", "Mohon centang terlebih dahulu");
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     });
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
                                   url: "{{ '/pegawai/hapus-skp' }}",
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
                                                  tampil();
                                             });
                                        } else {
                                             alert_error('MAAF!!!', 'Data SKP gagal dihapus')
                                        }
                                   },
                                   error: function(a, t, e) {
                                        alert_error("MAAF!!!", "Data SKP gagal dihapus");
                                   },
                              });
                         }
                    })
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     });
     $(document).on("change", "#id_tupoksi", function() {
          if (cekKoneksiInternet()) {
               var a = $("option:selected", this).attr("data-isi");
               if (a) {
                    $('#kegiatan').val(a);
               } else {
                    alert_error("MAAF !!!", "Pilih Detail Sumber Sasaran Kinerja Pegawai terlebih dahulu!")
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     });
     @endif
</script>
@endpush