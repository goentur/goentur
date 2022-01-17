<div class="row">
     <div class="col-md-6 col-sm-6 col-12">
          <h5 class="text-primary"><i class="mdi mdi-clipboard-plus"></i> DATA SKP</h5>
          <hr class="border-primary">
          <table class="table table-sm table-striped table-hover table-bordered">
               <tr>
                    <td width="25%"><b>KEGIATAN</b></td>
                    <td width="1%"><b>:</b></td>
                    <td>{{ $skp->kegiatan }}</td>
               </tr>
               <tr>
                    <td><b>ANGKA KREDIT</b></td>
                    <td><b>:</b></td>
                    <td>{{ $skp->angka_kredit }}</td>
               </tr>
               <tr>
                    <td><b>OUTPUT</b></td>
                    <td><b>:</b></td>
                    <td>{{ $skp->output }} {{ $skp->satuan }}</td>
               </tr>
               <tr>
                    <td><b>MUTU</b></td>
                    <td><b>:</b></td>
                    <td>{{ $skp->mutu }}</td>
               </tr>
               <tr>
                    <td><b>WAKTU</b></td>
                    <td><b>:</b></td>
                    <td>{{ $skp->waktu }} Bulan</td>
               </tr>
               <tr>
                    <td><b>BIAYA</b></td>
                    <td><b>:</b></td>
                    <td>@rupiah($skp->biaya)</td>
               </tr>
          </table>
     </div>
     <div class="col-md-6 col-sm-6 col-12">
          <h5 class="text-primary"><i class="mdi mdi-clipboard-list"></i> FORM BREAKDOWN SKP</h5>
          <hr class="border-primary">
          <div class="col-12">
               <div class="alert alert-danger alert-dismissible fade show">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
                   <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> PERHATIAN!</h3>
                   <ul class="list-unstyled mb-0">
                        <li><i class="text-danger mdi mdi-hand-pointing-right"></i> Jika sudah memilih jangan lupa klik tombol simpan.</li>
                   </ul>
               </div>
               <div class="row mt-3">
               @for ($i = 1; $i <= 12; $i++)
               <div class="col-lg-3 col-6">
                    <div class="checkbox checkbox-primary">
                         @if ($skp_breakdown->count() > 1)
                              @php
                              $p = \App\Models\Skp::_ambilSatuRecord('kegiatan_bulan',['id_kegiatan_bulan'],['id_skp' => $skp->id_skp, 'bulan_pelaksanaan' => $i]);
                              @endphp
                              <input id="{{ $i }}" value="{{ $i }}" @if ($p !== null) checked @else disabled @endif class="breakdown-bulan" name="bulan[]" type="checkbox">
                         @else
                              <input id="{{ $i }}" value="{{ $i }}" class="breakdown-bulan" name="bulan[]" type="checkbox">
                         @endif
                         <label for="{{ $i }}">
                              {{ strtoupper(Carbon\Carbon::parse('01-'.$i.'-'.date('Y'))->translatedFormat('F')) }}
                         </label>
                    </div>
               </div>
               @endfor
          </div>
     </div>
</div>