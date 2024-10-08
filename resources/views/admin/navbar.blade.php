{{-- NAVBAR --}}
<header class="navbar sticky-top bg-main flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-4 fw-bold text-white text-center" href="{{ url('/std') }}">
      <img src="{{ asset('/images/logo-circle.png') }}" alt="logo" width="35px">
      | SIA UNIV</a>
    
    <ul class="navbar-nav flex-row d-md-none">
    <li class="nav-item text-nowrap">
      <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
        <svg class="bi"><use xlink:href="#search"/></svg>
      </button>
    </li>
    <li class="nav-item text-nowrap">
      <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg class="bi"><use xlink:href="#list"/></svg>
      </button>
    </li>
    </ul>
    
    <div id="navbarSearch" class="navbar-search w-100">
    <div class="d-flex justify-content-end px-3">
      <a href="{{ url('logout') }}" class="btn btn-danger">Logout</a>
    </div>
    {{-- <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search"> --}}
    </div>
</header>
    {{-- NAVBAR END --}}