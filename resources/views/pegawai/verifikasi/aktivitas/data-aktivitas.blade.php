<form method="post" id="form-data-skp" action="javascript:void(0)" enctype="multipart/form-data">
    <div class="text-center mb-3">
        <h3><i class="mdi mdi-calendar-month-outline"></i> DATA KEGIATAN HARIAN</h3>
        <h5>{{ Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }} - {{ Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y') }}</h5>
    </div>
    <hr class="bg-primary">
    <table id="detail-data-aktivitas" class="table table-sm table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; max-width: 100%;">
        <thead>
            <tr>
                <th width="1px"></th>
                <th>RENCANA KINERJA</th>
                <th>KEGIATAN</th>
                <th>KETERANGAN</th>
                <th>TANGGAL</th>
                <th width="1px">MULAI</th>
                <th width="1px">SELESAI</th>
                <th width="1px">POIN</th>
                <th width="1px">KUANTITAS</th>
                <th class="text-center">AKSI</th>
                <th>ALASAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $n => $k)
            <tr>
                <td class="text-center">{{$loop->iteration}}.</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->kegiatan }}">{{strlen($k->kegiatan) <=30 ? $k->kegiatan : substr($k->kegiatan, 0, 30).'...'}}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->aktivitas }}">{{strlen($k->aktivitas) <=30 ? $k->aktivitas : substr($k->aktivitas, 0, 30).'...'}}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->keterangan }}">{{strlen($k->keterangan) <=30 ? $k->keterangan : substr($k->keterangan, 0, 30).'...'}}</td>
                <td>{{ Carbon\Carbon::parse($k->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</td>
                <td align="center">{{$k->jam_mulai}}</td>
                <td align="center">{{$k->jam_selesai}}</td>
                <td align="center">{{$k->poin}}</td>
                <td data-toggle="tooltip" data-placement="right" title="{{ $k->kuantitas }} {{$k->satuan}}" align="center">{{ strlen($k->kuantitas.' '.$k->satuan) <=7 ? $k->kuantitas.' '.$k->satuan : substr($k->kuantitas.' '.$k->satuan, 0, 7).'...'}}</td>
                <td align="center">
                    <div class="radio radio-success form-check-inline">
                        <input type="radio" required class="radio-terima" data-id="{{ $k->id_kegiatan_hari }}" id="rt-{{ $k->id_kegiatan_hari }}" value="t" name="{{ $k->id_kegiatan_hari }}">
                        <label for="rt-{{ $k->id_kegiatan_hari }}"> TERIMA</label>
                    </div>
                    <div class="radio radio-danger form-check-inline">
                        <input type="radio" class="radio-tolak" data-id="{{ $k->id_kegiatan_hari }}" id="rx-{{ $k->id_kegiatan_hari }}" value="x" name="{{ $k->id_kegiatan_hari }}">
                        <label for="rx-{{ $k->id_kegiatan_hari }}"> TOLAK</label>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" disabled data-id="{{ $k->id_kegiatan_hari }}" id="alasan-{{ $k->id_kegiatan_hari }}" placeholder="Masukan alasan penolakan">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="bg-primary">
    <div class="col-12 text-right">
        <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
        <button type="button" class="btn btn-danger btn-lg waves-effect tutup" data-dismiss="modal"><i class="mdi mdi-close"></i> <span>TUTUP</span></button>
    </div>
</form>
<script>
     $(function() {
          $("[data-toggle='tooltip']").tooltip();
     });
    $('#detail-data-aktivitas').DataTable({
        'language': {
            'url': '//cdn.datatables.net/plug-ins/1.11.2/i18n/id.json'
        },
        'bPaginate': false,
        'bLengthChange': false,
        'bFilter': true,
        'bInfo': true,
        'bAutoWidth': false,
        "ordering": false,
    });
    $('.radio-terima').on("click", function() {
        var id = $(this).data('id');
        if (id) {
            $('#alasan-' + id).attr('disabled', 'disabled');
            $('#alasan-' + id).removeAttr('required', 'required');
            $('#alasan-' + id).val(null);
        } else {
            alert_error("MAAF !!!!", "Mohon pilih salah satu radio");
        }
    });
    $('.radio-tolak').on("click", function() {
        var id = $(this).data('id');
        if (id) {
            $('#alasan-' + id).removeAttr('disabled', 'disabled');
            $('#alasan-' + id).attr('required', 'required');
            $('#alasan-' + id).focus();
        } else {
            alert_error("MAAF !!!!", "Mohon pilih salah satu radio");
        }
    });

    $("#form-data-skp").submit(function() {
        if (cekKoneksiInternet()) {
            var isi = [];
            $('input[type="radio"]:checked').each(function() {
                var id = $(this).attr('name');
                var val = $(this).val();
                var alasan = $("#alasan-"+id).val()==''?'-':$("#alasan-"+id).val();
                isi.push([id,val,alasan]);
            });
            if (isi.length > 0 && isi.length == {{ ++$n }}) {
                loading();
                $.when(
                    $.ajax({
                        url: "{{ '/pegawai/proses-data-aktivitas' }}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            _token: _token,
                            data : isi,
                        },
                        success: function(a) {
                            if (a.status) {
                                $("#full-width-modal").modal("hide");
                                $('#data-aktivitas').html("");
                                alert_sukses("SELAMAT!!!","Data berhasil disimpan");
                            } else {
                                alert_error("MAAF!!!", "Varifikasi gagal disimpan");
                            }
                        },
                        error: function(a, t, e) {
                            alert_error("MAAF!!!", "Varifikasi gagal disimpan");
                        },
                    })
                ).done(function() {
                    unLoading();
                });
            } else {
                alert_error("MAAF!!!", "Mohon pilih semua data kegiatan");
            }
        }else{
            alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });
</script>