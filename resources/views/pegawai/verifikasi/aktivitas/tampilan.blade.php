@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
     <div class="col-12">
          <div class="page-title-box">
               <h4 class="page-title">AKTIVITAS SKP</h4>
               <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                         <li class="breadcrumb-item">{{ config('app.name') }}</li>
                         <li class="breadcrumb-item">AKTIVITAS</li>
                         <li class="breadcrumb-item active">AKTIVITAS SKP</li>
                    </ol>
               </div>
               <div class="clearfix"></div>
          </div>
          <div class="card">
               <div class="card-header bg-primary text-center">
                    <h3 class="text-white"><i class="mdi mdi-account-card-details"></i> DATA PNS</h3>
               </div>
               <div class="card-body border border-primary border-top-0">
                    <div class="row">
                         <div class="col-md-12 col-sm-12 col-12" id="data-pns">
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<!-- End Row -->
<div id="full-width-modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-full modal-dialog-centered">
          <div class="modal-content">
               <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white mt-1 mb-0" id="judul-modal"></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
               <div id="dasdas"></div>
               </div>
               <div class="modal-body border border-primary border-top-0" id="data-aktivitas">
               </div>
          </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@push('javascript')
<script>
     var _token = "{{ csrf_token() }}";
     $(function() {
          tampil();
     });
     function tampil() {
          if (cekKoneksiInternet()) {
               loading();
               $.when(
                    $.ajax({
                         url: "{{ '/pegawai/verifikasi-aktivitas' }}",
                         type: "POST",
                         dataType: "HTML",
                         data: {
                              _token: _token,
                              type : 'a',
                         },
                         success: function(a) {
                              $('#data-pns').html(a);
                         },
                         error: function(a, t, e) {
                              alert_error("MAAF!!!", "Data pns gagal ditampilkan");
                         },
                    })
               ).done(function() {
                    unLoading();
               });
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     }
     $(document).on("click", ".lihat-aktivitas", function() {
          if (cekKoneksiInternet()) {
               $('#judul-modal').html('<i class="mdi mdi-file-word-outline"></i> FORM AKTIVITAS DATA SKP');
               $('#data-aktivitas').html("");
               var id = $(this).data("id");
               if (id) {
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/lihat-data-aktivitas' }}",
                              type: "POST",
                              data: {
                                   _token: _token,
                                   id: id,
                              },
                              dataType: "HTML",
                              success: function(a) {
                                   if (a!==null) {
                                        $('#data-aktivitas').html(a);
                                   } else {
                                        alert_error('MAAF!!!', 'Data aktivitas gagal ditampilkan')
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Data aktivitas gagal ditampilkan");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               }else{
                    alert_error("MAAF!!!", "Data aktivitas gagal ditampilkan");
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
          }
     });
</script>
@endpush