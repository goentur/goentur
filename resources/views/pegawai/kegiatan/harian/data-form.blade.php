<div class="custom-accordion" id="accordionbg">
    <div class="card mb-1 shadow-none border">
        <a href="#" class="text-dark" data-toggle="collapse" data-target="#data-kegiatan-harian-form" aria-expanded="false" aria-controls="data-kegiatan-harian-form">
            <div class="card-header bg-primary" id="data-kegiatan-harian-form-sub">
                <h5 class="card-title text-white m-0">
                    DAFTAR KEGIATAN PADA TANGGAL <span id="tglIni">{{ Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span>
                    <i class="mdi mdi-minus-circle-outline float-right accor-plus-icon"></i>
                </h5>
            </div>
        </a>
        <div id="data-kegiatan-harian-form" class="collapse show" aria-labelledby="data-kegiatan-harian-form-sub" data-parent="#accordionbg">
            <div class="card-body border border-primary border-top-0">
                <table class="table-sm table-bordered" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                    <thead>
                        <tr>
                            <th width="1px">MULAI</th>
                            <th width="1px">SELESAI</th>
                            <th>KEGIATAN</th>
                            <th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $k)
                        <tr>
                            <td class="text-center">{{ $k->jam_mulai }}</td>
                            <td class="text-center">{{ $k->jam_selesai }}</td>
                            <td>{{ $k->aktivitas }}</td>
                            <td>{{ $k->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>