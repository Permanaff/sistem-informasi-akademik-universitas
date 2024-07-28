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

  .card-rounded-bottom {
    border-top-left-radius: 0px; 
    border-top-right-radius: 0px;
  }

  .card-rounded-top {
    border-bottom-left-radius: 0px; 
    border-bottom-right-radius: 0px;
  }

  .col-nilai {
    width: 90px
  }
</style>


<!-- Custom styles for this template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('/css/krstables.css') }}" rel="stylesheet"> --}}
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
    <h1 class="h2">Nilai Mahasiswa</h1>
  </div>
  <div class="card card-rounded-top">
    <div class="card-header">
      <p class="fs-6 m-0">Daftar Mahasiswa</p>
    </div>
    <div class="card-body">
      <form action="{{ route('nilaimahasiswa.show') }}" method="POST">
        @csrf
        <div class="container col-md-8">
          <select class="form-select" aria-label="kelas" name="kelas" id="kelas">
            <option value="0" selected>--- Pilih Kelas ---</option>
            @foreach ($jadwal as $jdwl)
              <option value="{{ $jdwl->id }}">{{ $jdwl->matkul->nama_matkul }} - Kelas {{ $jdwl->kls }}</option>
            @endforeach
          </select>
          <div class="d-flex justify-content-end mt-2" id="buttonContainer">
            <button type="submit" class="btn btn-success">Tampilkan</button>
          </div>
      </form>
      </div>
    </div>
  </div>

  @if (isset($mahasiswa) && !empty($mahasiswa))
  <div class="card mt-3 card-rounded-bottom">
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th class="text-center" scope="col" rowspan="2">No</th>
                    <th class="text-center" scope="col" rowspan="2">NPM</th>
                    <th class="text-center" scope="col" rowspan="2">Nama Mahasiswa</th>
                    <th class="text-center" scope="col" colspan="7">Nilai</th>
                </tr>
                <tr>
                    <th class="text-center col-nilai" scope="col">CPMK 1</th>
                    <th class="text-center col-nilai" scope="col">CPMK 2</th>
                    <th class="text-center col-nilai" scope="col">CPMK 3</th>
                    <th class="text-center col-nilai" scope="col">CPMK 4</th>
                    <th class="text-center col-nilai" scope="col">UTS</th>
                    <th class="text-center col-nilai" scope="col">UAS</th>
                    <th class="text-center col-nilai" scope="col">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswa as $index => $mhs)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="text-center">{{ $mhs['nim'] }}</td>
                      <td class="text">{{ $mhs['nama'] }}</td>
                      {{-- <td class="text-center">{{ $mhs['nilai'] }}</td> --}}
                      @foreach ($mhs['nilai'] as $nilai)
                          <td class="text-center">{{ $nilai }}</td>
                      @endforeach
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="10">Data Jadwal Belum Tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  </div>
  @endif

  

</main>
{{-- CONTENT END --}}
</div>
</div>

@section('scripts')
<script src="{{ asset('/js/dashboard.js') }}"></script>
{{-- <script src="{{ asset('/js/dosen/daftar-mahasiswa.js') }}"></script> --}}
@endsection
@endsection

