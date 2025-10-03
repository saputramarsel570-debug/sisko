<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ route('orangtua.dashboard') }}" class="app-brand-link">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('/img/gambar.png') }}" alt="Logo SISKO">
                  </span>
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bold">SISKO App</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Main</span>
              </li>
            <li class="menu-item"><li class="menu-item {{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}">
                <a href="{{ route('orangtua.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-home"></i>
                    Dashboard
                </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">AKADEMIK</span>
              </li>
            <li class="menu-item {{ request()->routeIs('orangtua.absensi.*') ? 'active' : '' }}">
              <a href="{{ route('orangtua.absensi.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-clipboard-check"></i>
                  Absensi Siswa
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('orangtua.jadwal_ekskul.*') ? 'active' : '' }}">
              <a href="{{ route('orangtua.jadwal_ekskul.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons ti ti-calendar"></i>
                  <span>Jadwal Ekskul</span>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">INFORMASI & KOMUNIKASI</span>
              </li>
            <li class="menu-item {{ request()->routeIs('orangtua.pengumuman.*') ? 'active' : '' }}">
              <a href="{{ route('orangtua.pengumuman.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-news"></i>
                Pengumuman Sekolah
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('orangtua.keluhan.*') ? 'active' : '' }}">
              <a href="{{ route('orangtua.keluhan.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-message"></i>
                Keluhan & Saran
              </a>
            </li>
          </ul>
        </aside>
