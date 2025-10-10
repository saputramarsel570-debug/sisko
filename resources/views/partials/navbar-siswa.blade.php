<nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <i class="ti ti-search ti-md me-2 me-lg-4 ti-lg"></i>
                    <span class="d-none d-md-inline-block text-muted fw-normal">Search (Ctrl+/)</span>
                  </a>
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">


                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown">
                  <a
                    class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ti ti-md"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                        <span class="align-middle"><i class="ti ti-sun ti-md me-3"></i>Light</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                        <span class="align-middle"><i class="ti ti-moon-stars ti-md me-3"></i>Dark</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                        <span class="align-middle"
                          ><i class="ti ti-device-desktop-analytics ti-md me-3"></i>System</span
                        >
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- / Style Switcher-->

                <!-- Notification -->
                @php
  $notifications = auth()->user()->notifications()->latest()->take(10)->get();
  $unreadCount = auth()->user()->unreadNotifications->count();
@endphp

<li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
  <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
     href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="position-relative">
      <i class="ti ti-bell ti-md"></i>
      @if($unreadCount > 0)
        <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
      @endif
    </span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end p-0">
    <li class="dropdown-menu-header border-bottom">
      <div class="dropdown-header d-flex align-items-center py-3">
        <h6 class="mb-0 me-auto">Notifikasi</h6>
        <span class="badge bg-label-primary me-2">{{ $unreadCount }} Baru</span>
      </div>
    </li>
    <li class="dropdown-notifications-list scrollable-container">
      <ul class="list-group list-group-flush">
        @foreach($notifications as $notif)
            <li class="list-group-item list-group-item-action dropdown-notifications-item {{ $notif->read_at ? 'marked-as-read' : '' }}">
              <a href="{{ $notif->data['url'] ?? route('notifications.read', $notif->id) }}" class="d-flex text-decoration-none">
                <div class="flex-grow-1">
                  <h6 class="small mb-1">{{ $notif->data['title'] ?? 'Notifikasi Baru' }}</h6>
                    <small class="mb-1 d-block text-body">{{ $notif->data['message'] ?? 'Tidak ada detail.' }}</small>
                  <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
              </a>
            </li>
        @endforeach
      </ul>
    </li>
  </ul>
</li>
                <!--/ Notification -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center gap-1">
                        <div class="avatar avatar-online">
                            <img src="{{ Auth::user()->profile_photo ? asset('uploads/profile/' . Auth::user()->profile_photo) : asset('/img/avatars/1.png') }}" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" />
                        </div>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item mt-0" href="{{ route('siswa.profile') }}">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                                <img src="{{ Auth::user()->profile_photo ? asset('uploads/profile/' . Auth::user()->profile_photo) : asset('/img/avatars/1.png') }}" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('siswa.profile') }}">
                        <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                      <div class="d-grid px-2 pt-2 pb-1">
                        <a class="btn btn-sm btn-danger d-flex" onclick="$('#logout-form').submit()" href="javascript:void(0);">
                          <small class="align-middle">Logout</small>
                          <i class="ti ti-logout ms-2 ti-14px"></i>
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                          @csrf
                        </form>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
              <input
                type="text"
                class="form-control search-input container-xxl border-0"
                placeholder="Search..."
                aria-label="Search..." />
              <i class="ti ti-x search-toggler cursor-pointer"></i>
            </div>
          </nav>
