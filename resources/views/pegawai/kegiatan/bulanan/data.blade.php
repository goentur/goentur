<div class="card-header bg-primary">
    <h3 class="text-white text-center"><i class="mdi mdi-calendar-month"></i> DATA KEGIATAN BULANAN</h3>
    <h6 class="text-white text-center">{{ strtoupper(Carbon\Carbon::parse($bulan)->translatedFormat('F Y')) }}</h6>
</div>
<div class="card-body border border-primary border-top-0 col-12">
    <table id="datatables" class="table table-sm table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; max-width: 100%;">
        <thead>
            <tr>
                <th width="1px"></th>
                <th>TANGGAL</th>
                <th>RENCANA</th>
                <th>KEGIATAN</th>
                <th>KETERANGAN</th>
                <th width="1px">MULAI</th>
                <th width="1px">SELESAI</th>
                <th width="1px">POIN</th>
                <th width="1px">KUANTITAS</th>
            </tr>
        </thead>
        <tbody>
            @php
                $poin = 100;
                $m = 0;
                $t = 0;
            @endphp
            @foreach ($data as $n => $k)
            @php
                $m += $k->poin;
                if ($k->status_aktivitas == 't'){
                    $t += $k->poin;
                }
            @endphp
            <tr>
                <td class="text-center">{{$loop->iteration}}.</td>
                <td>{{ Carbon\Carbon::parse($k->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</td>
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
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->keterangan }}">{{strlen($k->keterangan) <=30 ? $k->keterangan : substr($k->keterangan, 0, 30).'...'}}</td>
                <td align="center">{{$k->jam_mulai}}</td>
                <td align="center">{{$k->jam_selesai}}</td>
                <td align="center">{{$k->poin}}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->kuantitas }} {{$k->satuan}}" align="center">{{ strlen($k->kuantitas.' '.$k->satuan) <=7 ? $k->kuantitas.' '.$k->satuan : substr($k->kuantitas.' '.$k->satuan, 0, 7).'...'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="border border-primary">
    <div class="row">
        <div class="col-lg-6 col-12">
            <table class="table-sm">
                <tr>
                    <td><b>TOTAL POIN MAKSIMAL</b></td>
                    <td>:</td>
                    <td>{{ $poin }}</td>
                </tr>
                <tr>
                    <td><b>TOTAL POIN YANG TERKUMPUL</b></td>
                    <td>:</td>
                    <td>{{ $m }}</td>
                </tr>
                <tr>
                    <td><b>TOTAL POIN YANG DIPERHITUNGKAN</b></td>
                    <td>:</td>
                    <td>{{ $t>$poin?$poin:$t }}</td>
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
        'ordering': false,
        'language': {
            'url': '//cdn.datatables.net/plug-ins/1.11.2/i18n/id.json'
        }
    });
</script>