<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link bg-primary">
        <img src="{{ Storage::url($instansi->logo_instansi) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Sistem Informasi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @can('user_management_access')
                <li class="nav-header">MANAJEMEN USER</li>
                <li class="nav-item {{ set_active(['permission.index', 'role.index', 'users.index']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ set_active(['permission.index', 'role.index', 'users.index']) }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Management Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('permission_access')
                        <li class="nav-item">
                            <a href="{{ route('permission.index') }}" class="nav-link {{ set_active(['permission.index']) }}">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        @endcan
                        @can('role_access')
                        <li class="nav-item">
                            <a href="{{ route('role.index') }}" class="nav-link {{ set_active(['role.index']) }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        @endcan
                        @can('user_access')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ set_active(['users.index']) }}">
                                <i class="fas fa-user nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @hasrole('admin')
                <li class="nav-header">MASTER DATA</li>
                @else
                <li class="nav-header">MENU USER</li>
                @endhasrole

                @can('instansi_access')
                <li class="nav-item">
                    <a href="{{ route('instansi.index') }}" class="nav-link {{ set_active(['instansi.index']) }}">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            Profil Sekolah
                        </p>
                    </a>
                </li>
                @endcan

                @can('tahun_ajaran_access')
                <li class="nav-item">
                    <a href="{{ route('tahun-ajaran.index') }}" class="nav-link {{ set_active(['tahun-ajaran.index']) }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Tahun Pelajaran
                        </p>
                    </a>
                </li>
                @endcan

                @can('kurikulum_access')
                <li class="nav-item">
                    <a href="{{ route('kurikulum.index') }}" class="nav-link {{ set_active(['kurikulum.index']) }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Kurikulum
                        </p>
                    </a>
                </li>
                @endcan

                @can('sarana_prasarana_management_access')
                <li class="nav-item {{ set_active(['kelas.index','ruangan.index']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ set_active(['kelas.index', 'ruangan.index']) }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Sarana Prasarana
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('ruangan_access')
                        <li class="nav-item">
                            <a href="{{ route('ruangan.index') }}" class="nav-link {{ set_active(['ruangan.index']) }}">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Ruangan</p>
                            </a>
                        </li>
                        @endcan

                        @can('kelas_access')
                        <li class="nav-item">
                            <a href="{{ route('kelas.index') }}" class="nav-link {{ set_active(['kelas.index']) }}">
                                <i class="fas fa-school nav-icon"></i>
                                <p>Kelas</p>
                            </a>
                        </li>
                        @endcan

                        @can('sarana_administrasi_access')
                        <li class="nav-item">
                            <a href="pages/charts/chartjs.html" class="nav-link">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Sarana Administrasi</p>
                            </a>
                        </li>
                        @endcan

                        @can('sarana_pembelajaran_access')
                        <li class="nav-item">
                            <a href="pages/charts/inline.html" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Sarana Pembelajaran</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('sarana_prasarana_management_access')
                <li class="nav-item">
                    <a href="{{ route('rombel.index') }}" class="nav-link {{ set_active(['rombel.index']) }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Rombongan Belajar
                        </p>
                    </a>
                </li>
                @endcan

                @can('peserta_didik_access')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Peserta Didik
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('siswa_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Daftar Siswa</p>
                            </a>
                        </li>
                        @endcan

                        @can('mutasi_masuk_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Mutasi Masuk</p>
                            </a>
                        </li>
                        @endcan

                        @can('mutasi_keluar_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Mutasi Keluar</p>
                            </a>
                        </li>
                        @endcan

                        @can('kenaikan_kelas_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Kenaikan Kelas</p>
                            </a>
                        </li>
                        @endcan

                        @can('kelulusan_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Kelulusan</p>
                            </a>
                        </li>
                        @endcan

                        @can('alumni_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Daftar Alumni</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('guru_tenaga_access')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Guru dan Tenaga
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('gtk_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        @endcan
                        @can('mutasi_gtk_masuk_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Mutasi Masuk</p>
                            </a>
                        </li>
                        @endcan
                        @can('mutasi_gtk_keluar_access')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-unlock-alt nav-icon"></i>
                                <p>Mutasi Keluar</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{--  <li class="nav-header">KELOLA DATA</li>  --}}
                <li class="nav-item">
                    <a href="#" onclick="document.querySelector('#form-logout').submit()" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Keluar
                        </p>
                    </a>

                    <form action="{{ route('logout') }}" id="form-logout" method="post">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
