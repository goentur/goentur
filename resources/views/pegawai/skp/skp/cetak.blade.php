<!DOCTYPE html>
<html>

<head>
    <title>SASARAN KINERJA PEGAWAI NEGERI SIPIL</title>
    <style type="text/css">
        @media print {
            @page {
                margin: 10mm 5mm 5mm 5mm;
                size: landscape;
            }

            table tr td {
                font-size: 10pt;
                font-family: Arial, Helvetica, sans-serif;
            }

            .table {
                margin-top: 0;
                border-collapse: collapse;
            }

            .table tr {
                page-break-inside: avoid;
            }

            .table tr td.table-td {
                font-size: 10pt;
                color: #000;
                border: 2px solid #000 !important;
            }
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td>
                    <div style="text-align: center; font-weight: bold;">SASARAN KINERJA</div>
                    <div style="text-align: center; font-weight: bold;">PEGAWAI NEGERI SIPIL</div>
                    <table width="100%" class="table">
                        <tr>
                            <td class="table-td" colspan="2" style="width: 50%;">&nbsp;I. PEJABATAN PENILAI</td>
                            <td colspan="5" class="table-td" style="width: 50%;">&nbsp;II. PEGAWAI NEGERI SIPIL YANG DINILAI</td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td class="table-td" colspan="2">
                                <table width="100%">
                                    <tr style="vertical-align: top;">
                                        <td width="10%">Nama</td>
                                        <td width="1px">:</td>
                                        <td></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>NIP</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>Pengkat/Gol.Ruang</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>Jabatan</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>Unit Kerja</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td colspan="5" class="table-td">
                                <table width="100%">
                                    <tr style="vertical-align: top;">
                                        <td width="10%">Nama</td>
                                        <td width="1px">:</td>
                                        <td>{{ session()->get('_nama_pegawai') }}</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>NIP</td>
                                        <td>:</td>
                                        <td>{{ session()->get('_nip') }}</td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>Pengkat/Gol.Ruang</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>Jabatan</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr style="vertical-align: top;">
                                        <td>Unit Kerja</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="table-td" style="vertical-align: middle;">NO</td>
                            <td rowspan="2" class="table-td" style="width:50%;vertical-align: middle;" align="center">III. KEGIATAN TUGAS JABATAN</td>
                            <td rowspan="2" class="table-td" style="vertical-align: middle;text-align: center;">AK</td>
                            <td colspan="4" class="table-td" align="center">TARGET</td>
                        </tr>
                        <tr>
                            <td class="table-td" align="center" style="width: 12.25%;">KUANT/OUTPUT</td>
                            <td class="table-td" align="center" style="width: 12.25%;">KUALITAS/MUTU</td>
                            <td class="table-td" align="center" style="width: 12.25%;">WAKTU</td>
                            <td class="table-td" align="center" style="width: 12.25%;">BIAYA</td>
                        </tr>
                         @foreach ($skp as $k)
                         <tr>
                              <td class="table-td" style="vertical-align: middle; text-align: center;">{{ $loop->iteration }}</td>
                              <td class="table-td" style="width:48%; vertical-align: middle; text-align: justify;">{{ $k->kegiatan }}</td>
                              <td class="table-td" style="vertical-align: middle; text-align: center;">{{ $k->angka_kredit }}</td>
                              <td class="table-td" style="vertical-align: middle; text-align: center;">{{ $k->output }} {{ $k->satuan }}</td>
                              <td class="table-td" style="vertical-align: middle; text-align: center;">{{ $k->mutu }}</td>
                              <td class="table-td" style="vertical-align: middle; text-align: center;">{{ $k->waktu }} Bulan</td>
                              <td class="table-td" style="vertical-align: middle; text-align: center;">
                                @if ($k->biaya==0)
                                    -
                                @else
                                    @rupiah($k->biaya)
                                @endif
                            </td>
                         </tr>
                         @endforeach
                    </table>
                </td>
            </tr>
            <tr style="page-break-inside: avoid;">
                <td>
                    <table width="100%" style="text-align: center;">
                        <tr>
                            <td width="50%"></td>
                            <td>Pekalongan,</td>
                        </tr>
                        <tr>
                            <td>Pejabat Penilai</td>
                            <td>Pegawai Negeri Sipil Yang Dinilai</td>
                        </tr>
                        <tr>
                            <td height="75px"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><u></u></td>
                            <td><u>{{ session()->get('_nama_pegawai') }}</u></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ session()->get('_nip') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        // window.print();
        // window.onafterprint = function() {
        //     window.close();
        // }
    </script>
</body>

</html>