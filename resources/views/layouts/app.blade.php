<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>@yield('title', 'Velora') | Vehicle Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    {{-- Boxicons CDN --}}
    <link
      href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />

    {{-- Perfect Scrollbar --}}
    <link
      rel="stylesheet"
      href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"
    />

    {{-- Core Sneat CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    {{-- Per-page CSS --}}
    @yield('page-css')

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#696cff">
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

               {{-- =============== SIDEBAR =============== --}}
        @include('layouts.partials.sidebar')
        {{-- =============== /SIDEBAR =============== --}}

        {{-- =============== MAIN CONTENT AREA =============== --}}
        <div class="layout-page">

          {{-- =============== NAVBAR =============== --}}
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            {{-- Mobile menu toggle --}}
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

              {{-- Search --}}
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2"
                    placeholder="Search..."
                    aria-label="Search"
                  />
                </div>
              </div>

              <ul class="navbar-nav flex-row align-items-center ms-auto">

                {{-- Branch badge (non-superadmin) --}}
                @if(auth()->check() && auth()->user()->role !== 'superadmin' && auth()->user()->branch)
                <li class="nav-item me-2 me-xl-3">
                  <span class="badge bg-label-primary">
                    <i class="bx bx-map-pin me-1"></i>
                    {{ auth()->user()->branch->city }}
                  </span>
                </li>
                @endif

                {{-- Notifications --}}
                <li class="nav-item navbar-dropdown dropdown-user dropdown me-2 me-xl-0">
                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="bx bx-bell bx-sm"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h5 class="text-body mb-0 me-auto fw-semibold">Notifications</h5>
                      </div>
                    </li>
                    <li class="p-3 text-center text-muted small">No new notifications</li>
                  </ul>
                </li>
                {{-- User dropdown --}}
<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            @if(auth()->check() && auth()->user()->profile_picture)
                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                     class="w-px-40 h-auto rounded-circle" alt="Avatar">
            @else
                <span class="avatar-initial rounded-circle bg-label-primary">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </span>
            @endif
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block">{{ auth()->user()->name ?? 'User' }}</span>
                        <small class="text-muted">
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->role?->value ?? '')) }}
                        </small>
                    </div>
                </div>
            </a>
        </li>
        <li><div class="dropdown-divider"></div></li>
        <li>
    <a class="dropdown-item" href="{{ route('profile.edit') }}">
        <i class="bx bx-user me-2"></i>
        <span class="align-middle">My Profile</span>
    </a>
</li>
        <li><div class="dropdown-divider"></div></li>
        <li>
            <a class="dropdown-item text-danger" href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
            </a>
        </li>
    </ul>
</li>

              </ul>
            </div>
          </nav>
          {{-- =============== /NAVBAR =============== --}}

          {{-- =============== PAGE CONTENT =============== --}}
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">

              {{-- Page Heading (optional per page) --}}
              @hasSection('page-title')
              <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">VDMS /</span>
                @yield('page-title')
              </h4>
              @endif

              @yield('content')

            </div>

            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                 &copy; {{ date('Y') }} <strong>Velora</strong> — Vehicle Management System
                </div>
                <div class="text-muted small">v1.0.0</div>
              </div>
            </footer>

            <div class="content-backdrop fade"></div>
          </div>
          {{-- =============== /PAGE CONTENT =============== --}}

        </div>
        {{-- /layout-page --}}

      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    {{-- /layout-wrapper --}}

    {{-- =============== SCRIPTS =============== --}}
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>



    <script>
// Sidebar toggle fix
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.layout-menu-toggle');
    const layoutMenu = document.getElementById('layout-menu');
    const layoutPage = document.querySelector('.layout-page');
    
    if(menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.layout-wrapper').classList.toggle('layout-menu-expanded');
        });
    }
});
</script>


@stack('scripts')

    <script>
    // Password Toggle Eye Icon (All Forms)
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove('bx-hide');
                    this.classList.add('bx-show');
                } else {
                    input.type = "password";
                    this.classList.remove('bx-show');
                    this.classList.add('bx-hide');
                }
            });
        });
    });
    </script>

    @yield('page-scripts')


    @section('page-scripts')
<script>
// Offline Sync Manager - Global
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Offline Sync Manager Loaded');

    // Attach to all forms that have data-model attribute
    document.querySelectorAll('form[data-model]').forEach(form => {
        form.addEventListener('submit', async function(e) {
            if (navigator.onLine) return;

            e.preventDefault();
            console.log('🌐 Offline Mode - Saving to local queue');

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                await syncManager.addToLocalQueue({
                    model_type: this.dataset.model || 'Vehicle',
                    operation: this.dataset.operation || 'create',
                    payload: data,
                    timestamp: new Date().toISOString()
                });

                alert('🌐 OFFLINE MODE\n\nData has been saved locally.\nIt will automatically sync when internet is back.');
                this.reset();
            } catch(err) {
                console.error(err);
                alert('❌ Failed to save offline.');
            }
        });
    });
});
</script>
@endsection


<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('Velora SW registered:', reg.scope))
            .catch(err => console.log('SW registration failed:', err));
    });

    // Listen for sync message from SW
    navigator.serviceWorker.addEventListener('message', (event) => {
        if (event.data.type === 'SYNC_REQUIRED') {
            // Trigger sync
            const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
            if (pending.length > 0) {
                console.log('Syncing', pending.length, 'pending items...');
            }
        }
    });
}

// Global online/offline indicator
window.addEventListener('offline', () => {
    showConnectionBadge('offline');
});
window.addEventListener('online', () => {
    showConnectionBadge('online');
});

function showConnectionBadge(status) {
    const existing = document.getElementById('connection-badge');
    if (existing) existing.remove();

    const badge = document.createElement('div');
    badge.id = 'connection-badge';
    badge.style.cssText = `
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        background: ${status === 'online' ? '#71dd37' : '#ff3e1d'};
        color: white;
        padding: 10px 24px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        animation: slideUp 0.3s ease;
    `;
    badge.innerHTML = status === 'online'
        ? "<i class='bx bx-wifi'></i> Back Online — Syncing..."
        : "<i class='bx bx-wifi-off'></i> You're Offline — Data saved locally";
    document.body.appendChild(badge);

    if (status === 'online') {
        setTimeout(() => badge.remove(), 4000);
    }
}
</script>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translate(-50%, 20px); }
    to { opacity: 1; transform: translate(-50%, 0); }
}
</style>

  </body>
</html>
