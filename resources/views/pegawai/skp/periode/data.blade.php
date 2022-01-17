<table id="datatables" class="table table-sm table-striped table-hover table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
     <thead>
          <tr>
               <th width="1%"></th>
               <th>TANGGAL AWAL</th>
               <th>TANGGAL AKHIR</th>
               <th width="1%">Aksi</th>
          </tr>
     </thead>
     <tbody>
          @foreach ($data as $k)
          <tr>
               <td class="text-center">{{$loop->iteration}}.</td>
               <td>{{ strtoupper(Carbon\Carbon::parse($k->tanggal_awal)->translatedFormat('d F Y')) }}</td>
               <td>{{ strtoupper(Carbon\Carbon::parse($k->tanggal_akhir)->translatedFormat('d F Y')) }}</td>
               <td class="text-center">
                    <a href="javascript:void(0);" class="hapus-data btn btn-sm btn-icon waves-effect waves-light btn-danger" data-id="{{ encrypt($k->id_periode_skp) }}"><i class="mdi mdi-close"></i></a>
               </td>
          </tr>
          @endforeach
     </tbody>
</table>
<script>
     $("#datatables").DataTable({
        'language': {
            'url': '//cdn.datatables.net/plug-ins/1.11.2/i18n/id.json'
        }
     });
</script>