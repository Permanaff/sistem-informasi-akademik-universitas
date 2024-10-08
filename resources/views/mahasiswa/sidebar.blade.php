<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title text-center" id="sidebarMenuLabel">SIAKAD</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" aria-current="page" href="/std">
              <svg class="bi"><use xlink:href="#house-fill"/></svg>
              Dashboard
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
            <span>Akademik</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
              <i class="bi bi-building"></i>
            </a>
          </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/std/scanabsen">
              <i class="fa fa-qrcode" aria-hidden="true"></i>
              Scan Presensi
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/adm/prodi">
              <i class="bi bi-building"></i>
              Prodi
            </a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/std/khs">
              <i class="bi bi-book"></i>
              KHS
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/std/krs">
              <i class="fa fa-book" aria-hidden="true"></i>
              Input KRS
            </a>
          </li>

          {{-- <hr class="my-1 mx-4"> --}}

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/std/cetakkrs">
              <i class="fa fa-print" aria-hidden="true"></i>
              Cetak KRS
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/std/kehadiran">
              <i class="fa fa-id-card" aria-hidden="true"></i>
              Kehadiran
            </a>
          </li>
        </ul>
  
        {{-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
          <span>Infrastruktur</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <svg class="bi"><use xlink:href="#plus-circle"/></svg>
          </a>
        </h6>
        <ul class="nav flex-column mb-auto">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="/adm/kelas">
              <i class="bi bi-house"></i>
              Ruang Kelas
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#file-earmark-text"/></svg>
              Year-end sale
            </a>
          </li> --}}
        </ul>
  
        {{-- <hr class="my-3"> --}}
  
        {{-- <ul class="nav flex-column mb-auto">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#gear-wide-connected"/></svg>
              Settings
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#door-closed"/></svg>
              Sign out
            </a>
          </li>
        </ul> --}}
  
      </div>
    </div>
  </div>
  {{-- SIDEBAR END --}}