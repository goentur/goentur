@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
     <div class="col-12">
          <div class="page-title-box">
               <h4 class="page-title">DATA RENCANA KINERJA</h4>
               <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                         <li class="breadcrumb-item">{{ config('app.name') }}</li>
                         <li class="breadcrumb-item">RENCANA KINERJA</li>
                         <li class="breadcrumb-item active">DATA RENCANA KINERJA</li>
                    </ol>
               </div>
               <div class="clearfix"></div>
          </div>
          <div class="card">
               <div class="card-header border border-primary">
                    <button class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal" data-backdrop="static" data-keyboard="false"> <i class="fa fa-plus"></i> <span>TAMBAH DATA RENCANA KINERJA</span> </button>
               </div>
               <div class="card-body border border-primary border-top-0">
                    <div class="row">
                         <div class="col-12">
                              <div class="alert alert-info alert-dismissible fade show">
                                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                   </button>
                                   <h3 class="text-primary"><i class="mdi mdi-information"></i> INFORMASI!</h3>
                                   <ul class="list-unstyled mb-0">
                                        <li>
                                             <i class="text-primary mdi mdi-hand-pointing-right"></i> Apabila data rencana <b><u>SUDAH TIDAK</u></b> digunakan, kami sarankan untuk menghapus data tersebut.
                                        </li>
                                   </ul>
                              </div>
                         </div>
                         <div class="col-12" id="data-tupoksi">
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
               <form method="post" id="form-tupoksi" action="javascript:void(0)" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                         <h5 class="modal-title text-white mt-1 mb-0"><i class="mdi mdi-clipboard-list-outline"></i> FORM RENCANA KINERJA</h5>
                         <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body border border-primary border-top-0">
                         <div class="row">
                              <div class="col-12">
                                   <div class="form-group">
                                        <label for="tupoksi" class="control-label">RENCANA KINERJA <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" autocomplete="off" id="tupoksi" placeholder="Masukan rencana kinerja" name="tupoksi" required>
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
                         url: "{{ '/pegawai/data-tupoksi' }}",
                         type: "POST",
                         dataType: "HTML",
                         data: {
                              _token: _token,
                         },
                         success: function(a) {
                              $('#data-tupoksi').html(a);
                         },
                         error: function(a, t, e) {
                              alert_error("MAAF!!!", "Data tupoksi gagal ditampilkan");
                         },
                    })
               ).done(function() {
                    unLoading();
               });
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     }
     $("#form-tupoksi").submit(function() {
          if (cekKoneksiInternet()) {
               var tupoksi = $('#tupoksi').val();
               if (tupoksi) {
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/simpan-tupoksi' }}",
                              type: "POST",
                              dataType: "JSON",
                              data: {
                                   _token: _token,
                                   tupoksi: tupoksi,
                              },
                              success: function(a) {
                                   if (a.status) {
                                        tampil();
                                        $('#modal').modal('hide');
                                        alert_sukses("SELAMAT!!!", "Data Tupoksi berhasil disimpan");
                                        $('#tupoksi').val('');
                                   } else {
                                        alert_error("MAAF!!!", "Data tupoksi gagal disimpan");
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Data tupoksi gagal disimpan");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               } else {
                    alert_error("MAAF!!!", "Mohon isi semua form tupoksi ");
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
                                   url: "{{ '/pegawai/hapus-tupoksi' }}",
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
                                             alert_error('MAAF!!!', 'Data tupoksi gagal dihapus')
                                        }
                                   },
                                   error: function(a, t, e) {
                                        alert_error("MAAF!!!", "Data tupoksi gagal dihapus");
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