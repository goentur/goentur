@extends('template')

@section('content')
<!-- start page title -->
<div class="row">
     <div class="col-12">
          <div class="page-title-box">
               <h4 class="page-title">DATA BREAKDOWN SKP</h4>
               <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                         <li class="breadcrumb-item">{{ config('app.name') }}</li>
                         <li class="breadcrumb-item">BREAKDOWN SKP</li>
                         <li class="breadcrumb-item active">DATA BREAKDOWN SKP</li>
                    </ol>
               </div>
               <div class="clearfix"></div>
          </div>
          <div class="card">
               <div class="card-header bg-primary">
                    <h3 class="text-white text-center"><i class="mdi mdi-clipboard-list"></i> DATA SKP PADA PERIODE TERAKHIR</h3>
                    <h6 class="text-white text-center">{{ strtoupper(Carbon\Carbon::parse($data->tanggal_awal)->translatedFormat('d F Y')) }} - {{ strtoupper(Carbon\Carbon::parse($data->tanggal_akhir)->translatedFormat('d F Y')) }}</h6>
               </div>
               <div class="card-body border border-primary border-top-0">
                    <form method="post" id="form-breakdown-skp" action="javascript:void(0)" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-lg-8 col-12">
                                   <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> PERHATIAN!</h3>
                                        <ul class="list-unstyled mb-0">
                                             <li>
                                                  <i class="text-danger mdi mdi-hand-pointing-right"></i> Jika waktu pengerjaan 12 bulan, maka otomatis terbreakdown setelah disetujui oleh atasan.
                                             </li>
                                             <li>
                                                  <i class="text-danger mdi mdi-hand-pointing-right"></i> Jika waktu pengerjaan <b><u class="text-danger">KURANG</u></b> dari 12 bulan, maka harus membreakdown secara manual pada kolom <b>AKSI</b>.
                                             </li>
                                             <li>
                                                  <i class="text-danger mdi mdi-hand-pointing-right"></i> Jika <b><u class="text-danger">TIDAK ADA TOMBOL BREAKDOWN</u></b> pada kolom <b>AKSI</b> pastikan anda sudah mengirimkan data skp dan sudah <b>DITERIMA</b> oleh atasan.
                                             </li>
                                             <br>
                                        </ul>
                                   </div>
                              </div>
                              <div class="col-lg-4 col-12">
                                   <div class="alert alert-info alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h3 class="text-primary"><i class="mdi mdi-information"></i> INFORMASI!</h3>
                                        <ul class="list-unstyled mb-0">
                                             <li>
                                                  <i class="text-primary mdi mdi-hand-pointing-right"></i> <i class="text-primary mdi mdi-progress-clock" data-toggle="tooltip" data-placement="right" title="menunggu"></i> Menunggu
                                             </li>
                                             <li>
                                                  <i class="text-primary mdi mdi-hand-pointing-right"></i> <i class="text-success mdi mdi-check-bold" data-toggle="tooltip" data-placement="right" title="diterima"></i> Diterima
                                             </li>
                                             <li>
                                                  <i class="text-primary mdi mdi-hand-pointing-right"></i> <i class="text-danger mdi mdi-close-circle" data-toggle="tooltip" data-placement="right" title="ditolak"></i> Ditolak
                                             </li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                         <table id="datatables" class="table table-sm table-striped table-hover table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                              <thead>
                                   <tr>
                                        <th width="1%"></th>
                                        <th>RENCANA</th>
                                        <th width="1%">AK</th>
                                        <th>OUTPUT</th>
                                        <th width="1%">MUTU</th>
                                        <th>WAKTU</th>
                                        <th class="text-right">BIAYA</th>
                                        <th width="1%">AKSI</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @foreach ($skp as $k)
                                   <tr>
                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                        <td data-toggle="tooltip" data-placement="right" title="{{ $k->kegiatan }}">
                                             {{strlen($k->kegiatan) <=75 ? $k->kegiatan : substr($k->kegiatan, 0, 75).'...'}}
                                             @if ($k->verifikasi_atasan == 'm')
                                             <i class="text-primary mdi mdi-progress-clock" data-toggle="tooltip" data-placement="right" title="menunggu"></i>
                                             @elseif ($k->verifikasi_atasan == 't')
                                             <i class="text-success mdi mdi-check-bold" data-toggle="tooltip" data-placement="right" title="diterima"></i>
                                             @elseif ($k->verifikasi_atasan == 'x')
                                             <i class="text-danger mdi mdi-close-circle" data-toggle="tooltip" data-placement="right" title="ditolak"></i>
                                             @endif    
                                        </td>
                                        <td class="text-center">{{ $k->angka_kredit }}</td>
                                        <td>{{ $k->output }} {{ $k->satuan }}</td>
                                        <td class="text-center">{{ $k->mutu }}</td>
                                        <td>{{ $k->waktu }} Bulan</td>
                                        <td class="text-right">@rupiah($k->biaya)</td>
                                        <td class="text-center">
                                             @if ($k->status_skp=='s' && $k->verifikasi_atasan == 't' && $k->waktu < 12)
                                                  <a href="javascript:void(0)" class="btn btn-sm btn-primary breakdown-skp" data-id="{{ encrypt($k->id_skp) }}" data-waktu="{{ $k->waktu }}"><i class="mdi mdi-calendar-month"></i></a>
                                             @endif
                                        </td>
                                   </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </form>
               </div>
          </div>
     </div>
