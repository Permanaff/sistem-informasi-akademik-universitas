@extends('layout/layout')

@section('head')
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  .b-example-divider {
    width: 100%;
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
  }

  .b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
  }

  .bi {
    vertical-align: -.125em;
    fill: currentColor;
  }

  .nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
  }

  .nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
  }

  .btn-bd-primary {
    --bd-violet-bg: #712cf9;
    --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

    --bs-btn-font-weight: 600;
    --bs-btn-color: var(--bs-white);
    --bs-btn-bg: var(--bd-violet-bg);
    --bs-btn-border-color: var(--bd-violet-bg);
    --bs-btn-hover-color: var(--bs-white);
    --bs-btn-hover-bg: #6528e0;
    --bs-btn-hover-border-color: #6528e0;
    --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
    --bs-btn-active-color: var(--bs-btn-hover-color);
    --bs-btn-active-bg: #5a23c8;
    --bs-btn-active-border-color: #5a23c8;
  }

  .bd-mode-toggle {
    z-index: 1500;
  }

  .bd-mode-toggle .dropdown-menu .active .bi {
    display: block !important;
  }
</style>


<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    
<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
  <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
          id="bd-theme"
          type="button"
          aria-expanded="false"
          data-bs-toggle="dropdown"
          aria-label="Toggle theme (auto)">
    <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
    <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
  </button>
  <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
    <li>
      <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
        Light
        <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
      </button>
    </li>
    <li>
      <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
        Dark
        <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
      </button>
    </li>
    <li>
      <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
        Auto
        <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
      </button>
    </li>
  </ul>
</div>
@include('admin/navbar')



<div class="container-fluid">
{{-- SIDEBARD --}}
<div class="row">
@include('dosen/sidebar')

{{-- CONTENT --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Presensi</h1>
  </div>

  <div class="container-sm col-md-8">
    <div class="card">
      <div class="card-content">
        <div class="card-body">

          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">MataKuliah</label>
            <select class="form-select" aria-label="Default select example" name="matkul" id="matkul">
              <option selected>--- Pilih Matakuliah ---</option>
              @foreach ($jadwals as $jadwal)
                <option value="{{ $jadwal->id }}">{{ $jadwal->matkul->nama_matkul }} - {{ $jadwal->kls }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Pertemuan</label>
            <select class="form-select" aria-label="Default select example" name="pertemuan" id="pertemuan">
              <option selected>--- Pilih Pertemuan ---</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="1">9</option>
              <option value="2">10</option>
              <option value="3">11</option>
              <option value="4">12</option>
              <option value="5">13</option>
              <option value="6">14</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">Masa Berlaku</label>
            <div class="row">
              <div class="col">
                <input type="datetime-local" class="form-control" id="mulai" value="{{ \Carbon\Carbon::parse(now())->format('Y-m-d\TH:i') }}"> 
              </div>
              <div class="col-1">
                <h4 class="text-center fw-bold">-</h4>
              </div>
              <div class="col">
                <input type="datetime-local" class="form-control" id="batas">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container col-md-8 justify-content-center mt-3">
    <div class="row">
      <div class="mt-3" id="qr-image-container"></div>
      <div id="inputKode">
         
      </div>
      <div class="d-flex container justify-content-center">
        <button type="button" class="btn btn-success w-25 mt-3" onclick="event.preventDefault(), sendData()">Buat Presensi</button>
      </div>
    </div>
  </div>


  

  

  
</main>
{{-- CONTENT END --}}
</div>
</div>

@section('scripts')
<script src="{{ asset('/js/dashboard.js') }}"></script>
<script src="{{ asset('/js/dosen/presensi.js') }}"></script>

@endsection
@endsection

