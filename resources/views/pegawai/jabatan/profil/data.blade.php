@extends('template')

@section('content')
<div class="wraper">
        <div class="card mt-3">
            <div class="card-header card-border bg-img text-center">
                <div class="profile-info-name mt-5">
                    <img src="@if (session()->get('_jenis_kelamin')=='p'){{ asset('images/p.png') }}@elseif(session()->get('_jenis_kelamin')=='l') {{ asset('images/l.png') }}@else{{ asset('images/logo.png') }}@endif" class="avatar-xl rounded-circle img-thumbnail"  alt="foto profil">
                    <h5 class="text-white">{{ session()->get('_nama_pegawai') }}</h5>
                    <h6 class="text-white">{{ session()->get('_nip') }}</h6>
                </div>
            </div>
            <div class="card-body border border-primary border-top-0">
               <div class="row user-tabs">
                    <div class="col-lg-12 col-12">
                         <ul class="nav nav-tabs tabs-bordered nav-justified" role="tablist">
                         <li class="nav-item tab">
                              <a class="nav-link active" id="tentang-tab" data-toggle="tab" href="#tentang" role="tab" aria-controls="tentang" aria-selected="true">
                                   <span class="d-block d-sm-none"><i class="fa fa-user"></i></span>
                                   <span class="d-none d-sm-block"><i class="fa fa-user"></i> TENTANG SAYA</span>
                              </a>
                         </li>
                         <li class="nav-item tab">
                              <a class="nav-link" id="penganturan-tab" data-toggle="tab" href="#penganturan" role="tab" aria-controls="penganturan" aria-selected="false">
                                   <span class="d-block d-sm-none"><i class="fa fa-cog"></i></span>
                                   <span class="d-none d-sm-block"><i class="fa fa-cog"></i> PENGATURAN</span>
                              </a>
                         </li>
                         </ul>
                    </div>
               </div>
               <div class="row">
                    <div class="col-lg-12">
                         <div class="tab-content profile-tab-content">
                         <div class="tab-pane" id="tentang" role="tabpanel" aria-labelledby="tentang-tab">
                              <div class="row">
                                   <div class="col-lg-4">
                                        <!-- Informasi Pribadi -->
                                        <div class="card card-default card-fill">
                                             <div class="card-header bg-primary">
                                             <h3 class="card-title text-white"><i class="mdi mdi-account-tie-outline"></i> INFORMASI PRIBADI</h3>
                                             </div>
                                             <div class="card-body border border-primary">
                                                  <div class="about-info-p">
                                                       <strong>NIP</strong>
                                                       <br>
                                                       <p class="text-muted">{{ session()->get('_nip') }}</p>
                                                  </div>
                                                  <div class="about-info-p">
                                                       <strong>NAMA</strong>
                                                       <br>
                                                       <p class="text-muted">{{ session()->get('_nama_pegawai') }}</p>
                                                  </div>
                                                  <div class="about-info-p">
                                                       <strong>Email</strong>
                                                       <br>
                                                       <p class="text-muted">{{ Auth::user()->email }}</p>
                                                  </div>
                                             </div>
                                        </div>
                                        <!-- Informasi Pribadi -->

                                   </div>

                                   <div class="col-lg-8">
                                        <div class="card card-default card-fill">
                                             <div class="card-header bg-primary">
                                             <h3 class="card-title text-white">Skills</h3>
                                             </div>
                                             <div class="card-body border border-primary">
                                             <div class="mb-4">
                                                  <h6>Angular Js <span class="float-right">60%</span></h6>
                                                  <div class="progress progress-sm">
                                                       <div class="progress-bar bg-primary wow animated progress-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                            <span class="sr-only">60% Complete</span>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="mb-4">
                                                  <h6>Javascript <span class="float-right">90%</span></h6>
                                                  <div class="progress progress-sm">
                                                       <div class="progress-bar bg-pink wow animated progress-animated" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                                            <span class="sr-only">90% Complete</span>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="mb-4">
                                                  <h6>Wordpress <span class="float-right">80%</span></h6>
                                                  <div class="progress progress-sm">
                                                       <div class="progress-bar bg-purple wow animated progress-animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                            <span class="sr-only">80% Complete</span>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="mb-0">
                                                  <h6>HTML5 &amp; CSS3 <span class="float-right">95%</span></h6>
                                                  <div class="progress progress-sm mb-0">
                                                       <div class="progress-bar bg-info wow animated progress-animated" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                                                            <span class="sr-only">95% Complete</span>
                                                       </div>
                                                  </div>
                                             </div>

                                             </div>
                                        </div>

                                   </div>

                              </div>
                         </div>
                         <div class="tab-pane show active" id="penganturan" aria-labelledby="penganturan-tab">
                              <div class="row">
                                   <!-- Ubah Password -->
                                   <div class="col-lg-4 col-12">
                                        <div class="card card-default card-fill">
                                             <div class="card-header bg-primary">
                                                  <h3 class="card-title text-white"><i class="mdi mdi-key-outline"></i> UBAH PASSWORD</h3>
                                             </div>
                                             <div class="card-body border border-primary">
                                                  <form method="post" action="javascript:void(0)">
                                                       <div class="form-group">
                                                            <label for="pawword_lama">PASSWORD LAMA</label>
                                                            <input type="password" required placeholder="Masukan password lama" id="pawword_lama" name="pawword_lama" class="form-control form-control-lg">
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="pawword_baru">PASSWORD BARU</label>
                                                            <input type="password" required min="8" placeholder="Masukan password baru" id="pawword_baru" name="pawword_baru" class="form-control form-control-lg">
                                                       </div>
                                                       <div class="form-group">
                                                            <label for="ulangi_pawword_baru">ULANGI PASSWORD BARU</label>
                                                            <input type="password" required min="8" placeholder="Masukan ulangi password baru" id="ulangi_pawword_baru" name="ulangi_pawword_baru" class="form-control form-control-lg">
                                                       </div>
                                                       <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
                                                  </form>
                                             </div>
                                        </div>
                                   </div>
                                   <!-- Ubah Password -->
                                   <!-- Ubah Data Diri -->
                                   <div class="col-lg-8 col-12">
                                        <div class="card card-default card-fill">
                                             <div class="card-header bg-primary">
                                                  <h3 class="card-title text-white"><i class="mdi mdi-account-edit-outline"></i> EDIT PROFIL</h3>
                                             </div>
                                             <div class="card-body border border-primary">
                                                  <form method="post" class="row" action="javascript:void(0)">
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="nip">NIP</label>
                                                                 <input type="number" disabled required placeholder="Masukan NIP" id="nip" name="nip" class="form-control form-control-lg">
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="pin_absen">PIN ABSEN</label>
                                                                 <input type="number" disabled required placeholder="Masukan pin absen" id="pin_absen" name="pin_absen" class="form-control form-control-lg">
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-12 col-12">
                                                            <div class="form-group">
                                                                 <label for="gelar_depan">NAMA PEGAWAI</label>
                                                                 <div class="row">
                                                                      <div class="col-lg-3 col-12">
                                                                           <input type="text" autocomplete="off" required placeholder="Masukan gelar depan" id="gelar_depan" name="gelar_depan" class="form-control form-control-lg">
                                                                      </div>
                                                                      <div class="col-lg-6 col-12">
                                                                           <input type="text" autocomplete="off" required placeholder="Masukan nama" id="nama" name="nama" class="form-control form-control-lg">
                                                                      </div>
                                                                      <div class="col-lg-3 col-12">
                                                                           <input type="text" autocomplete="off" required placeholder="Masukan gelar belakang" id="gelar_belakang" name="gelar_belakang" class="form-control form-control-lg">
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="email">EMAIL</label>
                                                                 <input type="email" required disabled placeholder="Masukan email" id="email" name="email" class="form-control form-control-lg">
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="jenis_kelamin">JENIS KELAMIN</label><br>
                                                                 <div class="radio radio-info form-check-inline">
                                                                      <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="checked">
                                                                      <label for="inlineRadio1"> Inline One </label>
                                                                 </div>
                                                                 <div class="radio form-check-inline">
                                                                      <input type="radio" id="inlineRadio2" value="option2" name="radioInline">
                                                                      <label for="inlineRadio2"> Inline Two </label>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="tempat_lahir">TEMPAT LAHIR</label>
                                                                 <input type="text" autocomplete="off" required placeholder="Masukan tempat lahir" id="tempat_lahir" name="tempat_lahir" class="form-control form-control-lg">
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="tanggal_lahir">TANGGAL LAHIR</label>
                                                                 <input type="text" autocomplete="off" required placeholder="Masukan tanggal lahir" id="tanggal_lahir" name="tanggal_lahir" class="form-control form-control-lg tanggal-sebelumnya">
                                                            </div>
                                                       </div>
                                                       <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                 <label for="pin_absen">PIN ABSEN</label>
                                                                 <input type="number" disabled required placeholder="Masukan pin absen" id="pin_absen" name="pin_absen" class="form-control form-control-lg">
                                                            </div>
                                                       </div>
                                                       <div class="col-12">
                                                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i class="mdi mdi-content-save"></i> <span>SIMPAN</span></button>
                                                       </div>
                                                  </form>
                                             </div>
                                        </div>
                                   </div>
                                   <!-- Ubah Data Diri -->
                              </div>
                         </div>
                    </div>
               </div>
            </div>
        </div>
</div>
@endsection
@push('javascript')
@endpush