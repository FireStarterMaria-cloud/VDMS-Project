<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
   <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
        <span class="app-brand-logo demo">
            <img src="{{ asset('assets/img/logo/velora_logo.svg') }}"
                 alt="Velora" style="height:28px;">
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2">VELORA</span>
    </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div>Dashboard</div>
            </a>
        </li>

      @if(auth()->user()->isChairwoman())
<li class="menu-item {{ request()->routeIs('showrooms.*') || request()->routeIs('company.*') || request()->is('investor') ? 'open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div>Company</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('showrooms.index') || request()->routeIs('showrooms.create') || request()->routeIs('showrooms.edit') ? 'active' : '' }}">
    <a href="{{ route('showrooms.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-building-house"></i>
        <div>Showrooms</div>
    </a>
</li>
       <li class="menu-item {{ request()->routeIs('investment-inquiries.*') ? 'active' : '' }}">
    <a href="{{ route('investment-inquiries.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-line-chart"></i>
        <div>Investors</div>
    </a>
</li>
       <li class="menu-item {{ request()->routeIs('showrooms.overview') ? 'active' : '' }}">
    <a href="{{ route('showrooms.overview') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-globe"></i>
        <div>White Cells</div>
    </a>
</li>
    </ul>
</li>
@endif

        <li class="menu-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
            <a href="{{ route('vehicles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-car"></i>
                <div>Vehicles</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <a href="{{ route('sales.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>Sales</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Customers</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <a href="{{ route('payments.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div>Payments</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <a href="{{ route('invoices.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div>Invoices</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <a href="{{ route('purchases.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-purchase-tag-alt"></i>
                <div>Purchases</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('branch-transfers.*') ? 'active' : '' }}">
            <a href="{{ route('branch-transfers.index') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-transfer"></i>
    <div>Branch Transfers</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Administration</span>
        </li>

        @if(auth()->check() && auth()->user()->isHO())
        <li class="menu-item {{ request()->routeIs('branches.*') ? 'active' : '' }}">
            <a href="{{ route('branches.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div>Branches</div>
            </a>
        </li>
        @endif

        @if(auth()->check() && auth()->user()->isHO())
        <li class="menu-item {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
           
        <a href="{{ route('analytics.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-line-chart"></i>
                <div>Analytics</div>
            </a>
        </li>
        @endif

        @if(auth()->check() && auth()->user()->isHO())
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>Users</div>
            </a>
        </li>
        @endif

        @if(auth()->check() && auth()->user()->isSuperAdmin())
        <li class="menu-item {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
           <a href="{{ route('audit-logs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div>Audit Logs</div>
            </a>
        </li>
        @endif

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Account</span>
        </li>

        <li class="menu-item">
           <a href="{{ route('settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>Settings</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div>Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
</aside>