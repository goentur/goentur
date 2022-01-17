@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
     <div class="col-12">
          <div class="page-title-box">
               <h4 class="page-title">DATA PERIODE SKP</h4>
               <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                         <li class="breadcrumb-item">{{ config('app.name') }}</li>
                         <li class="breadcrumb-item">PERIODE SKP</li>
                         <li class="breadcrumb-item active">DATA PERIODE SKP</li>
                    </ol>
               </div>
               <div class="clearfix"></div>
          </div>
          <div class="card">
               <div class="card-header border border-primary">
                    <button class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal" data-backdrop="static" data-keyboard="false"> <i class="fa fa-plus"></i> <span>TAMBAH DATA PERIODE SKP</span> </button>
               </div>
               <div class="card-body border border-primary border-top-0">
                    <div class="row">
                         <div class="col-12">
                              <div class="alert alert-danger alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> PERHATIAN!</h3>
                                  <ul class="list-unstyled mb-0">
                                      <li><i class="text-danger mdi mdi-hand-pointing-right"></i> <b><u>DILARANG KERAS</u></b> menghapus data perode SKP.</li>
                                  </ul>
                              </div>
                         </div>
                         <div class="col-md-12 col-sm-12 col-12" id="data-periode-skp">
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<!-- End Row -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
               <form method="post" id="form-periode-skp" action="javascript:void(0)" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                         <h5 class="modal-title text-white mt-1 mb-0"><i class="mdi mdi-calendar-account"></i> FORM PERIODE SKP</h5>
                         <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body border border-primary border-top-0">
                         <div class="row">
                              <div class="col-12 col-sm-6">
                                   <div class="form-group">
                                        <label for="tanggal_awal" class="control-label">PILIH TANGGAL AWAL <span class="text-danger">*</span></label>
                                        <input type="text" autocomplete="off" value="02-01-{{ date('Y') }}" class="form-control form-control-lg tanggal-umum" id="tanggal_awal" placeholder="Pilih tanggal awal" name="tanggal_awal" required>
                                   </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                   <div class="form-group">
                                        <label for="tanggal_akhir" class="control-label">PILIH TANGGAL AKHIR <span class="text-danger">*</span></label>
                                        <input type="text" autocomplete="off" value="31-12-{{ date('Y') }}" class="form-control form-control-lg tanggal-umum" id="tanggal_akhir" placeholder="Pilih tanggal akhir" name="tanggal_akhir" required>
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
@endsection

@push('javascript')
<script>
     var _token = "{{ csrf_token() }}";
     $(function() {
          tampil()
     });
     function tampil() {
          if (cekKoneksiInternet()) {
               loading();
               $.when(
                    $.ajax({
                         url: "{{ '/pegawai/data-periode-skp' }}",
                         type: "POST",
                         dataType: "HTML",
                         data: {
                              _token: _token,
                         },
                         success: function(a) {
                              $('#data-periode-skp').html(a);
                         },
                         error: function(a, t, e) {
                              alert_error("MAAF!!!", "Data periode SKP gagal ditampilkan");
                         },
                    })
               ).done(function() {
                    unLoading();
               });
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     }
     $("#form-periode-skp").submit(function() {
          if (cekKoneksiInternet()) {
               var tanggal_awal = $('#tanggal_awal').val();
               var tanggal_akhir = $('#tanggal_akhir').val();
               if (tanggal_awal && tanggal_akhir) {
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/simpan-periode-skp' }}",
                              type: "POST",
                              dataType: "JSON",
                              data: {
                                   _token: _token,
                                   tanggal_awal: tanggal_awal,
                                   tanggal_akhir: tanggal_akhir,
                              },
                              success: function(a) {
                                   if (a.status) {
                                        tampil();
                                        $('#modal').modal('hide');
                                        alert_sukses("SELAMAT!!!", "Data periode SKP berhasil disimpan");
                                        $('#tanggal_awal').val('');
                                        $('#tanggal_akhir').val('');
                                   } else {
                                        alert_error("MAAF!!!", "Data periode SKP gagal disimpan");
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Data periode SKP gagal disimpan");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               } else {
                    alert_error("MAAF!!!", "Mohon isi semua form periode SKP ");
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
                                   url: "{{ '/pegawai/hapus-periode-skp' }}",
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
                                             alert_error('MAAF!!!', 'Data periode SKP gagal dihapus')
                                        }
                                   },
                                   error: function(a, t, e) {
                                        alert_error("MAAF!!!", "Data periode SKP gagal dihapus");
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