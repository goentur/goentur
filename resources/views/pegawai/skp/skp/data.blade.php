@if ($skp_blm_dikirim->count() == $skp->count())
<form class="row mb-3" id="form-kirim-skp" action="javascript:void(0)" method="post" enctype="multipart/form-data">
     <div class="col-12">
          <div class="alert alert-danger alert-dismissible fade show">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
               </button>
               <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> PERHATIAN!</h3>
               <ul class="list-unstyled mb-0">
                    @if (session()->get('_level_dinas') == '1')
                    <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Pastikan data skp anda sudah <b><u>BENAR</u></b> sebelum divalidasi!</li>
                    <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Jika belum benar anda bisa <b><u>MENGHAPUS</u></b> data tersebut sebelum divalidasi!</li>
                    <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Sebelum klik tombol <b><u>VALIDASI DATA SKP</u></b> pastikan <b><u>CENTANG</u></b> terlebih dahulu untuk menyetujui data skp anda!</li>
                    <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Jika <b><u>SUDAH</u></b> divalidasi maka data <b><u>TIDAK</u></b> bisa dihapus!</li>
                    @else
                    <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Pastikan data skp anda sudah <b><u>BENAR</u></b> sebelum dikirimkan!</li>
                    <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Sebelum klik tombol <b><u>KIRIMKAN DATA SKP</u></b> pastikan <b><u>CENTANG</u></b> terlebih dahulu untuk menyetujui atas pengirimkan data skp ke atasan!</li>
                    @endif
               </ul>
          </div>
     </div>
     <div class="row col-12">
          <div class="col-12 col-lg-5">
               <button type="button" class="btn btn-lg btn-block btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modal" data-backdrop="static" data-keyboard="false"> <i class="fa fa-plus"></i> <span>TAMBAH DATA SKP</span> </button>
          </div>
          <div class="col-lg-2 col-12">
               <div class="checkbox checkbox-primary">
                    <input id="persetujuan" @if($skp->count()==0) disabled @endif name="persetujuan" type="checkbox" required>
                    <label for="persetujuan">
                         <b><span class="text-danger">*</span> CENTANG DISINI.</b>
                    </label>
               </div>
               <span class="text-danger">* WAJIB DIISI!</span>
          </div>
          <div class="col-lg-5 col-12">
               @if (session()->get('_level_dinas') == '1')
               <button type="submit" id="button-kirim-skp" disabled class="btn btn-danger btn-block btn-lg waves-effect waves-light"> <i class="mdi mdi-lock-outline"></i> VALIDASI DATA SKP</button>
               @else
               <button type="submit" id="button-kirim-skp" disabled class="btn btn-danger btn-block btn-lg waves-effect waves-light"> <i class="mdi mdi-truck-fast"></i> KIRIMKAN DATA SKP</button>
               @endif
          </div>
     </div>
</form>
<hr class="border-primary">
@elseif($skp_diterima->count() == $skp->count() && $skp_dikirim->count() == $skp->count())
<form class="row mb-3" action="{{ '/pegawai/cetak-skp' }}" target="_blank" method="post" enctype="multipart/form-data">
     <div class="col-12">
          @csrf
          <input type="hidden" name="id_periode_skp" value="{{ encrypt($id_periode_skp) }}">
          <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i class="fa fa-print"></i> CETAK SKP</button>
     </div>
</form>
<hr class="border-primary">
@endif
<div class="row">
     <div class="col-12">
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
     <div class="col-md-12 col-sm-12 col-12">
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
                              @if ($k->status_skp=='b' && $k->verifikasi_atasan != 't')
                              <a href="javascript:void(0);" class="hapus-data btn btn-sm btn-icon waves-effect waves-light btn-danger" data-id="{{ encrypt($k->id_skp) }}"><i class="mdi mdi-close"></i></a>
                              @elseif ($k->status_skp=='b' && session()->get('_level_dinas') == '1')
                              <a href="javascript:void(0);" class="hapus-data btn btn-sm btn-icon waves-effect waves-light btn-danger" data-id="{{ encrypt($k->id_skp) }}"><i class="mdi mdi-close"></i></a>
                              @endif
                         </td>
                    </tr>
                    @endforeach
               </tbody>
          </table>
     </div>
</div>
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
     $("#persetujuan").change(function() {
          if(this.checked) {
               $('#button-kirim-skp').removeAttr('disabled', 'disabled');
          }else{
               $('#button-kirim-skp').attr('disabled', 'disabled');
          }
     });
</script>