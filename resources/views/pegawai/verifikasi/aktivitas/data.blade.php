<table id="datatables" class="table table-sm table-striped table-hover table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
    <thead>
        <tr>
            <th width="1px">AKSI</th>
            <th width="1px">NIP</th>
            <th>NAMA</th>
            <th>JABATAN</th>
            <th>OPD</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($_id_jabatan_dinas as $k)
        <tr>
            <td class="text-center">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect waves-light lihat-aktivitas" data-toggle="modal" data-target="#full-width-modal" title="data aktivitas" data-id="{{ encrypt($k->id_pegawai) }}"> <i class="mdi mdi-clipboard-list-outline"></i></a>
                </div>
                </td>
            <td>{{ $k->nip }}</td>
            <td>{{ $k->gelar_depan }} {{ $k->nama_pegawai }} {{ $k->gelar_belakang }}</td>
            <td>
                {{ $k->detail_jabatan }}
                {{ $k->unit_organisasi == '-' ? '' : $k->unit_organisasi}}
                @php
                if ($k->jabatan_tambahan == 'Kepala Sekolah' || $k->jabatan_tambahan == 'Kepala Puskesmas') {
                    echo ' - ' . $k->jabatan_tambahan;
                }
                @endphp
            </td>
            <td>
                {{ $k->sub_opd == '-' ? $sub = $k->opd : $sub = $k->sub_opd . ' - ' . $k->opd }}
            </td>
        </tr>
        @endforeach
        @if ($_id_jabatan_tbh!=='kosong')            
        @foreach ($_id_jabatan_tbh as $k)
        <tr>
            <td class="text-center">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect waves-light lihat-aktivitas" data-toggle="modal" data-target="#full-width-modal" title="data aktivitas" data-id="{{ encrypt($k->id_pegawai) }}"> <i class="mdi mdi-clipboard-list-outline"></i></a>
                </div>
                </td>
            <td>{{ $k->nip }}</td>
            <td>{{ $k->gelar_depan }} {{ $k->nama_pegawai }} {{ $k->gelar_belakang }}</td>
            <td>
                {{ $k->detail_jabatan }}
                {{ $k->unit_organisasi == '-' ? '' : $k->unit_organisasi}}
                @php
                if ($k->jabatan_tambahan == 'Kepala Sekolah' || $k->jabatan_tambahan == 'Kepala Puskesmas') {
                    echo ' - ' . $k->jabatan_tambahan;
                }
                @endphp
            </td>
            <td>
                {{ $k->sub_opd == '-' ? $sub = $k->opd : $sub = $k->sub_opd . ' - ' . $k->opd }}
            </td>
        </tr>
        @endforeach
        @endif
        @if ($_id_jabatan_lain!=='kosong')            
        @foreach ($_id_jabatan_lain as $k)
        <tr>
            <td class="text-center">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect waves-light lihat-aktivitas" data-toggle="modal" data-target="#full-width-modal" title="data aktivitas" data-id="{{ encrypt($k->id_pegawai) }}"> <i class="mdi mdi-clipboard-list-outline"></i></a>
                </div>
                </td>
            <td>{{ $k->nip }}</td>
            <td>{{ $k->gelar_depan }} {{ $k->nama_pegawai }} {{ $k->gelar_belakang }}</td>
            <td>
                {{ $k->detail_jabatan }}
                {{ $k->unit_organisasi == '-' ? '' : $k->unit_organisasi}}
                @php
                if ($k->jabatan_tambahan == 'Kepala Sekolah' || $k->jabatan_tambahan == 'Kepala Puskesmas') {
                    echo ' - ' . $k->jabatan_tambahan;
                }
                @endphp
            </td>
            <td>
                {{ $k->sub_opd == '-' ? $sub = $k->opd : $sub = $k->sub_opd . ' - ' . $k->opd }}
            </td>
        </tr>
        @endforeach
        @endif
        @if ($_id_jabatan_lain_tbh!=='kosong')            
        @foreach ($_id_jabatan_lain_tbh as $k)
        <tr>
            <td class="text-center">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect waves-light lihat-skp" data-toggle="modal" data-target="#full-width-modal" data-id="{{ encrypt($k->id_pegawai_jabatan) }}"><i class="mdi mdi-file-word-outline"></i></a>
            </td>
            <td>{{ $k->nip }}</td>
            <td>{{ $k->gelar_depan }} {{ $k->nama_pegawai }} {{ $k->gelar_belakang }}</td>
            <td>
                {{ $k->detail_jabatan }}
                {{ $k->unit_organisasi == '-' ? '' : $k->unit_organisasi}}
                @php
                if ($k->jabatan_tambahan == 'Kepala Sekolah' || $k->jabatan_tambahan == 'Kepala Puskesmas') {
                    echo ' - ' . $k->jabatan_tambahan;
                }
                @endphp
            </td>
            <td>
                {{ $k->sub_opd == '-' ? $sub = $k->opd : $sub = $k->sub_opd . ' - ' . $k->opd }}
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<script>
    $(function() {
        $("[data-toggle='tooltip']").tooltip();
    });
    $("#datatables").DataTable({
        'language': {
            'url': '//cdn.datatables.net/plug-ins/1.11.2/i18n/id.json'
        }
    });
</script>