</div>
<!-- End Row -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog modal-full modal-dialog-centered">
          <div class="modal-content">
               <form method="post" id="form-breakdown-skp" action="javascript:void(0)" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                         <h5 class="modal-title text-white mt-1 mb-0"><i class="mdi mdi-clipboard-list"></i> BREAKDOWN SKP</h5>
                         <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body border border-primary border-top-0" id="data-breakdown-skp">
                         
                    </div>
                    <div class="modal-footer border border-primary border-top-0">
                         <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light" id="btn-simpan-breakdown-skp" disabled><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
                         <button type="button" class="btn btn-danger btn-lg waves-effect tutup" data-dismiss="modal"><i class="mdi mdi-close"></i> <span>TUTUP</span></button>
                    </div>
               </form>
          </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('javascript')
<script>
     $(function() {
          $("[data-toggle='tooltip']").tooltip();
     });
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
     @if ($skp_diterima->count() == $skp->count() && $skp_dikirim->count() == $skp->count())
     var id = null;
     var waktu = null;
     var _token = "{{ csrf_token() }}";
     $(document).on("click", ".breakdown-skp", function() {
          if (cekKoneksiInternet()) {
               id = $(this).data("id");
               waktu = $(this).data("waktu");
               if(id && waktu){
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/tampil-breakdown-skp' }}",
                              type: "POST",
                              dataType: "HTML",
                              data: {
                                   _token: _token,
                                   id: id,
                              },
                              success: function(a) {
                                   if(a != null){
                                        $("#modal").modal({
                                             show: true,
                                             backdrop: "static",
                                             keyboard: false,
                                        });
                                        $('#btn-simpan-breakdown-skp').attr('disabled', 'disabled');
                                        $('#data-breakdown-skp').html(a)
                                   }else{
                                        alert_error("MAAF!!!", "Data Breakdown SKP gagal ditampilkan");
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Data Breakdown SKP gagal ditampilkan");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               } else {
                    alert_error("MAAF !!!", "Data Breakdown SKP gagal ditampilkan");
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!");
          }
     });
     $(document).on("click", "#btn-simpan-breakdown-skp", function() {
          if (cekKoneksiInternet()) {
               var dataBulan = [];
               $('input[type="checkbox"][name="bulan[]"]:checked').each(function() {
                    dataBulan.push($(this).val());
               });
               if (id && waktu == dataBulan.length) {
                    loading();
                    $.when(
                         $.ajax({
                              url: "{{ '/pegawai/simpan-breakdown-skp' }}",
                              type: "POST",
                              dataType: "JSON",
                              data: {
                                   _token: _token,
                                   id: id,
                                   data: dataBulan,
                              },
                              success: function(a) {
                                   if (a.status) {
                                        $('#modal').modal('hide');
                                        alert_sukses("SELAMAT!!!", "Data Breakdown SKP berhasil disimpan");
                                   } else {
                                        alert_error("MAAF!!!", "Data Breakdown SKP gagal disimpan");
                                   }
                              },
                              error: function(a, t, e) {
                                   alert_error("MAAF!!!", "Data Breakdown SKP gagal disimpan");
                              },
                         })
                    ).done(function() {
                         unLoading();
                    });
               } else {
                    alert_error("MAAF!!!", "Mohon pilih Bulan Pengerjaan");
               }
          } else {
               alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!");
          }
     });
     $(document).on("click", ".breakdown-bulan", function() {
          var cek = $('input[type="checkbox"][name="bulan[]"]:checked').length >= waktu;
          $('input[type="checkbox"][name="bulan[]"]').not(":checked").attr("disabled", cek);
          if(cek){
               $('#btn-simpan-breakdown-skp').removeAttr('disabled', 'disabled');
          }else{
               $('#btn-simpan-breakdown-skp').attr('disabled', 'disabled');
          }
     })
     @endif
</script>
@endpush