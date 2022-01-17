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
<form method="post" id="form-data-skp" action="javascript:void(0)" enctype="multipart/form-data">
    <div class="text-center mb-3">
        <h3><i class="mdi mdi-table-large"></i> DATA SKP PERIODE</h3>
        <h5>{{ Carbon\Carbon::parse($periode_skp->tanggal_awal)->translatedFormat('d F Y') }} S.D {{ Carbon\Carbon::parse($periode_skp->tanggal_akhir)->translatedFormat('d F Y') }}</h5>
    </div>
    <hr class="bg-primary">
    <table id="detail-data-skp" class="table table-sm table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; max-width: 100%;">
        <thead>
            <tr>
                <th width="1px"></th>
                <th>KEGIATAN</th>
                <th width="1px">AK</th>
                <th>OUTPUT</th>
                <th width="1px">MUTU</th>
                <th>WAKTU</th>
                <th class="text-right">BIAYA</th>
                <th class="text-center">AKSI</th>
                <th>ALASAN</th>
            </tr>
        </thead>
        <tbody>
            @php
                $t=0;
            @endphp
            @foreach ($skp as $n =>$k)
            <tr>
                <td class="text-center">{{$loop->iteration}}.</td>
                <td>
                    @if ($k->verifikasi_atasan == 'm')
                    {{ $k->kegiatan }} <i class="text-primary mdi mdi-progress-clock" data-toggle="tooltip" data-placement="right" title="menunggu"></i>
                    @elseif ($k->verifikasi_atasan == 't')
                    @php
                        $t +=1;
                    @endphp
                    {{ $k->kegiatan }} <i class="text-success mdi mdi-check-bold" data-toggle="tooltip" data-placement="right" title="diterima"></i>
                    @elseif ($k->verifikasi_atasan == 'x')
                    {{ $k->kegiatan }} <i class="text-danger mdi mdi-close-circle" data-toggle="tooltip" data-placement="right" title="ditolak"></i>
                    @endif
                </td>
                <td class="text-center">{{$k->angka_kredit}}</td>
                <td>{{$k->output}} {{ $k->satuan }}</td>
                <td class="text-center">{{$k->mutu}}</td>
                <td>{{$k->waktu}} Bulan</td>
                <td class="text-right">@rupiah($k->biaya)</td>
                <td align="center">
                    <div class="radio radio-success form-check-inline">
                        <input type="radio" required class="radio-terima" data-waktu="{{$k->waktu}}" data-id="{{ $k->id_skp }}" id="rt-{{ $k->id_skp }}" value="t" {{ $k->verifikasi_atasan == 't' ? 'checked disabled ' : '' }}name="{{ $k->id_skp }}">
                        <label for="rt-{{ $k->id_skp }}"> TERIMA</label>
                    </div>
                    <div class="radio radio-danger form-check-inline">
                        <input type="radio" class="radio-tolak" data-waktu="{{$k->waktu}}" data-id="{{ $k->id_skp }}" id="rx-{{ $k->id_skp }}" value="x" {{ $k->verifikasi_atasan == 'x' ? 'checked ' : '' }}{{ $k->verifikasi_atasan == 't' ? 'disabled ' : '' }}name="{{ $k->id_skp }}">
                        <label for="rx-{{ $k->id_skp }}"> TOLAK</label>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" data-id="{{ $k->id_skp }}" {{ $k->verifikasi_atasan == 'x' ? 'required value=' . $k->alasan_penolakan . ' ' : 'disabled ' }}id="alasan-{{ $k->id_skp }}" placeholder="Masukan Alasan Penolakan">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="bg-primary">
    <div class="col-12 text-right">
        <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"{{ ++$n==$t?' disabled':'' }}><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
        <button type="button" class="btn btn-danger btn-lg waves-effect tutup" data-dismiss="modal"><i class="mdi mdi-close"></i> <span>TUTUP</span></button>
    </div>
</form>
<script>
    $('#detail-data-skp').DataTable({
        'language': {
            'url': '//cdn.datatables.net/plug-ins/1.11.2/i18n/id.json'
        },
        'bPaginate': false,
        'bLengthChange': false,
        'bFilter': true,
        'bInfo': false,
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
                var id = $(this).data('id');
                var val = $(this).val();
                var alasan = $("#alasan-"+id).val()==''?'-':$("#alasan-"+id).val();
                var waktu = $(this).data('waktu');
                isi.push([id,val,alasan,waktu]);
            });
            if (isi.length > 0 && isi.length == {{ $n }}) {
                loading();
                $.when(
                    $.ajax({
                        url: "{{ '/pegawai/proses-data-skp' }}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            _token: _token,
                            id: '{{ encrypt($periode_skp->id_periode_skp) }}',
                            data : isi,
                        },
                        success: function(a) {
                            if (a.status) {
                                $("#full-width-modal").modal("hide");
                                $('#data-skp').html("");
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
                alert_error("MAAF!!!", "Mohon pilih semua SKP");
            }
        }else{
                alert_error("MAAF !!!", "KONEKSI INTERNET ANDA TERPUTUS!")
        }
    });
</script>