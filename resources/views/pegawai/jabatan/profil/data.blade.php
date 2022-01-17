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
                                                  <h3 class="card-title text-white">Edit Profile</h3>
                                             </div>
                                             <div class="card-body border border-primary">
                                                  <form>
                                                       <div class="form-group">
                                                       <label for="FullName">Full Name</label>
                                                       <input type="text" value="John Doe" id="FullName" class="form-control">
                                                       </div>
                                                       <div class="form-group">
                                                       <label for="Email">Email</label>
                                                       <input type="email" value="first.last@example.com" id="Email" class="form-control">
                                                       </div>
                                                       <div class="form-group">
                                                       <label for="Username">Username</label>
                                                       <input type="text" value="john" id="Username" class="form-control">
                                                       </div>
                                                       <div class="form-group">
                                                       <label for="Data Diri">Data Diri</label>
                                                       <input type="Data Diri" placeholder="6 - 15 Characters" id="Data Diri" class="form-control">
                                                       </div>
                                                       <div class="form-group">
                                                       <label for="ReData Diri">Re-Data Diri</label>
                                                       <input type="Data Diri" placeholder="6 - 15 Characters" id="ReData Diri" class="form-control">
                                                       </div>
                                                       <div class="form-group">
                                                       <label for="AboutMe">About Me</label>
                                                       <textarea style="height: 125px" id="AboutMe" class="form-control">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</textarea>
                                                       </div>
                                                       <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
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