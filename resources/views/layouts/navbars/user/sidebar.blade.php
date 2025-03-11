<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('user.dashboard') }}">
            <img src="{{ asset('assets/img/univaultlogo.png') }}" class="navbar-brand-img h-100" alt="UNIVAULT">
            <span class="ms-3 font-weight-bold">UNIVAULT</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user/dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- Profile Management Section --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Profile Management</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">My Profile</span>
                </a>
            </li>
          

            {{-- Stock Management Section --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Stock Management</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user/stocks') ? 'active' : '' }}" href="{{ route('user.tables') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-box text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">View Stocks</span>
                </a>
            </li>

            {{-- Request Management Section --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Request Management</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user/requests') ? 'active' : '' }}" href="{{ route('user.requests.createreq') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-alt text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">New Request</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user/requests') ? 'active' : ''}} " href="{{ route('user.requests.viewrequests') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-list text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">My Requests</span>
                </a>
            </li>
        </ul>
    </div>
</aside>