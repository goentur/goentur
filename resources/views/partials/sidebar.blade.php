<ul class="metismenu" id="side-menu">
                @role('pegawai')
        <li>
                            <a href="{{ '/pegawai/dashboard' }}" class="waves-effect">
                                <i class="mdi mdi-home"></i>
                                <span> <b>DASHBOARD</b> </span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="mdi mdi-account-circle-outline"></i>
                                <span> <b>PROFIL & JABATAN</b> </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{ '/pegawai/profil' }}"><i class="mdi mdi-account-box"></i> <b>PROFIL</b></a></li>
                                <li><a href="{{ '/pegawai/jabatan' }}"><i class="mdi mdi-account-box"></i> <b>JABATAN & ATASAN</b></a></li>
                                <li><a href="{{ '/pegawai/riwayat-jabatan' }}"><i class="mdi mdi-account-group"></i> <b>RIWAYAT JABATAN</b></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="mdi mdi-settings"></i>
                                <span> <b>SKP</b> </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{ '/pegawai/tupoksi' }}"><i class="mdi mdi-clipboard-text"></i> <b>RENCANA KINERJA</b></a></li>
                                <li><a href="{{ '/pegawai/periode-skp' }}"><i class="mdi mdi-calendar-account"></i> <b>PERIODE SKP</b></a></li>
                                <li><a href="{{ '/pegawai/skp' }}"><i class="mdi mdi-clipboard-plus"></i> <b>MEMBUAT SKP</b></a></li>
                                <li><a href="{{ '/pegawai/breakdown-skp' }}"><i class="mdi mdi-clipboard-list"></i> <b>BREAKDOWN SKP</b></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="mdi mdi-calendar-month"></i>
                                <span> <b>KEGIATAN</b> </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{ '/pegawai/kegiatan-harian' }}"><i class="mdi mdi-calendar-month-outline"></i> <b>HARIAN</b></a></li>
                                <li><a href="{{ '/pegawai/kegiatan-bulanan' }}"><i class="mdi mdi-calendar-weekend-outline"></i> <b>BULANAN</b></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="mdi mdi-clipboard-check-outline"></i>
                                <span> <b>VERIFIKASI</b> </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{ '/pegawai/verifikasi-skp' }}"><i class="mdi mdi-file-check"></i> <b>SKP PNS</b></a></li>
                                <li><a href="{{ '/pegawai/verifikasi-aktivitas' }}"><i class="mdi mdi-file-document-box-check"></i> <b>AKTIVITAS PNS</b></a></li>
                            </ul>
                        </li>
                        @endrole
</ul>
