@extends('template')

@section('content')<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">DATA RIWAYAT JABATAN</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item">{{ config('app.name') }}</li>
                    <li class="breadcrumb-item">JABATAN</li>
                    <li class="breadcrumb-item active">DATA RIWAYAT JABATAN</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <section id="cd-timeline" class="cd-container" dir="ltr">
            @foreach ($jabatan as $k)
            @php                
            $unor_pns = '';
            $jabatan_pns = '';
            if ($k->unit_organisasi !== '-') {
                $unor_pns = $k->unit_organisasi;
            }
            if ($k->jabatan_tambahan == 'Kepala Sekolah' || $k->jabatan_tambahan == 'Kepala Puskesmas') {
                $jabatan_pns = $k->detail_jabatan . ' ' . $unor_pns . ' (' . $k->jabatan_tambahan . ')';
            } else {
                $jabatan_pns = $k->detail_jabatan . ' ' . $unor_pns;
            }
            @endphp
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-primary">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <!-- cd-timeline-img -->
                    <div class="cd-timeline-content">
                        <h3>DATA JABATAN :</h3>
                        <br>
                        <table class="table-sm">
                            <tr>
                                <td style="width: 1px" class="top"><b>JABATAN</b></td>
                                <td style="width: 1px" class="top"><b>:</b></td>
                                <td>{{ ucwords($jabatan_pns) }}</td>
                            </tr>
                            <tr>
                                <td class="top"><b>OPD</b></td>
                                <td class="top"><b>:</b></td>
                                <td>{{ $k->sub_opd == '-' ? strtoupper($k->opd) : strtoupper($k->sub_opd . ' - ' . $k->opd) }}</td>
                            </tr>
                        </table>
                        <hr class="bg-primary">
                        <h3>LIST DATA SKP :</h3>
                        <br>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>TANGGAL AWAL</th>
                                    <th>TANGGAL AKHIR</th>
                                    <th width="1%">CETAK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Jabatan::_ambilBeberapaRecord('periode_skp',['id_periode_skp','tanggal_awal','tanggal_akhir'],['id_pegawai_jabatan' => $k->id_pegawai_jabatan]) as $item)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($item->tanggal_awal)->translatedFormat('d F Y') }} </td>
                                    <td>{{ Carbon\Carbon::parse($item->tanggal_akhir)->translatedFormat('d F Y') }}</td>
                                    <td align="center">
                                        <form action="{{ '/pegawai/cetak-skp' }}" target="_blank" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_periode_skp" value="{{ encrypt($item->id_periode_skp) }}">
                                            <button type="submit" class="btn btn-sm btn-icon waves-effect waves-light btn-primary"><i class="mdi mdi-printer"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <span class="cd-date">{{ $k->tanggal_awal =='0000-00-00' ? 'Sekarang' : Carbon\Carbon::parse($k->tanggal_awal)->translatedFormat('d F Y') }} - {{ $k->tanggal_akhir=='0000-00-00' ? 'Sekarang' : Carbon\Carbon::parse($k->tanggal_akhir)->translatedFormat('d F Y') }}</span>
                    </div>
                    <!-- cd-timeline-content -->
                </div>
                <!-- cd-timeline-block -->
            @endforeach
        </section>
        <!-- cd-timeline -->
    </div>
</div>
<!-- End Row -->
@endsection

@push('javascript')
@endpush
