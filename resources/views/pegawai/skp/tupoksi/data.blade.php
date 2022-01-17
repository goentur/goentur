<table id="datatables" class="table table-sm table-striped table-hover table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
     <thead>
          <tr>
               <th width="1%"></th>
               <th>RENCANA KINERJA</th>
               <th width="1%">Aksi</th>
          </tr>
     </thead>
     <tbody>
          @foreach ($data as $k)
          <tr>
               <td class="text-center">{{$loop->iteration}}.</td>
               <td>{{ $k->tupoksi }}</td>
               <td class="text-center">
                    <a href="javascript:void(0);" class="hapus-data btn btn-sm btn-icon waves-effect waves-light btn-danger" data-id="{{ encrypt($k->id_tupoksi) }}"><i class="mdi mdi-close"></i></a>
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