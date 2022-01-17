<div class="card-header bg-primary">
    <h3 class="text-white text-center"><i class="mdi mdi-calendar-month"></i> DATA KEGIATAN HARIAN</h3>
    <h6 class="text-white text-center">{{ strtoupper(Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y')) }}</h6>
</div>
<div class="card-body border border-primary border-top-0 col-12">
    <table id="datatables" class="table table-sm table-striped table-hover table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
        <thead>
            <tr>
                <th width="1%">MULAI</th>
                <th width="1%">SELESAI</th>
                <th>RENCANA</th>
                <th>KEGIATAN</th>
                <th width="1%">KUANTITAS</th>
                <th width="1%">POIN</th>
                <th>KETERANGAN</th>
                <th width="1%">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @php
                $m = 0;
                $t = 0;
            @endphp
            @foreach ($data as $k)
            @php
                $m += $k->poin;
                if ($k->status_aktivitas == 't'){
                    $t += $k->poin;
                }
            @endphp
            <tr>
                <td class="text-center">{{ $k->jam_mulai }}</td>
                <td class="text-center">{{ $k->jam_selesai }}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->kegiatan }}">
                    {{strlen($k->kegiatan) <=30 ? $k->kegiatan : substr($k->kegiatan, 0, 30).'...'}}
                    @if ($k->status_aktivitas == 'm')
                    <i class="text-primary mdi mdi-progress-clock" data-toggle="tooltip" data-placement="right" title="menunggu"></i>
                    @elseif ($k->status_aktivitas == 't')
                    <i class="text-success mdi mdi-check-bold" data-toggle="tooltip" data-placement="right" title="diterima"></i>
                    @elseif ($k->status_aktivitas == 'x')
                    <i class="text-danger mdi mdi-close-circle" data-toggle="tooltip" data-placement="right" title="ditolak"></i>
                    @endif    
                </td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->aktivitas }}">{{strlen($k->aktivitas) <=30 ? $k->aktivitas : substr($k->aktivitas, 0, 30).'...'}}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->kuantitas }} {{$k->satuan}}" align="center">{{ strlen($k->kuantitas.' '.$k->satuan) <=7 ? $k->kuantitas.' '.$k->satuan : substr($k->kuantitas.' '.$k->satuan, 0, 7).'...'}}</td>
                <td class="text-center">{{ $k->poin }}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->keterangan }}">{{strlen($k->keterangan) <=30 ? $k->keterangan : substr($k->keterangan, 0, 30).'...'}}</td>
                <td class="text-center">
                    @if ($k->status_aktivitas == 'm' || $k->status_aktivitas == 'x')
                    <a href="javascript:void(0);" class="hapus-data btn btn-sm btn-icon waves-effect waves-light btn-danger" data-id="{{ encrypt($k->id_kegiatan_hari) }}"><i class="mdi mdi-close"></i></a>
                    @elseif (session()->get('_level_dinas')=='1')
                    <a href="javascript:void(0);" class="hapus-data btn btn-sm btn-icon waves-effect waves-light btn-danger" data-id="{{ encrypt($k->id_kegiatan_hari) }}"><i class="mdi mdi-close"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="border border-primary">
    <div class="row">
        <div class="col-lg-6 col-12">
            <table class="table-sm">
                <tr>
                    <td><b>TOTAL POIN YANG TERKUMPUL</b></td>
                    <td>:</td>
                    <td>{{ $m }}</td>
                </tr>
                <tr>
                    <td><b>TOTAL POIN YANG DIPERHITUNGKAN</b></td>
                    <td>:</td>
                    <td>{{ $t>10?10:$t }}</td>
                </tr>
            </table>
        </div>
        <div class="col-lg-6 col-12">
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
</script>